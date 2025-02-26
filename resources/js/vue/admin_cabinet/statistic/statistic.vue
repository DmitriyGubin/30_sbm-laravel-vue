<script>
import axios from 'axios';

export default {
    data() {
        return {
            stat: [],
            cur_page: 1,
            show_more: true
        }
    },
    methods: {
        Get_Stat_Orders: function (page) {
            axios.get('/statistics_orders',{params: { page: page }}).then(res => {
                //console.log(res.data);
                if(res.data.next_page_url == null)
                {
                    this.show_more = false;
                }
                for(let item of res.data.data)
                {
                    this.stat.push(item);
                }
            });
        },
        Show_More: function()
        {
            this.cur_page++;
            this.Get_Stat_Orders(this.cur_page);
        }
    },
    beforeMount() {
        this.Get_Stat_Orders(1);
    }
}


</script>

<template>

    <div v-if="stat.length == 0" class="empty_box">
        <svg class="bloknot" width="104px" height="104px" viewBox="0 0 104 104" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>F6BA100F-EFD6-429A-853A-76DB86832761</title><g id="\uD83D\uDC68\uD83C\uDFFB\u200D\uD83D\uDCBC-\u0417\u0430\u043A\u0430\u0437\u0447\u0438\u043A" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Web-2.0-My-orders--v-1440" transform="translate(-669, -144)" fill="#C8C8C8"><g id="Message" transform="translate(496, 144)"><g id="Icon/24/Intellicon/-time-/-calendar" transform="translate(173, -0)"><path d="M34.6666667,8.66666667 L34.6656667,12.9996667 L69.3326667,12.9996667 L69.3333333,8.66666667 L78,8.66666667 L77.9996667,12.9996667 L86.6666667,13 C91.4531345,13 95.3333333,16.8801988 95.3333333,21.6666667 L95.3333333,86.6666667 C95.3333333,91.4531345 91.4531345,95.3333333 86.6666667,95.3333333 L17.3333333,95.3333333 C12.5468655,95.3333333 8.66666667,91.4531345 8.66666667,86.6666667 L8.66666667,21.6666667 C8.66666667,16.8801988 12.5468655,13 17.3333333,13 L25.9996667,12.9996667 L26,8.66666667 L34.6666667,8.66666667 Z M86.6666667,43.3326667 L17.3326667,43.3326667 L17.3333333,86.6666667 L86.6666667,86.6666667 L86.6666667,43.3326667 Z M25.9996667,21.6666667 L17.3333333,21.6666667 L17.3326667,34.6666667 L86.6666667,34.6666667 L86.6666667,21.6666667 L77.9996667,21.6666667 L78,26 L69.3333333,26 L69.3326667,21.6666667 L34.6656667,21.6666667 L34.6666667,26 L26,26 L25.9996667,21.6666667 Z" id="icon"></path></g></g></g></g></svg> 
        <div class="empty_title">
            Статистика пока не накоплена
        </div>
    </div>

    <template v-else>
        <h2 class="admin_sub">Количество заказов техники</h2>
        <div v-for="item in stat" class="sub_box stat">
            <div class="stat_result">
                <b>{{ item.tech_name }}</b> <br> 
                Количество заказов: {{ item.quantity }}
            </div>
        </div>
        <button v-show="show_more" @click="Show_More" class="univ_button center">Показать ещё</button>
    </template>
    
</template>
