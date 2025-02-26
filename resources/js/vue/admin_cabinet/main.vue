<script>

import All_users from './users/all_users.vue';
import Statistic from './statistic/statistic.vue';
import All_orders from './orders/all_orders.vue';

export default {
    components: {
        All_users, Statistic, All_orders
    },

    data() {
        return {
            current_tab: 'Заказы',
            tabs: [
                { comp: 'All_orders', name: 'Заказы' },
                { comp: 'All_users', name: 'Пользователи' },
                { comp: 'Statistic', name: 'Статистика' }
            ]
        }
    },
    computed:
    {
        current_comp() {
            return this.tabs.filter(elem => {
                if (elem.name == this.current_tab) {
                    return true;
                }
            })[0].comp;
        }
    }
}

</script>

<template>
   
    <div class="sub_menu">
        <button v-for="tab in tabs" @click="current_tab = tab.name"
            :class="['univ_button', { active: current_tab === tab.name }]">
            {{ tab.name }}
        </button>
    </div>

    <!-- Неактивные компоненты будут закэшированы! -->
    <keep-alive>
        <component 
        :is="current_comp"
        >
        </component>
    </keep-alive>

</template>
