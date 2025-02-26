<script>

import My_Data from './my_data.vue';
import New_Orders from './new_orders.vue';
import My_Orders from './my_orders.vue';
import Close_Orders from './close_orders.vue';

export default {
    components: {
        My_Data, New_Orders, My_Orders, Close_Orders
    },

    data() {
        return {
            current_tab: 'Новые заявки',
            new_orders: [],
            my_orders: [],
            close_orders: [],
            user: [],

            count_new_or: '',
            count_pages_new_or: '',
            cur_page_new_or: 1,

            count_my_or: '',
            count_pages_my_or: '',
            cur_page_my_or: 1,

            count_close_or: '',
            count_pages_close_or: '',
            cur_page_close_or: 1
        }
    },
    provide() {
        return {
            Change_Page_New_Orders: this.Get_New_Orders,
            Change_Page_My_Orders: this.Get_My_Orders,
            Change_Page_Close_Orders: this.Get_Close_Orders,
            Refuse_Order: this.Refuse_Order
        }
    },
    methods: {
        Get_User: function () {
            axios.post('/cur_user').then(res => { 
                this.user = res.data;
            });
        },
        Get_New_Orders: function (page) {
            axios.get('/new_orders',{params: { page: page }}).then(res => {
                //console.log(res.data);
                this.cur_page_new_or = page;
                this.new_orders = res.data.data;
                this.count_new_or = res.data.total;
                let count_pages = res.data.last_page;
                if(page <= count_pages)
                {
                    this.count_pages_new_or = count_pages;
                }
            });
        },
        Get_My_Orders: function (page) {
            axios.get('/my_orders',{params: { page: page }}).then(res => {
                this.cur_page_my_or = page;
                this.my_orders = res.data.data;
                this.count_my_or = res.data.total;
                let count_pages = res.data.last_page;
                if(page <= count_pages)
                {
                    this.count_pages_my_or = count_pages;
                }
            });
        },
        Get_Close_Orders: function (page) {
            axios.get('/close_orders',{params: { page: page }}).then(res => {
                this.cur_page_close_or = page;
                this.count_close_or = res.data.total;
                this.close_orders = res.data.data;
                let count_pages = res.data.last_page;
                if(page <= count_pages)
                {
                    this.count_pages_close_or = count_pages;
                }
            });
        },
        Take_Order: function (elem) {
            let post_data = {
                id_order: elem.id
            };
            axios.post('/take_order', post_data).then(res => {
                //console.log(res.data);
                this.new_orders = this.new_orders.filter(function (item) {
                    if (item.id != elem.id) {
                        return true;
                    }
                });
                elem.manager_id = this.user.id;
                this.my_orders.unshift(elem);
                this.count_new_or--;
                this.count_my_or++;
            });
        },
        Refuse_Order: function (elem) {
            let post_data = {
                id_order: elem.id
            };
            axios.post('/refuse_order', post_data).then(res => {
                this.my_orders = this.my_orders.filter(function (item) {
                    if (item.id != elem.id) {
                        return true;
                    }
                });
                elem.manager_id = null;
                this.new_orders.unshift(elem);
                this.count_new_or++;
                this.count_my_or--;
            });
        },
        Change_Status: function (elem, stat_id) {
            let post_data = {
                id: elem.id,
                status_idd: stat_id
            };

            axios.post('/change_order_status', post_data).then(res => {
                elem.status_id = stat_id;
                if (stat_id == 2) {
                    this.my_orders = this.my_orders.filter(function (item) {
                        if (item.id != elem.id) {
                            return true;
                        }
                    });
                    this.close_orders.unshift(elem);
                    this.count_my_or--;
                    this.count_close_or++;
                }
                if (stat_id == 1) {
                    this.close_orders = this.close_orders.filter(function (item) {
                        if (item.id != elem.id) {
                            return true;
                        }
                    });
                    this.my_orders.unshift(elem);
                    this.count_close_or--;
                    this.count_my_or++;
                }
            });
        },
        Delete_Order: function (id_order) {
            let post_data = {
                id: id_order
            };
            axios.post('/delete_order', post_data).then(res => {
                this.close_orders = this.close_orders.filter(function (item) {
                    if (item.id != id_order) {
                        return true;
                    }
                });
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
                { comp: 'New_Orders', name: 'Новые заявки', count: this.count_new_or },
                { comp: 'My_Orders', name: 'Мои заявки', count: this.count_my_or },
                { comp: 'Close_Orders', name: 'Завершённые заявки', count: this.count_close_or },
                { comp: 'My_Data', name: 'Мои данные', count: false }
            ]
        }
    },
    beforeMount() {
        this.Get_New_Orders(1);
        this.Get_My_Orders(1);
        this.Get_Close_Orders(1);
        this.Get_User();
    }
}

</script>

<template>

    <div class="sub_menu">
        <button v-for="tab in tabs" @click="current_tab = tab.name"
            :class="['univ_button', { active: current_tab === tab.name }]">
            {{ tab.name }} {{ (tab.count != false) ? '- ' + tab.count : '' }}
        </button>
    </div>

    <!-- Неактивные компоненты будут закэшированы! -->
    <keep-alive>
        <component 
        :is="current_comp"
        
        :new_orders="new_orders" 
        :count_new_or="count_new_or"
        :count_pages_new_or="count_pages_new_or"
        :cur_page_new_or="cur_page_new_or"

        :my_orders="my_orders"
        :count_my_or="count_my_or"
        :count_pages_my_or="count_pages_my_or"
        :cur_page_my_or="cur_page_my_or"

        :close_orders="close_orders" 
        :count_close_or="count_close_or"
        :count_pages_close_or="count_pages_close_or"
        :cur_page_close_or="cur_page_close_or"

        :user="user"

        @Take_Order="Take_Order" 
        @Change_Status="Change_Status"
        @Delete_Order="Delete_Order"
        >
        </component>
    </keep-alive>

</template>
