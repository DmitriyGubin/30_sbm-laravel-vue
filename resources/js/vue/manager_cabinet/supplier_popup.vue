<script>
import axios from 'axios';

export default {
    props: ['id_popup','providers','order'],
    emits: ['Ready_Masseges'],
    data() {
        return {
            search: '',
            loader_check: false,
            phones: []
            //phones: [{"id_prov": 1, "phone": '+7(991) 504-8332'}, {"id_prov": 2, "phone": '+7(991) 504-8332'}]
        }
    },
    methods: {
        Fill_Providers: function (item,checked) {
            if(checked)
            {
                this.phones.push({"id": item.id, "id_prov": item.provider.id, "phone": item.provider.phone});
            }
            else
            {
                this.phones = this.phones.filter(function(elem) {
                    if (elem.id != item.id) {
                        return true;
                    }
                });
            }
        },
        Send_Messages: function (target) {

            this.loader_check = true;
            let post_data = {
                id: this.order.id,
                phone_client: this.order.user.phone,
                tech: this.order.tech,
                date: this.order.date,
                time: this.order.time,
                interval: this.order.interval,
                phones: this.phones,
                manager_id: this.order.manager_id,
                price_provider: this.order.price_provider
            };
            axios.post('/find_supplier', post_data).then(res => {
               if(res.data == 1)
               {
                    this.loader_check = false;
                    this.$emit('Ready_Masseges');
                    this.search = '';
                    this.phones = [];
                    target.reset();
                    $.fancybox.close();
               }
            });
        },
        Make_Tech_Name: function(tech) {
            let name = tech.type;
            let one = tech.char_one;
            let two = tech.char_two;
            let three = tech.char_three;
            if(one != '')
            {
                name = name + '; ' + one;
            }
            if(two != '')
            {
                name = name + '; ' + two;
            }
            if(three != '')
            {
                name = name + '; ' + three;
            }
            return name;
        }
    }
}

</script>

<template>
    <form @submit.prevent="Send_Messages($event.target)" class="univers_popup tech_popup" style="display: none;" :id="'supplier_popup_'+ id_popup">
         
        <div class="pop_title" v-if="providers.length == 0">
            Поставщиков пока нет
        </div>

        <template v-else>
            <div class="pop_title">Выберите поставщиков для заказа № {{ id_popup }}</div>
            <input v-model="search" type="text" placeholder="Поиск по поставщику или технике">

            <div class="sect_list">
                <template v-for="item in providers" :key="item.id">
                    <div class="sect_item" v-show="search == '' ? true : ((item.provider.name + ', ' + item.provider.phone + ', ' + Make_Tech_Name(item.tech)).toLowerCase()).includes(search.toLowerCase())">
                        <input type="checkbox" class="galka" @click="Fill_Providers(item,$event.target.checked)">
                        <label class="sect_name">
                            <b>Техника: </b> {{ Make_Tech_Name(item.tech) }} <br>
                            <b>Поставщик: </b> {{ item.provider.name + ', ' + item.provider.phone }}
                        </label>
                    </div>
                </template>
            </div>

            <button v-show="phones.length != 0" class="univ_button send_watsapp">
                <span v-if="!loader_check">Разослать сообщения</span>
                <div v-else class="loader"></div>
            </button>
        </template>
    </form>
</template>
