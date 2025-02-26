<script>
import User from './user.vue';

export default {
    props: ['elem'],
    emits: ['remove_user', 'make_activ'],
    components: {
        User
    },
    data() {
        return {
            hide: false
        }
    }
}

</script>

<template>
    <div class="sub_box" v-if="elem.users.length != 0">
        <div class="first_line">
            <div class="cat_name">{{ elem.name }}</div>
            <div class="arrow" :class="{active: (hide)}" @click="hide = !hide">
                <svg width="11" height="18" viewBox="0 0 11 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 17L9 9L1 0.999999" stroke="white" stroke-width="1.6" stroke-linecap="round"></path>
                </svg>
            </div>
        </div>

        <transition name="fade">
        <div class="hide_box users" v-show="hide">
            <User v-for="item in elem.users" 
            :key="item.id" 
            :elem="item" 
            @remove_user="$emit('remove_user', item.id)"
            @make_activ="$emit('make_activ', item.id)"
            />
        </div>
        </transition>
    </div>
</template>

<style>

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

</style>
