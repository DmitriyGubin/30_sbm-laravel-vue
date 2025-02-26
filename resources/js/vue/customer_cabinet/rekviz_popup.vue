<script>

export default {
    emits: ['Add_Rekv','Clear_Add_Item','Change_Cur_Rekv'],
    props: ['add_item'],
    data() {
        return {
            file: '',
            error: ''
        }
    },
    methods: {
        load_file(){
            this.file = this.$refs.filee.files[0];
            // console.log(this.file.name);
        },
        SubmitRekv(){

            let formData = new FormData();
            if(this.file != '')
            {
                let date = new Date();
	            let time = date.getTime();
                let name = time + '_' + this.file.name;//для уникальности
                this.add_item.file_name = name;
                formData.append('file', this.file);
                formData.append('file_name', name);
            }
            formData.append('name', this.add_item.name);
            formData.append('inn', this.add_item.inn);
            formData.append('kpp', this.add_item.kpp);
            formData.append('bik', this.add_item.bik);
            formData.append('check', this.add_item.check);
            formData.append('bank_name', this.add_item.bank_name);
            axios.post('/add_rekv',
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
                    this.$refs.rekv_form_main.reset();
                    this.$refs.file_button.innerHTML = 'Прикрепите файл';
                    this.add_item.id = res.data.id;
                    this.$emit('Add_Rekv',this.add_item);
                    if(res.data.cur_rekv)
                    {
                        this.$emit('Change_Cur_Rekv',this.add_item.id);
                    }
                    this.$emit('Clear_Add_Item');
                }
            });
        },
    },
    computed: {
        condition_fields(){
            let check = this.add_item.check;
            let inn = this.add_item.inn;
            return (String(inn).length == 12 || String(inn).length == 10) &&
             String(this.add_item.kpp).length == 9 &&
             String(this.add_item.bik).length == 9 &&
             (check == '' ? true : String(check).length == 20);
        },
        condition_file(){
            return this.file != '';
        },
        condition_all() {
            if(this.add_item.inn != '')
            {
                return this.condition_fields;
            }
            else if(this.condition_file)
            {
                return true;
            }
            else if(this.add_item.name != '')
            {
                return true;
            }
            else
            {
                return this.condition_file && this.condition_fields;
            }
        }
    }
}

</script>

<template>
    <div class="univers_popup" style="display: none;" id="rekviz_form">
        
        <form id="head_popup" ref="rekv_form_main">
            
            <div class="pop_title">
                Добавить реквизиты <br>
            </div>

            <div class="remark">
                Заполните данные или прикрепите файл
            </div>


            <div class="inp_box">
                <label for="name">Название компании или юр. лица</label>
                <input type="text" id="name" v-model="add_item.name">
            </div>

            <div class="inp_box">
                <label for="inn">ИНН (12 или 10 цифр)*</label>
                <input type="number" id="inn" v-model="add_item.inn">
            </div>

            <div class="inp_box">
                <label for="kpp">КПП (9 цифр)*</label>
                <input type="number" id="kpp" v-model="add_item.kpp">
            </div>

            <div class="inp_box">
                <label for="bik">БИК (9 цифр)*</label>
                <input type="number" id="bik" v-model="add_item.bik">
            </div>

            <div class="inp_box">
                <label for="count">Расчётный счёт (20 цифр)</label>
                <input maxlength="20" type="text" id="count" v-model="add_item.check">
            </div>

            <div class="inp_box">
                <label for="bank">Название банка</label>
                <input type="text" id="bank" v-model="add_item.bank_name">
            </div>

            <div class="inp_box">
                <label for="file_inp">Файл реквизитов</label>
                <input ref="filee" @change="load_file" id="file_inp" type="file" style="display: none;">
                <div id="take_rekv" @click="this.$refs.filee.click()" class="file_button" ref="file_button">
                    Прикрепите файл
                </div>
            </div>

            
            <button v-show="condition_all" @click.prevent="SubmitRekv" class="pop_butt" id="call_butt_head">
                Добавить
            </button>

            <div v-show="error != ''" class="error_text">{{ error }}</div>
        </form>
    </div>
</template>
