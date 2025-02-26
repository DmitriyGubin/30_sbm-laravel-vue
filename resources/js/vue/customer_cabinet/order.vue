<script>
import axios from 'axios';
import Tech_Popup from '../tech_popup.vue';

export default {
    components: {
        Tech_Popup
    },
    props: ['order','status_id','rekv'],
    emits: ['Set_Count', 'Delete_Order'],
    data() {
        return {
            hide: false,
            edit: false,
            save: false
        }
    },
    methods: {
        Phone_Convertor: function(phone){
            phone = phone.replace(/\+/, '');
            phone = phone.replace(/\(/, '');
            phone = phone.replace(/\)/, '');
            phone = phone.replace(/\s/, '');
            phone = phone.replace(/-/, '');
            return phone;
        },
        Make_Date: function(datee){
            let date = datee.split('T')[0];
            date = date.split('-');
            return date[2] + '.' + date[1] + '.' + date[0];
        },
        Show_Save: function () { 
            if(this.empty_cond)
            {
                this.save = true;
            }
            else
            {
                this.save = false;
            }
        },
        Сhoice_Tech: function (tech_name) { 
            this.order.tech = tech_name;
            if(this.empty_cond) this.save = true;
        },
        Save_Order: function() {

            let post_data = {
                id: this.order.id,
                tech: this.order.tech,
                date: this.order.date,
                time: this.order.time,
                interval: this.order.interval,
                where: this.order.where,
                money: this.order.money,
                detail_id: this.order.detail_id,
                job: this.order.job,
                price: this.order.price
            };

            axios.post('/save_order', post_data).then(res => { 
                // console.log(res.data);
                this.save = false;
                this.edit = false;
            });
        },
        Change_Status: function (elem, stat_id) {
            let post_data = {
                id: elem.id,
                status_idd: stat_id
            };

            axios.post('/change_order_status', post_data).then(res => {
                elem.status_id = stat_id;
                this.edit = false;
                //$emit('Set_Count', status_id);//в теге
                this.$emit('Set_Count', this.status_id);
            });
        }
    },
    computed: {
        empty_cond: function() {
            return this.order.tech != '' && 
            this.order.date != '' && 
            this.order.time != '' && 
            this.order.interval != '' && 
            this.order.where !== '' && 
            this.order.job !== '';
        }
    },

}

</script>

<template>

    
    <div v-if="order.status_id == status_id" class="order_item form_box">
        
        <h2 class="order_title">
            Заказ № {{ order.id }} от {{ Make_Date(order.created_at	) }}
        </h2>
        <h2 class="order_title" v-if="order.find_supplier == 1">
            Ваша заявка принята и мы уже ищем Вам технику
        </h2>

        <div class="main_line">
            <div class="inp_box">
                <label for="tech">Какая техника*</label>
                <input ref="tech_name" :class="[{error: order.tech == ''},{editt: edit}]" @input="Show_Save" v-model="order.tech" id="tech" type="text" :readonly="!edit">
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
            <template v-if="status_id == 1">
                <template v-if="!save">
                    <button @click="edit=!edit" class="univ_button">
                        {{ edit == false ? 'Редактировать' : 'На редактировании' }}
                    </button>
                    <a v-show="edit != false" data-fancybox="" :data-src="'#tech_popup'+'_'+order.id" class="univ_button tech" href="javascript:;">
                        Выбрать технику
                    </a>
                </template>
                <button @click="Save_Order" v-else class="univ_button save">Сохранить</button>
            </template>
            <button v-if="status_id != 3" @click="Change_Status(order,3);" class="univ_button">
                Архивировать
            </button>
            <template v-else>
                <button class="univ_button" @click="$emit('Delete_Order', order.id)">Удалить</button>
                <button class="univ_button" @click="Change_Status(order,1);">Восстановить</button>
            </template>
        </div>

        <Tech_Popup 
        :id_popup="order.id"
        @Сhoice_Tech="Сhoice_Tech"
        />

        <transition name="fade">
            <div v-show="hide" class="hide_box">
                <div class="inp_box">
                    <label for="too">Куда едем*</label>
                    <input :class="[{error: order.where == ''},{editt: edit}]" @input="Show_Save" v-model="order.where" id="too" type="text" :readonly="!edit">
                </div>

                <div class="inp_box">
                    <label for="money">Какой расчёт*</label>
                    <select :class="[{editt: edit}]" @change="Show_Save" id="money" :disabled="!edit" v-model="order.money">
                        <option>Безналичные с НДС</option>
                        <option>Безналичные без НДС</option>
                        <option>Наличные</option>
                    </select>
                </div>

                <div class="inp_box">
                    <label for="price">Стоимость</label>
                    <input :class="[{editt: edit}]" @input="Show_Save" v-model="order.price" id="price" type="text" :readonly="!edit">
                </div>

                <div class="inp_box">
                    <label for="rekv">Реквизиты</label>
                    <select v-if="rekv.length != 0" class="form_select" :class="[{editt: edit}]" @change="Show_Save" id="rekv" :disabled="!edit" v-model="order.detail_id">
                        <option :value="null" :selected="order.detail_id == null">Реквизиты не выбраны</option>
                        <option :value="item.id" :selected="order.detail_id == item.id" v-for="item in rekv">
                            {{ (item.name == null || item.name == '') ? 'Реквизиты №' + item.id : item.name }}
                        </option>
                    </select>
                    <input v-else readonly type="text" value="Заполните реквизиты">
                </div>

                <div class="inp_box"> 
                    <label for="job">Что делаем*</label> 
                    <textarea :class="[{error: order.job == ''},{editt: edit}]" @input="Show_Save" v-model="order.job" :readonly="!edit" id="job"></textarea>
                </div>

                <div v-if="order.manager != null" class="client_box">
                    <div class="client_name">Ваш менеджер: {{ order.manager.name }}</div>
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
            </div>
        </transition>
    </div>
</template>
