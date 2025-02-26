<script>

export default {
    props: ['count_pages','cur_page','cur_tab'],
    inject: ['Change_Page_New_Orders',
             'Change_Page_My_Orders', 
             'Change_Page_Close_Orders', 
             'Change_Page_Active_Orders',
             'Change_Page_Close_Orders_Admin',
             'Change_Page_Managers',
             'Change_Page_Customers',
             'Change_Page_Providers'
            ],
    methods: {
        Change_Cur_Page: function (page) {
            if(this.cur_tab == 'my_orders')
            {
                this.Change_Page_My_Orders(page);
            }
            if(this.cur_tab == 'new_orders')
            {
                this.Change_Page_New_Orders(page);
            }
            if(this.cur_tab == 'close_orders')
            {
                this.Change_Page_Close_Orders(page);
            }
            if(this.cur_tab == 'active_orders')
            {
                this.Change_Page_Active_Orders(page);
            }
            if(this.cur_tab == 'close_orders_admin')
            {
                this.Change_Page_Close_Orders_Admin(page);
            }
            if(this.cur_tab == 'managers')
            {
                this.Change_Page_Managers(page);
            }
            if(this.cur_tab == 'customers')
            {
                this.Change_Page_Customers(page);
            }
            if(this.cur_tab == 'providers')
            {
                this.Change_Page_Providers(page);
            }
        }
    }
}

</script>

<template>
    <div class="pager">
        <div v-for="num in count_pages" @click="Change_Cur_Page(num)" class="pager_item" :key="num" :class="[{active: num == cur_page}]">
            {{ num }}
        </div>
    </div>
</template>
