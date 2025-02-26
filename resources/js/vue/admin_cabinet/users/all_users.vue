<script>

import Managers from './managers.vue';
import Providers from './providers.vue';
import Customers from './customers.vue';

export default {
    components: {
        Managers, Providers, Customers
    },
    data() {
        return {
            current_tab: 'Менеджеры',

            managerss: [],
            count_manrs: '',
            cur_page_manrs: 1,
            count_pages_manrs: '',

            providerss: [],
            count_provs: '',
            cur_page_provs: 1,
            count_pages_provs: '',

            customerss: [],
            count_custs: '',
            cur_page_custs: 1,
            count_pages_custs: ''
        }
    },
    provide() {
        return {
            Change_Page_Managers: this.Get_Managers,
            Change_Page_Providers: this.Get_Providers,
            Change_Page_Customers: this.Get_Customers,
            Make_Activ: this.Make_Activ,
            Delete_User: this.Delete_User
        }
    },
    methods: {
        Colibrate_Active: function (mass) {
            for(let item of mass)
            {
                if(item.activity == 1)
                {
                    item.activity = true;
                }
                else
                {
                    item.activity = false;
                }
            }
        },
        Get_Managers: function (page) {
            axios.get('/get_users_status',{params: { page: page, status: 2 }}).then(res => {
                //console.log(res.data);
                this.managerss = res.data.data;
                this.Colibrate_Active(this.managerss);
                this.cur_page_manrs = page;
                this.count_manrs = res.data.total;
                let count_pages = res.data.last_page;
                if(page <= count_pages)
                {
                    this.count_pages_manrs = count_pages;
                }
            });
        },
        Get_Providers: function (page) {
            axios.get('/get_users_status',{params: { page: page, status: 3 }}).then(res => {
                this.providerss = res.data.data;
                this.Colibrate_Active(this.providerss);
                this.cur_page_provs = page;
                this.count_provs = res.data.total;
                let count_pages = res.data.last_page;
                if(page <= count_pages)
                {
                    this.count_pages_provs = count_pages;
                }
            });
        },
        Get_Customers: function (page) {
            axios.get('/get_users_status',{params: { page: page, status: 4 }}).then(res => {
                this.customerss = res.data.data;
                this.Colibrate_Active(this.customerss);
                this.cur_page_custs = page;
                this.count_custs = res.data.total;
                let count_pages = res.data.last_page;
                if(page <= count_pages)
                {
                    this.count_pages_custs = count_pages;
                }
            });
        },
        Change_One_Active: function(mass,id)
        {
            for(let item of mass)
            {
                if(item.id == id)
                {
                    item.activity = true;
                    break;
                }
            }
        },
        Make_Activ: function (id,type) {
            
            let post_data = {
                id: id,
                activity: 1
            };

            axios.post('/save_user', post_data).then(res => {
                if(type == 'manager')
                {
                    this.Change_One_Active(this.managerss,id);
                }
                else if(type == 'customer')
                {
                    this.Change_One_Active(this.customerss,id);
                }
                else if(type == 'provider')
                {
                    this.Change_One_Active(this.providerss,id);
                }
            });
        },
        Delete_User: function (user_id,type) {

            axios.post('/delete_user', {id_user: user_id}).then(res => { 
                
                if(type == 'manager')
                {
                    this.managerss = this.managerss.filter(function (item) {
                        if (item.id != user_id) 
                        {
                            return true;
                        }
                    });
                    this.count_manrs--;
                }

                if(type == 'provider')
                {
                    this.providerss = this.providerss.filter(function (item) {
                        if (item.id != user_id) 
                        {
                            return true;
                        }
                    });
                    this.count_provs--;
                }

                if(type == 'customer')
                {
                    this.customerss = this.customerss.filter(function (item) {
                        if (item.id != user_id) 
                        {
                            return true;
                        }
                    });
                    this.count_custs--;
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
                { comp: 'Managers', name: 'Менеджеры', count: this.count_manrs },
                { comp: 'Customers', name: 'Заказчики', count: this.count_custs },
                { comp: 'Providers', name: 'Поставщики', count: this.count_provs }
            ]
        }
    },
    beforeMount() {
        this.Get_Managers(1);
        this.Get_Providers(1);
        this.Get_Customers(1);
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

        :managerss="managerss"
        :count_manrs="count_manrs"
        :count_pages_manrs="count_pages_manrs"
        :cur_page_manrs="cur_page_manrs"

        :providerss="providerss"
        :count_provs="count_provs"
        :count_pages_provs="count_pages_provs"
        :cur_page_provs="cur_page_provs"

        :customerss="customerss"
        :count_custs="count_custs"
        :count_pages_custs="count_pages_custs"
        :cur_page_custs="cur_page_custs"
        >
        </component>
    </keep-alive>

</template>
