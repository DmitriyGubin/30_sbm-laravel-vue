<script>

import axios from 'axios';
import Order from './order.vue';
//import image from "../../../../public/img/1732506839_img.png";

export default {
    props: ['rekv'],
    data() {
        return {
            tabs: null,
            orders: [],
            status_id: null,
            count: null
        }
    },

    components: {
        Order
    },

    methods: {
        Get_Tabs: function () {
            axios.post('/statuses').then(res => { 
                this.tabs = res.data;
                this.status_id = res.data[0].id;
                this.Get_Orders();
            });
        },
        Get_Orders: function () {
            axios.post('/customer_orders').then(res => { 
                //this.orders = res.data.sort(function(a, b) { return b.id - a.id; });
                this.orders = res.data;
                this.count = this.Get_Count(this.status_id);
            });
        },
        Get_Count: function (status_id) {
            let countt = 0;
            for(let item of this.orders)
            {
                if(item.status_id == status_id)
                {
                    countt++;
                }
            }
            return countt;
        },
        Set_Count: function(status_id){
            this.count = this.Get_Count(status_id);
        },
        Set_Tab: function (status_id) {
            this.status_id=status_id;
            this.count = this.Get_Count(status_id);
        },
        Delete_Order: function(order_id)
        {
            let post_data = {
                id: order_id
            };
            axios.post('/delete_order', post_data).then(res => { 
                this.orders = this.orders.filter(elem => {
                    if(elem.id != order_id)
                    {
                        return true;
                    }
                });
                this.Set_Count(this.status_id);
            });
        }
    },

    beforeMount() {
        this.Get_Tabs();
    }
}

</script>

<template>
    
    <div class="sub_menu">
        <button
        v-for="tab in tabs" 
        @click="Set_Tab(tab.id)"  
        :class="['univ_button', { active: status_id === tab.id }]" >
            {{ tab.name }} - {{ Get_Count(tab.id) }}
        </button>
    </div>
    
    <div v-if="count==0" class="empty_box">
        <svg class="bloknot" width="104px" height="104px" viewBox="0 0 104 104" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>F6BA100F-EFD6-429A-853A-76DB86832761</title><g id="\uD83D\uDC68\uD83C\uDFFB\u200D\uD83D\uDCBC-\u0417\u0430\u043A\u0430\u0437\u0447\u0438\u043A" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Web-2.0-My-orders--v-1440" transform="translate(-669, -144)" fill="#C8C8C8"><g id="Message" transform="translate(496, 144)"><g id="Icon/24/Intellicon/-time-/-calendar" transform="translate(173, -0)"><path d="M34.6666667,8.66666667 L34.6656667,12.9996667 L69.3326667,12.9996667 L69.3333333,8.66666667 L78,8.66666667 L77.9996667,12.9996667 L86.6666667,13 C91.4531345,13 95.3333333,16.8801988 95.3333333,21.6666667 L95.3333333,86.6666667 C95.3333333,91.4531345 91.4531345,95.3333333 86.6666667,95.3333333 L17.3333333,95.3333333 C12.5468655,95.3333333 8.66666667,91.4531345 8.66666667,86.6666667 L8.66666667,21.6666667 C8.66666667,16.8801988 12.5468655,13 17.3333333,13 L25.9996667,12.9996667 L26,8.66666667 L34.6666667,8.66666667 Z M86.6666667,43.3326667 L17.3326667,43.3326667 L17.3333333,86.6666667 L86.6666667,86.6666667 L86.6666667,43.3326667 Z M25.9996667,21.6666667 L17.3333333,21.6666667 L17.3326667,34.6666667 L86.6666667,34.6666667 L86.6666667,21.6666667 L77.9996667,21.6666667 L78,26 L69.3333333,26 L69.3326667,21.6666667 L34.6656667,21.6666667 L34.6666667,26 L26,26 L25.9996667,21.6666667 Z" id="icon"></path></g></g></g></g></svg> 
        <div class="empty_title">
            Пока нет заказов
        </div>
        <a href="/" class="univ_button empty_butt">
            Создать заказ
        </a>
    </div>

    <Order v-else v-for="order in orders"
    :key="order.id"
    :order="order"
    :status_id="status_id"
    :rekv="rekv"
    @Set_Count="Set_Count"
    @Delete_Order="Delete_Order"
    />   
</template>
