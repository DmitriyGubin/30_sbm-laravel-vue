<script>

import My_orders from './my_orders.vue';
import Archive_orders from './archive_orders.vue';
import My_tech from './my_tech.vue';
import axios from 'axios';


export default {
    components: {
        My_orders, Archive_orders, My_tech
    },

    data() {
        return {
            current_tab: 'Моя техника',
            count_my_tech: 0,
            count_my_orders: 0,
            count_arch_orders: 0,
            my_orders: [],
            archive_orders: [],
            tech: [],
            loader: false
        }
    },
    methods: {
        Get_Tech: function () {
            axios.post('/get_techs').then(res => {
                this.tech = res.data;
                this.count_my_tech = res.data.length;
            });
        },
        Get_My_Orders: function () {
            axios.post('/get_provider_orders').then(res => {
                this.my_orders = res.data;
                this.count_my_orders = res.data.length;
            });
        },
        Get_Arhive_Orders: function () {
            axios.post('/get_archive_orders').then(res => {
                this.archive_orders = res.data;
                this.count_arch_orders = res.data.length;
            });
        },
        Take_Order: function (order) {
            this.loader = true;
            let post_data = {
                order_id: order.order.id,
                tech: order.order.tech,
                date: order.order.date,
                time: order.order.time,
                interval: order.order.interval,
                where: order.order.where,
                price_provider: order.order.price_provider,
                money_provider: order.order.money_provider,
                name_prov: order.providerr.name,
                phone_prov: order.providerr.phone,
                phone_manager: order.manager.phone
            };
            axios.post('/take_order_provider',post_data).then(res => {
                this.my_orders = this.my_orders.filter( elem => { 
                if(order.id != elem.id) return true;
                });
                this.count_my_orders--;
                this.archive_orders.unshift(order);
                this.count_arch_orders++;
                this.loader = false;
            });
        },
        Close_Order: function (order_id) {
            axios.post('/delete_order_provider',{id_record: order_id}).then(res => {
                this.my_orders = this.my_orders.filter( elem => { 
                if(order_id != elem.id) return true;
                });
                this.count_my_orders--;
            });
        },
        Return_To_Work: function (order) {
            axios.post('/return_to_work',{order_id: order.order.id}).then(res => {
                this.archive_orders = this.archive_orders.filter( elem => { 
                    if(order.id != elem.id) return true;
                });
                this.count_arch_orders--;
                this.my_orders.unshift(order);
                this.count_my_orders++; 
            });
        }
    },
    computed:
    {
        current_comp() {
            return this.tabs.filter(elem => {
                if (elem.name == this.current_tab) {
                    return true;
                }
            })[0].comp;
        },
        tabs() {
            return [
                { comp: 'My_tech', name: 'Моя техника', count: this.count_my_tech },
                { comp: 'My_orders', name: 'Мои заявки', count: this.count_my_orders },
                { comp: 'Archive_orders', name: 'Архив заявок', count: this.count_arch_orders }
            ]
        }
    },
    beforeMount() {
        this.Get_My_Orders();
        this.Get_Arhive_Orders();
        this.Get_Tech();
    }
}

</script>

<template>
   
    <div class="sub_menu">
        <button v-for="tab in tabs" @click="current_tab = tab.name"
            :class="['univ_button', { active: current_tab === tab.name }]">
            {{ tab.name }} {{ (tab.count != false) ? ('- ' + tab.count) : '' }}
        </button>
    </div>

    <!-- Неактивные компоненты будут закэшированы! -->
    <keep-alive>
        <component 
        :is="current_comp"
        :my_orders="my_orders"
        :archive_orders="archive_orders"
        :tech="tech"
        :loader="loader"
        @Take_Order="Take_Order"
        @Close_Order="Close_Order"
        @Return_To_Work="Return_To_Work"
        >
        </component>
    </keep-alive>

</template>
