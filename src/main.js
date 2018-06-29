import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './routers/routes'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import homePage from './Home.vue'
import geographyList from "./geographyList.vue"
import geoStructure from "./geoStructure.vue"
import geoItemComp from './geoitem.vue'
//import Sites from './Sites.vue'
import userOrders from './userOrders.vue'


Vue.productionTip = false;
Vue.use(BootstrapVue);
Vue.use(VueRouter);


Vue.component('homePage', homePage);
Vue.component('geography-list', geographyList);
//Vue.component('geography-tree', geographyTree);
Vue.component('geo-structure', geoStructure);
Vue.component('geo-item', geoItemComp);
Vue.component('user-orders', userOrders);
//Vue.component('sites-list', Sites);

new Vue({
    el: "#app",
    render: h => h(App),
    router,
    components:{BootstrapVue, homePage, geographyList, geoStructure, geoItemComp}
});



