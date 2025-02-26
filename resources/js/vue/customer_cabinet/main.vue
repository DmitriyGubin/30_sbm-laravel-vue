<script>

import axios from 'axios';
import My_Data from './my_data.vue';
import My_Orders from './my_orders.vue';
import My_Details from './my_details.vue';

export default {
    components: {
        My_Data,My_Orders,My_Details
    },

    data() {
        return {
            tabs: [
                {comp: 'My_Orders', name: 'Мои заказы'},
                {comp: 'My_Data', name: 'Мои данные'},
                {comp: 'My_Details', name: 'Мои реквезиты'}
            ],
            current_tab: 'Мои заказы',
            rekv: [],
            cur_recv_id: null
        }
    },
    computed: 
    {
        current_comp() {
            return this.tabs.filter(elem => {
                if(elem.name == this.current_tab)
                {
                    return true;
                }
            })[0].comp;
        }
    },
    methods: {
        Get_Rekv: function () {
            axios.post('/recvizits').then(res => {
                this.rekv = res.data.data;
                this.cur_recv_id = res.data.cur_recv_id;
                // this.max_recv_id = Math.max(...this.rekv.map(obj => obj.id));
            });
        },
        Add_Rekv: function (elem) {
            let clone = JSON.parse(JSON.stringify(elem));
            this.rekv.unshift(clone);
            $.fancybox.close({ src: '#rekviz_form' });
        },
        Delete_Rekv: function(id,img_name)
        {
            let data = {idd: id, img: img_name};
            axios.post('/delete_rekv',data).then(res => {
                console.log(res.data);
                this.rekv = this.rekv.filter(function(elem) {
                    if (elem.id != id) {
                        return true;
                    } 
                });
            });
        },
        Change_Cur_Rekv(id){
            if(id == this.cur_recv_id)
            {
                //выбран
                this.cur_recv_id = '';
            }
            else
            {
                //не выбран
                this.cur_recv_id = id;
            }
        }
    },
    beforeMount() {
        this.Get_Rekv();
    }
}

</script>

<template>
   <div class="sub_menu">
        <button
        v-for="tab in tabs" 
        @click="current_tab=tab.name"  
        :class="['univ_button', { active: current_tab === tab.name }]" >
            {{ tab.name }}
        </button>
   </div>

   <!-- Неактивные компоненты будут закэшированы! -->
   <keep-alive>
    <component 
    :is="current_comp"
    :rekv="rekv"
    :cur_recv_id="cur_recv_id"
    @Add_Rekv="Add_Rekv"
    @Delete_Rekv="Delete_Rekv"
    @Change_Cur_Rekv="Change_Cur_Rekv"
    >
    </component>
   </keep-alive>
    
</template>
