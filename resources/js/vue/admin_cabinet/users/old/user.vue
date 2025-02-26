<script>

import Popup from './change_popup.vue';

export default {
    props: ['elem'],
    emits: ['remove_user','make_activ'],
    components: {
        Popup
    },
}


</script>

<template>

    <div class="pers_item">
        <div class="phone_name">
            <svg class="mark-class" width="22" height="21" viewBox="0 0 22 21" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <circle cx="11" cy="6" r="5.2" stroke="#3D3D3D" stroke-width="1.6"></circle>
                <path d="M1 19.4999C7 14 15 14 21 19.4999" stroke="#3D3D3D" stroke-width="1.6"
                    stroke-linecap="round"></path>
            </svg>
            <div class="phone_name">
                <span class="bold">{{ elem.name }}</span>
                <span>{{ elem.phone }}</span>
            </div>
        </div>

        <div class="butt_box">
            <button v-if="elem.activity == false" class="univ_button" @click="$emit('make_activ', elem.id)">Активировать</button>
            <a class="univ_button" data-fancybox="" :data-src="'#user_popup_'+elem.id" href="javascript:;">Изменить</a>
            <button class="univ_button" @click="$emit('remove_user', elem.id)">Удалить</button>
        </div>
    </div>

    <Popup 
        :elem="elem"
    />
</template>
