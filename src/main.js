import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import router from './routers/routes'


import homePage from './Home.vue'
import geographyList from "./geographyList.vue"
import geographyTree from "./geographyTree.vue"
import geoStructure from "./geoStructure.vue"
import geoItemComp from './geoitem.vue'
import sites from './Sites.vue'
import userOrders from './userOrders.vue'


Vue.productionTip = false;

Vue.use(VueRouter);

Vue.component('homePage', homePage);
Vue.component('geography-list', geographyList);
Vue.component('geography-tree', geographyTree);
Vue.component('geo-structure', geoStructure);
Vue.component('geo-item', geoItemComp);
Vue.component('user-orders', userOrders);
Vue.component('sites-list', sites);

new Vue({
    el: "#app",
    render: h => h(App),
    router
});
