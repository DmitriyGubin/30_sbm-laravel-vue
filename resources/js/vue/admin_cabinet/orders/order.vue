<script>

export default {
    props: ['order','type'],
    inject: ['Delete_Order'],
    data() {
        return {
            hide: false,
            edit: false,
            save: false,
        }
    },
    methods: {
        Make_Date: function(datee){
            let date = datee.split('T')[0];
            date = date.split('-');
            return date[2] + '.' + date[1] + '.' + date[0];
        },
        Show_Save: function () { 
            if(this.all_cond)
            {
                this.save = true;
            }
            else
            {
                this.save = false;
            }
        },
        Phone_Convertor: function(phone){
            phone = phone.replace(/\+/, '');
            phone = phone.replace(/\(/, '');
            phone = phone.replace(/\)/, '');
            phone = phone.replace(/\s/, '');
            phone = phone.replace(/-/, '');
            return phone;
        },
        Save_Order: function() {

            let post_data = {
                id: this.order.id,
                tech: this.order.tech,
                date: this.order.date,
                time: this.order.time,
                interval: this.order.interval,
                price: this.order.price,
                money: this.order.money,
                money_provider: this.order.money_provider,
                price_provider: this.order.price_provider,
                job: this.order.job,
                where: this.order.where,
                detail_id: this.order.detail_id,
                detail: 'no',
            };
            if(this.order.detail != '' && this.order.detail != null)
            {
                post_data.detail = 'yes';
                post_data.name = this.order.detail.name;
                post_data.inn = this.order.detail.inn;
                post_data.kpp = this.order.detail.kpp;
                post_data.bik = this.order.detail.bik;
                post_data.check = this.order.detail.check;
                post_data.bank_name	 = this.order.detail.bank_name;
            }

            axios.post('/save_order', post_data).then(res => { 
                this.save = false;
                this.edit = false;
            });
        },
    },
    computed: {
        empty_cond: function() {
            return this.order.tech != '' && 
            this.order.date != '' && 
            this.order.time != '' && 
            this.order.interval != '' && 
            this.order.where != '' && 
            this.order.job != '';
        },
        inn() {
            let inn = this.order.detail.inn;
            return (inn == null || inn == '') ? true : (String(inn).length == 12 || String(inn).length == 10);
        },
        kpp() {
            let kpp = this.order.detail.kpp;
            return (kpp == null || kpp == '') ? true : String(kpp).length == 9;
        },
        bik() {
            let bik = this.order.detail.bik;
            return (bik == null || bik == '') ? true : String(bik).length == 9;
        },
        check() {
            let check = this.order.detail.check;
            return (check == null || check == '') ? true : String(check).length == 20;
        },
        all_cond(){
            if(this.order.detail == null)
            {
                return this.empty_cond;
            }
            else
            {
                return this.empty_cond && this.inn && this.kpp && this.bik && this.check;
            }
        }
    }
}

</script>

