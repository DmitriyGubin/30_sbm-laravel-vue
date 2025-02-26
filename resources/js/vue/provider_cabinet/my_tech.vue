<script>
import Tech from './tech.vue';
export default {
    data() {
        return {
            manager: null
        }
    },
    components: {
        Tech
    },
    props: ['tech'],
    methods: {
        Get_Manager: function () {
            axios.post('/get_first_manager').then(res => {
                this.manager = res.data;
            });
        },
        Phone_Convertor: function(phone){
            phone = phone.replace(/[^0-9]+/g, '');
            return phone;
        }
    },
    beforeMount() {
        this.Get_Manager();
    }
}

</script>

<template>

    <div v-if="tech.length == 0" class="empty_box">
        <svg class="bloknot" width="104px" height="104px" viewBox="0 0 104 104" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>F6BA100F-EFD6-429A-853A-76DB86832761</title><g id="\uD83D\uDC68\uD83C\uDFFB\u200D\uD83D\uDCBC-\u0417\u0430\u043A\u0430\u0437\u0447\u0438\u043A" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Web-2.0-My-orders--v-1440" transform="translate(-669, -144)" fill="#C8C8C8"><g id="Message" transform="translate(496, 144)"><g id="Icon/24/Intellicon/-time-/-calendar" transform="translate(173, -0)"><path d="M34.6666667,8.66666667 L34.6656667,12.9996667 L69.3326667,12.9996667 L69.3333333,8.66666667 L78,8.66666667 L77.9996667,12.9996667 L86.6666667,13 C91.4531345,13 95.3333333,16.8801988 95.3333333,21.6666667 L95.3333333,86.6666667 C95.3333333,91.4531345 91.4531345,95.3333333 86.6666667,95.3333333 L17.3333333,95.3333333 C12.5468655,95.3333333 8.66666667,91.4531345 8.66666667,86.6666667 L8.66666667,21.6666667 C8.66666667,16.8801988 12.5468655,13 17.3333333,13 L25.9996667,12.9996667 L26,8.66666667 L34.6666667,8.66666667 Z M86.6666667,43.3326667 L17.3326667,43.3326667 L17.3333333,86.6666667 L86.6666667,86.6666667 L86.6666667,43.3326667 Z M25.9996667,21.6666667 L17.3333333,21.6666667 L17.3326667,34.6666667 L86.6666667,34.6666667 L86.6666667,21.6666667 L77.9996667,21.6666667 L78,26 L69.3333333,26 L69.3326667,21.6666667 L34.6656667,21.6666667 L34.6666667,26 L26,26 L25.9996667,21.6666667 Z" id="icon"></path></g></g></g></g></svg> 
        <div class="empty_title">
            Пока нет техники
        </div>
    </div>

    <template v-else>
        <div v-if="manager != ''">
            <div class="label_manager">Cвязаться по watsapp с менеджером сервиса по вопросам редактирования характеристик:</div>
            <a target="_blank" class="man_wats" :href="'https://wa.me/' + Phone_Convertor(manager.phone)">
                <div class="man_name">{{ manager.name + ' ' + manager.phone }}</div>
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

        <Tech v-for="item in tech"
        :key="item.id"
        :item="item"
        />
    </template>

</template>
