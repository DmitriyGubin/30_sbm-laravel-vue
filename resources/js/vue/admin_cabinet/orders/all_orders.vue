<script>

import Active_orders from './active_orders.vue';
import Close_orders from './close_orders.vue';

export default {
    components: {
        Active_orders, Close_orders
    },
    data() {
        return {
            current_tab: 'Активные',

            active_orders: [],
            cur_page_act_or: 1,
            count_act_or: '',
            count_pages_act_or: '',

            close_orders: [],
            cur_page_close_or: 1,
            count_close_or: '',
            count_pages_close_or: ''
        }
    },
    provide() {
        return {
            Change_Page_Active_Orders: this.Get_Active_Orders,
            Change_Page_Close_Orders_Admin: this.Get_Close_Orders,
            Delete_Order: this.Delete_Order
        }
    },
    methods: {
        Get_Active_Orders: function (page) {
            axios.get('/get_orders_status',{params: { page: page, status: 1 }}).then(res => {
                //console.log(res.data);
                this.cur_page_act_or = page;
                this.active_orders = res.data.data;
                this.count_act_or = res.data.total;
                let count_pages = res.data.last_page;
                if(page <= count_pages)
                {
                    this.count_pages_act_or = count_pages;
                }
            });
        },
        Get_Close_Orders: function (page) {
            axios.get('/get_orders_status',{params: { page: page, status: 2 }}).then(res => {
                //console.log(res.data);
                this.cur_page_close_or = page;
                this.close_orders = res.data.data;
                this.count_close_or = res.data.total;
                let count_pages = res.data.last_page;
                if(page <= count_pages)
                {
                    this.count_pages_close_or = count_pages;
                }
            });
        },
        Delete_Order: function (order_id,variant) {
            axios.post('/delete_order', {id: order_id}).then(res => { 
                if(variant == 'active')
                {
                    this.active_orders = this.active_orders.filter(function (item) {
                        if (item.id != order_id) {
                            return true;
                        }
                    });
                    this.count_act_or--;
                }
                else if(variant == 'close')
                {
                    this.close_orders = this.close_orders.filter(function (item) {
                        if (item.id != order_id) {
                            return true;
                        }
                    });
                    this.count_close_or--;
                }
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
                { comp: 'Active_orders', name: 'Активные', count: this.count_act_or },
                { comp: 'Close_orders', name: 'Завершённые', count: this.count_close_or }
            ]
        }
    },
    beforeMount() {
        this.Get_Active_Orders(1);
        this.Get_Close_Orders(1);
    }
}

</script>

<template>

    <div class="sub_menu">
        <button v-for="tab in tabs" @click="current_tab = tab.name"
            :class="['univ_button', { active: current_tab === tab.name }]">
            {{ tab.name + ' - ' + tab.count }}
        </button>
    </div>

    <!-- Неактивные компоненты будут закэшированы! -->
    <keep-alive>
        <component 
        :is="current_comp"

        :active_orders="active_orders"
        :count_act_or="count_act_or"
        :count_pages_act_or="count_pages_act_or"
        :cur_page_act_or="cur_page_act_or"

        :close_orders="close_orders"
        :count_close_or="count_close_or"
        :count_pages_close_or="count_pages_close_or"
        :cur_page_close_or="cur_page_close_or"
        >
        </component>
    </keep-alive>

</template>
