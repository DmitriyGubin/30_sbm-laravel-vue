<script>

import Order from './order.vue';
import Pager from '../pagination.vue';

export default {
    props: ['new_orders','count_new_or','count_pages_new_or','cur_page_new_or'],
    emits: ['Take_Order','Change_Status','Delete_Order'],

    components: {
        Order,Pager
    }
}

</script>

<template>

    <div v-if="count_new_or==0" class="empty_box">
        <svg class="bloknot" width="104px" height="104px" viewBox="0 0 104 104" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>F6BA100F-EFD6-429A-853A-76DB86832761</title><g id="\uD83D\uDC68\uD83C\uDFFB\u200D\uD83D\uDCBC-\u0417\u0430\u043A\u0430\u0437\u0447\u0438\u043A" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Web-2.0-My-orders--v-1440" transform="translate(-669, -144)" fill="#C8C8C8"><g id="Message" transform="translate(496, 144)"><g id="Icon/24/Intellicon/-time-/-calendar" transform="translate(173, -0)"><path d="M34.6666667,8.66666667 L34.6656667,12.9996667 L69.3326667,12.9996667 L69.3333333,8.66666667 L78,8.66666667 L77.9996667,12.9996667 L86.6666667,13 C91.4531345,13 95.3333333,16.8801988 95.3333333,21.6666667 L95.3333333,86.6666667 C95.3333333,91.4531345 91.4531345,95.3333333 86.6666667,95.3333333 L17.3333333,95.3333333 C12.5468655,95.3333333 8.66666667,91.4531345 8.66666667,86.6666667 L8.66666667,21.6666667 C8.66666667,16.8801988 12.5468655,13 17.3333333,13 L25.9996667,12.9996667 L26,8.66666667 L34.6666667,8.66666667 Z M86.6666667,43.3326667 L17.3326667,43.3326667 L17.3333333,86.6666667 L86.6666667,86.6666667 L86.6666667,43.3326667 Z M25.9996667,21.6666667 L17.3333333,21.6666667 L17.3326667,34.6666667 L86.6666667,34.6666667 L86.6666667,21.6666667 L77.9996667,21.6666667 L78,26 L69.3333333,26 L69.3326667,21.6666667 L34.6656667,21.6666667 L34.6666667,26 L26,26 L25.9996667,21.6666667 Z" id="icon"></path></g></g></g></g></svg> 
        <div class="empty_title">
            Пока нет заказов
        </div>
        <a href="/" class="univ_button empty_butt">
            Создать заказ
        </a>
    </div>

    <Order v-else v-for="order in new_orders"
    :key="order.id"
    :order="order"
    :neww="true"
    :my="false"
    :close="false"
    @Take_Order="$emit('Take_Order', order)"
    @Change_Status="$emit('Change_Status', order, 1)"
    @Delete_Order="$emit('Delete_Order', order.id)"
    />
    
   <Pager v-if="count_pages_new_or > 1 && count_new_or != 0"
   :count_pages = "count_pages_new_or"
   :cur_page = "cur_page_new_or"
   cur_tab="new_orders"
    />
    
</template>
