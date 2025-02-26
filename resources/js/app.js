import '../css/jquery.fancybox.min.css';
import './bootstrap';
import { IMaskDirective } from 'vue-imask';

//import jQuery from 'jquery';
import $ from 'jquery';
window.$ = jQuery;

import '@fancyapps/fancybox';

import 'jquery-mask-plugin';

import {createApp} from 'vue';
import main_adminka from './vue/admin_cabinet/main.vue';
import main_customer from './vue/customer_cabinet/main.vue';
import main_manager from './vue/manager_cabinet/main.vue';
import main_provider from './vue/provider_cabinet/main.vue';
import tech_popup from './vue/tech_popup.vue';

const application = createApp(main_adminka);
application.directive('imask', IMaskDirective);
application.mount("#vue_users_all");

const app_cab_customer = createApp(main_customer);
app_cab_customer.directive('imask', IMaskDirective);
app_cab_customer.mount("#customer_ofice");

const app_cab_manager = createApp(main_manager);
app_cab_manager.directive('imask', IMaskDirective);
app_cab_manager.mount("#manager_ofice");

const app_cab_provider = createApp(main_provider);
app_cab_provider.mount("#provider_ofice");

const app_tech_popup = createApp(tech_popup);
app_tech_popup.mount("#popup_tech_main");

