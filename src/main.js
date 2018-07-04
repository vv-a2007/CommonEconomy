import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './routers/routes'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.productionTip = false;
Vue.use(BootstrapVue);
Vue.use(VueRouter);

new Vue({
    el: "#app",
    render: h => h(App),
    router
});



