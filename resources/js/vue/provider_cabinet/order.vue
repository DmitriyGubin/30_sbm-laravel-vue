<script>

export default {
    props: ['order','arch','my','loader'],
    emits: ['Take_Order','Close_Order','Return_To_Work'],
    data() {
        return {
            hide: false
        }
    },

    methods: {
        Make_Date: function(datee){
            let date = datee.split('T')[0];
            date = date.split('-');
            return date[2] + '.' + date[1] + '.' + date[0];
        },
        Phone_Convertor: function(phone){
            phone = phone.replace(/\+/, '');
            phone = phone.replace(/\(/, '');
            phone = phone.replace(/\)/, '');
            phone = phone.replace(/\s/, '');
            phone = phone.replace(/-/, '');
            return phone;
        }
    }
}

</script>

<template>

    <div class="order_item">
        
        <h2 class="order_title">
            Заказ № {{ order.order.id }} от {{ Make_Date(order.order.created_at) }}
        </h2>
        
        <div class="main_line">
            <div class="ab_item">
                <div class="label">Техника:</div>
                <div class="result">{{ order.order.tech }}</div>
            </div>
            <div class="ab_item">
                <div class="label">Дата заказа:</div>
                <div class="result">{{ order.order.date }}</div>
            </div>
            <div class="ab_item">
                <div class="label">Время начала работ:</div>
                <div class="result">{{ order.order.time }}</div>
            </div>
            <div class="ab_item">
                <div class="label">Кол-во часов:</div>
                <div class="result">{{ order.order.interval }}</div>
            </div>
        </div>

        <div class="button_line">
            <template v-if="my">
                <button @click="$emit('Take_Order', order)" class="univ_button">
                    <span v-if="loader == false">Взять заказ</span>
                    <div v-else class="loader"></div>
                </button>
                <button @click="$emit('Close_Order', order.id)" class="univ_button">Отказаться</button>
            </template>
            <button @click="$emit('Return_To_Work', order)" v-if="arch" class="univ_button">Вернуть в работу</button>
            <button @click="hide=!hide" class="univ_button">
                {{ hide == false ? 'Посмотреть' : 'Скрыть' }}
            </button>
        </div>

        <transition name="fade">
            <div class="hide_boxx" v-show="hide">
                <div class="ab_item">
                    <div class="label">Адрес заказа: </div>
                    <div class="result">{{ order.order.where }}</div>
                </div>

                <div class="ab_item">
                    <div class="label">Стоимость: </div>
                    <div class="result">{{ order.order.price_provider }}</div>
                </div>

                <div class="ab_item">
                    <div class="label">Форма оплаты: </div>
                    <div class="result">{{ order.order.money_provider }}</div>
                </div>

                <div class="ab_item">
                    <div class="label">Имя менеджера: </div>
                    <div class="result">{{ order.manager.name }}</div>
                </div>

                <div class="ab_item">
                    <div class="label">Телефон менеджера: </div>
                    <a class="result" :href="'tel:'+ order.manager.phone">
                       {{ order.manager.phone }}
                    </a>
                </div>

                <div class="ab_item">
                    <a target="_blank" :href="'https://wa.me/' + Phone_Convertor(order.manager.phone)">
                        <svg class="icon_wats" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

                            <title>whatsapp [#128]</title>
                            <desc>Created with Sketch.</desc>
                            <defs>
                        
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7599.000000)" fill="#000000">
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path d="M259.821,7453.12124 C259.58,7453.80344 258.622,7454.36761 257.858,7454.53266 C257.335,7454.64369 256.653,7454.73172 254.355,7453.77943 C251.774,7452.71011 248.19,7448.90097 248.19,7446.36621 C248.19,7445.07582 248.934,7443.57337 250.235,7443.57337 C250.861,7443.57337 250.999,7443.58538 251.205,7444.07952 C251.446,7444.6617 252.034,7446.09613 252.104,7446.24317 C252.393,7446.84635 251.81,7447.19946 251.387,7447.72462 C251.252,7447.88266 251.099,7448.05372 251.27,7448.3478 C251.44,7448.63589 252.028,7449.59418 252.892,7450.36341 C254.008,7451.35771 254.913,7451.6748 255.237,7451.80984 C255.478,7451.90987 255.766,7451.88687 255.942,7451.69881 C256.165,7451.45774 256.442,7451.05762 256.724,7450.6635 C256.923,7450.38141 257.176,7450.3464 257.441,7450.44643 C257.62,7450.50845 259.895,7451.56477 259.991,7451.73382 C260.062,7451.85686 260.062,7452.43903 259.821,7453.12124 M254.002,7439 L253.997,7439 L253.997,7439 C248.484,7439 244,7443.48535 244,7449 C244,7451.18666 244.705,7453.21526 245.904,7454.86076 L244.658,7458.57687 L248.501,7457.3485 C250.082,7458.39482 251.969,7459 254.002,7459 C259.515,7459 264,7454.51465 264,7449 C264,7443.48535 259.515,7439 254.002,7439" id="whatsapp-[#128]">
                        
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
        </transition>
    </div>
</template>
