<script>

import axios from 'axios';

export default {
    props: ['elem'],

    data() {
        return {
            save: false,
            error: ''
        }
    },

    computed: {
        name_cond: function() {
            return this.elem.name != '';
        },
        phone_cond: function() {
            return this.elem.phone.length >= 16;
        }
    },

    methods: {

        Show_Save: function () { 
            if(this.name_cond && this.phone_cond)
            {
                this.save = true;
            }
            else
            {
                this.save = false;
            }
        },

        Save_Item:  function () {

            let post_data = {
                id: this.elem.id,
                name: this.elem.name,
                phone: this.elem.phone,
                activity: (this.elem.activity == true) ? 1 : 0
            };

            axios.post('/save_user', post_data).then(res => {

                if(res.data.status)
                {
                    this.error = 'Такой телефон уже есть в базе';
                }
                else
                {
                    this.error = '';
                    this.save = false;
                    $.fancybox.close();
                }

                //console.log(res.data);
            });
        }  
    }
}


</script>

<template>
    <div class="univers_popup user" style="display: none;" :id="'user_popup_'+elem.id">
        <form class="form_wrap" @submit.prevent = "Save_Item" >
            <div class="pop_title">
                Изменить пользователя <br>
                <span class="orange">
                    {{ elem.name }}
                </span>
            </div>
            <div class="inp_box">
                <label for="name">Имя*</label>
                <input autocomplete="off" :class="{error: !name_cond}" v-model="elem.name" type="text" name="name" @input="Show_Save">
            </div>

            <div class="inp_box">
                <label for="phone_pop">Телефон*</label>
                <input maxlength="16" autocomplete="off" :class="{error: !phone_cond}" @input="Show_Save" v-model="elem.phone" type="text" class="required phone" name="phone" v-imask="{mask: '+{7}(000) 000-0000'}">
            </div>

            <div class="inp_box check">
                <label for="phone_pop">Активность</label>
                <input @change="Show_Save" v-model="elem.activity" type="checkbox" class="required" name="active">
            </div>

            <transition name="fade">
                <button  v-show="save" class="pop_butt">Сохранить</button>
            </transition>

            <div class="error_text">{{ error }}</div>
        </form>
    </div>  
</template>
