<script>

export default {
    props: ['user'],
    data() {
        return {
            edit: false,
            save: false,
            error: false
        }
    },

    methods: {
        Show_Save: function () { 
            if(this.conditions)
            {
                this.save = true;
            }
            else
            {
                this.save = false;
            }
        },
        Save_User: function() {
            
            let post_data = {
                id: this.user.id,
                name: this.user.name,
                phone: this.user.phone,
                activity: this.user.activity
            };

            axios.post('/save_user', post_data).then(res => {
                if(!res.data.status)
                {
                    this.error = false;
                    this.edit = false;
                    this.save = false;
                }
                else
                {
                    this.error = 'Такой телефон уже есть !';
                }
            });
        }
    },

    computed: {
        conditions: function() {
            return this.user.name != '' && 
            this.user.phone.length == 16;
        }
    }
}

</script>

<template>
    <form class="form_box">
        <div class="univ_form">
            <div class="inp_box">
                <label for="name">Ваше имя</label>
                <input :class="[{error: user.name == ''},{editt: edit}]" @input="Show_Save" :readonly="!edit" autocomplete="off" id="name" type="text" v-model="user.name">
            </div>

            <div class="inp_box">
                <label for="phone">Ваш телефон, привязанный к WhatsApp*</label>
                <input :class="[{error: user.phone.length != 16},{editt: edit}]" @input="Show_Save" :readonly="!edit" v-model="user.phone" id="phone" type="text" maxlength="16" autocomplete="off" v-imask="{mask: '+{7}(000) 000-0000'}">
            </div>

            <button @click.prevent="Save_User" v-if="save" v-show="save" class="univ_butt">
                Сохранить
            </button>

            <button v-else @click.prevent="edit = !edit" class="univ_butt">
                {{ edit ? 'На редактировании' : 'Редактировать' }}
            </button>

            <div v-show="error != false" class="error_text">{{ error }}</div>
        </div>
    </form>
</template>