<template>
    <div class="order_item form_box">
    
        <h2 class="order_title">
            Заказ № {{ order.id }} от {{ Make_Date(order.created_at	) }} <br>
            {{ order.created_at != order.updated_at ? ('Обновлён ' + Make_Date(order.updated_at)) : null }}
        </h2>

        <div class="main_line">
            <div class="inp_box">
                <label for="tech">Какая техника*</label>
                <input :class="[{error: order.tech == ''},{editt: edit}]" @input="Show_Save" v-model="order.tech" id="tech" type="text" :readonly="!edit">
            </div>

            <div class="inp_box">
                <label for="when">Когда едем*</label>
                <input :class="[{error: order.date == ''},{editt: edit}]" @input="Show_Save" v-model="order.date" id="when" type="date" :readonly="!edit">
            </div>

            <div class="inp_box">
                <label for="time">Ко скольки едем*</label>
                <input :class="[{error: order.time == ''},{editt: edit}]" @input="Show_Save" v-model="order.time" id="time" type="time" :readonly="!edit">
            </div>

            <div class="inp_box">
                <label for="interval">На сколько едем*</label>
                <input :class="[{error: order.interval == ''},{editt: edit}]" @input="Show_Save" v-model="order.interval" id="interval" type="text" :readonly="!edit">
            </div>
        </div>

        <div class="button_line">
            <button @click="hide=!hide" class="univ_button">
                {{ hide == false ? 'Посмотреть' : 'Скрыть' }}
            </button>
            
            <button v-if="!save" @click="edit=!edit" class="univ_button">
                {{ edit == false ? 'Редактировать' : 'На редактировании' }}
            </button>

            <button v-else @click="Save_Order" class="univ_button save">Сохранить</button>

            <button class="univ_button" @click="Delete_Order(order.id,type)">Удалить</button>
        </div>

        <transition name="fade">
        <div v-show="hide">
            <div class="hide_box">
                <div class="inp_box">
                    <label for="price">Стоимость (заказчик)</label>
                    <input :class="[{editt: edit}]" @input="Show_Save" v-model="order.price" id="price" type="text" :readonly="!edit">
                </div>

                <div class="inp_box">
                    <label for="money">Какой расчёт (заказчик)*</label>
                    <select :class="[{editt: edit}]" @change="Show_Save" id="money" :disabled="!edit" v-model="order.money">
                        <option>Безналичные с НДС</option>
                        <option>Безналичные без НДС</option>
                        <option>Наличные</option>
                    </select>
                </div>

                <div class="inp_box">
                    <label for="price_">Стоимость (поставщик)</label>
                    <input :class="[{editt: edit}]" @input="Show_Save" v-model="order.price_provider" :readonly="!edit" id="price_" type="text">
                </div>

                <div class="inp_box">
                    <label for="money_">Какой расчёт (поставщик)</label>
                    <select id="money_" :class="[{editt: edit}]" @change="Show_Save" :disabled="!edit" v-model="order.money_provider">
                        <option>Безналичные с НДС</option>
                        <option>Безналичные без НДС</option>
                        <option>Наличные</option>
                    </select>
                </div>

                <div class="inp_box"> 
                    <label for="job">Что делаем*</label> 
                    <textarea :class="[{error: order.job == ''},{editt: edit}]" @input="Show_Save" v-model="order.job" :readonly="!edit" id="job"></textarea>
                </div>

                <div class="inp_box">
                    <label for="too">Куда едем*</label>
                    <input :class="[{error: order.where == ''},{editt: edit}]" @input="Show_Save" v-model="order.where" id="too" type="text" :readonly="!edit">
                </div>
            </div>

            <template v-if="order.detail != '' && order.detail != null">
                <h2 class="order_title margin_top"> Реквизиты заказчика </h2>
                <div class="hide_box">
                    <div class="inp_box">
                        <label>Название компании или юр. лица</label>
                        <input v-model="order.detail.name" :class="[{editt: edit}]" @input="Show_Save" :readonly="!edit" type="text">
                    </div>
        
                    <div class="inp_box">
                        <label>ИНН (12 или 10 цифр)</label>
                        <input v-model="order.detail.inn" :class="[{error: !inn},{editt: edit}]" @input="Show_Save" :readonly="!edit" type="number">
                    </div>
        
                    <div class="inp_box">
                        <label>КПП (9 цифр)</label>
                        <input v-model="order.detail.kpp" :class="[{error: !kpp},{editt: edit}]" @input="Show_Save" :readonly="!edit" type="number">
                    </div>
        
                    <div class="inp_box">
                        <label>БИК (9 цифр)</label>
                        <input v-model="order.detail.bik" :class="[{error: !bik},{editt: edit}]" @input="Show_Save" :readonly="!edit" type="number">
                    </div>
        
                    <div class="inp_box">
                        <label>Расчётный счёт (20 цифр)</label>
                        <input v-model="order.detail.check" :class="[{error: !check},{editt: edit}]" @input="Show_Save" :readonly="!edit" type="text">
                    </div>
        
                    <div class="inp_box">
                        <label>Название банка</label>
                        <input v-model="order.detail.bank_name" :class="[{editt: edit}]"  @input="Show_Save" :readonly="!edit" type="text">
                    </div>
    
                    <div></div>
    
                    <div v-if="order.detail.file_name != '' && order.detail.file_name != null" class="doc_box">
                        <a data-fancybox="" :href="'/storage/img/recviz/'+order.detail.file_name">
                            <svg width="60" height="71" viewBox="0 0 60 71" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.2" d="M0 3C0 1.34315 1.34315 0 3 0H33.7835C34.5637 0 35.3131 0.303905 35.8729 0.847258L51.0894 15.6162C51.6715 16.1812 52 16.9578 52 17.7689V62C52 63.6569 50.6569 65 49 65H3C1.34314 65 0 63.6569 0 62V3Z" fill="url(#paint0_radial_132_1436)"/>
                                <path d="M59.3057 22.3008C59.7489 22.736 60 23.3237 60 23.9403V68.6786C60 69.9626 58.9438 71 57.6364 71H10.3636C9.05625 71 8 69.9626 8 68.6786V8.32143C8 7.03739 9.05625 6 10.3636 6H41.7335C42.3614 6 42.967 6.24665 43.4102 6.68192L59.3057 22.3008ZM38.6785 36.0219L34.1566 43.4432L29.5903 36.019C29.5114 35.8908 29.4001 35.7847 29.2672 35.7112C29.1343 35.6376 28.9843 35.5989 28.8318 35.5989H25.9924C25.8251 35.599 25.6612 35.6455 25.5197 35.7331C25.4212 35.7941 25.3358 35.8736 25.2686 35.967C25.2013 36.0604 25.1534 36.1659 25.1277 36.2774C25.102 36.389 25.0989 36.5045 25.1186 36.6172C25.1384 36.7299 25.1805 36.8378 25.2427 36.9345L31.3247 46.3958L25.1607 56.0282C25.0719 56.1671 25.0248 56.3278 25.0248 56.4918C25.0248 56.7227 25.1182 56.9441 25.2844 57.1074C25.4507 57.2706 25.6761 57.3623 25.9112 57.3623H28.4565C28.6077 57.3623 28.7564 57.3243 28.8884 57.2519C29.0204 57.1795 29.1313 57.0752 29.2107 56.9488L33.8419 49.5877L38.4436 56.9474C38.523 57.0742 38.6341 57.179 38.7664 57.2516C38.8986 57.3243 39.0477 57.3624 39.1993 57.3623H41.9677C42.1374 57.3623 42.3035 57.3145 42.4463 57.2245C42.5443 57.1628 42.6289 57.0827 42.6954 56.9888C42.7618 56.895 42.8088 56.7892 42.8336 56.6775C42.8585 56.5658 42.8606 56.4504 42.8401 56.3379C42.8195 56.2254 42.7765 56.1179 42.7137 56.0217L36.5217 46.551L42.8223 36.941C42.9142 36.8003 42.9629 36.6366 42.9626 36.4695C42.9626 36.2386 42.8692 36.0172 42.703 35.8539C42.5368 35.6907 42.3113 35.5989 42.0763 35.5989H39.4393C39.2862 35.599 39.1356 35.6381 39.0024 35.7124C38.8692 35.7866 38.7571 35.8928 38.6785 36.0219Z" fill="white"/>
                                <path d="M42 22V6C42.6403 6 43.2544 6.25435 43.7071 6.70711L59.2929 22.2929C59.7456 22.7456 60 23.3597 60 24H44C42.8954 24 42 23.1046 42 22Z" fill="#C4D5FF"/>
                                <defs>
                                <radialGradient id="paint0_radial_132_1436" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(35.5 44.5) rotate(-125.69) scale(43.7093 34.9674)">
                                <stop stop-color="white" stop-opacity="0"/>
                                <stop offset="1" stop-color="white"/>
                                </radialGradient>
                                </defs>
                            </svg>
                        </a>
                    </div>
                </div>
            </template>

            <div class="clients_grid">
                
                <div class="client_box">
                    <div class="client_name">Заказчик: {{ order.user.name }}</div>
                    <a class="wats_box" target="_blank" :href="'https://wa.me/' + Phone_Convertor(order.user.phone)">
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
                        <div class="phone_client">{{ order.user.phone }}</div>
                    </a>
                </div>

                <div class="manager_box" v-if="order.manager != null">
                    <div class="client_name">Менеджер: {{ order.manager.name }}</div>
                    <a class="wats_box" target="_blank" :href="'https://wa.me/' + Phone_Convertor(order.manager.phone)">
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
                        <div class="phone_client">{{ order.manager.phone }}</div>
                    </a>
                </div>

                <div class="provider_box" v-if="order.provider != null">
                    <div class="client_name">Поставщик: {{ order.provider.name }}</div>
                    <a class="wats_box" target="_blank" :href="'https://wa.me/' + Phone_Convertor(order.provider.phone)">
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
                        <div class="phone_client">{{ order.provider.phone }}</div>
                    </a>
                </div>

            </div>
        </div>
        </transition>
    </div>
</template>
