<script>

export default {
    emits: ['Delete_Rekv','Change_Cur_Rekv'],
    props: ['item','cur_recv_id'],
    data() {
        return {
            edit: false,
            save: false,
            file: '',
            error: ''
        }
    },
    methods: {
        load_file(){
            let file = this.$refs.file_item.files[0];
            this.file = file;
            if(this.$refs.change_file)
            {
                this.$refs.change_file.innerHTML = file.name;
            }
            if(this.$refs.add_file)
            {
                this.$refs.add_file.innerHTML = file.name;
            }
            this.save = true;
        },
        Show_Save: function () {
            if(this.condition_fields)
            {
                this.save = true;
            }
            else
            {
                this.save = false;
            }
        },
        Save_Item: function(){

            let formData = new FormData();
            if(this.file != '')
            {
                let date = new Date();
	            let time = date.getTime();
                let name = time + '_' + this.file.name;//для уникальности
                this.item.file_name = name;
                formData.append('file', this.file);
                formData.append('file_name', name);
            }
            formData.append('name', this.item.name);
            formData.append('inn', this.item.inn);
            formData.append('kpp', this.item.kpp);
            formData.append('bik', this.item.bik);
            formData.append('check', this.item.check);
            formData.append('bank_name', this.item.bank_name);
            formData.append('id', this.item.id);
            formData.append('cur_detail_id', this.cur_recv_id);
            
            axios.post('/update_rekv',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                ).then(res => {
                let error = res.data.error;
                if(error != '')
                {
                    this.error = error;
                }
                else
                {
                    this.error = '';
                    this.file = '';
                    this.save = false;
                    this.edit = false;
                    if(this.$refs.change_file)
                    {
                        this.$refs.change_file.innerHTML = 'Заменить файл';
                    }
                    if(this.$refs.add_file)
                    {
                        this.$refs.add_file.innerHTML = 'Добавить файл';
                    }
                }
            });
        }
    },
    computed: {

        inn() {
            let inn = this.item.inn;
            return (inn == null || inn == '') ? true : (String(inn).length == 12 || String(inn).length == 10);
        },
        kpp() {
            let kpp = this.item.kpp;
            return (kpp == null || kpp == '') ? true : String(kpp).length == 9;
        },
        bik() {
            let bik = this.item.bik;
            return (bik == null || bik == '') ? true : String(bik).length == 9;
        },
        check() {
            let check = this.item.check;
            return (check == null || check == '') ? true : String(check).length == 20;
        },
        
        condition_fields(){
            return this.inn && this.kpp && this.bik && this.check;
        }
    }
}

</script>

<template>

    <div class="order_item form_box">
        <h2 class="order_title">
            {{ (item.name == null || item.name == '') ? 'Реквизиты №' + item.id : item.name }}
        </h2>

        <div class="grid_box">
            <div class="inp_box">
                <label>Название компании или юр. лица</label>
                <input :class="[{editt: edit}]" @input="Show_Save" :readonly="!edit" v-model="item.name" type="text">
            </div>

            <div class="inp_box">
                <label>ИНН (12 или 10 цифр)</label>
                <input :class="[{error: !inn},{editt: edit}]" @input="Show_Save" :readonly="!edit" v-model="item.inn" type="number">
            </div>

            <div class="inp_box">
                <label>КПП (9 цифр)</label>
                <input :class="[{error: !kpp},{editt: edit}]" @input="Show_Save" :readonly="!edit" v-model="item.kpp" type="number">
            </div>

            <div class="inp_box">
                <label>БИК (9 цифр)</label>
                <input :class="[{error: !bik},{editt: edit}]" @input="Show_Save" :readonly="!edit" v-model="item.bik" type="number">
            </div>

            <div class="inp_box">
                <label>Расчётный счёт (20 цифр)</label>
                <input :class="[{error: !check},{editt: edit}]" @input="Show_Save" :readonly="!edit" v-model="item.check" type="text">
            </div>

            <div class="inp_box">
                <label>Название банка</label>
                <input :class="[{editt: edit}]"  @input="Show_Save" :readonly="!edit" v-model="item.bank_name" type="text">
            </div>

        </div>

        <div class="button_line">
            <button @click="Save_Item" v-if="save" class="univ_button">Сохранить</button>
            <button v-else @click="edit=!edit" class="univ_button">
                {{ edit == false ? 'Редактировать' : 'На редактировании' }}
            </button>

            <button @click="$emit('Delete_Rekv',item.id,item.file_name)" class="univ_button">Удалить</button>

            <input ref="file_item" @change="load_file" type="file" style="display: none;">
            <template v-if="item.file_name != null && item.file_name != ''">
                <a data-fancybox="" :href="'/storage/img/recviz/'+item.file_name" class="univ_button">Посмотреть файл</a>
                <button ref="change_file" @click="this.$refs.file_item.click()" class="univ_button change_file_butt">Заменить файл</button>
            </template>
            <button ref="add_file" v-else class="univ_button" @click="this.$refs.file_item.click()">Добавить файл</button>

            <div class="inp_box check">
                <label>Выбрать</label>
                <input @click="Show_Save(); this.$emit('Change_Cur_Rekv',item.id);" :disabled="!edit" type="checkbox" :checked="item.id == cur_recv_id">
            </div>
        </div>

        <div v-show="error != ''" class="error_text">{{ error }}</div>
    </div>
</template>
