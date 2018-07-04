import Vue from 'vue'
import VueRouter from 'vue-router'
import homePage from '../Home.vue'
import geographyList from "../geographyList.vue"
import geoStructure from "../geoStructure.vue"
import userOrders from '../userOrders'
import deliveryPoints from '../deliveryPoints.vue'

Vue.use(VueRouter);

export default new VueRouter ({
    routes:[
        {
            path:'',
            component: homePage
        },
        {
            path:'/userorders',
            component: userOrders
        },
        {
            path:'/geographylist',
            component: geographyList
        },
        {
            path:'/geostructure',
            component: geoStructure
        },
        {
            path:'/delivery',
           component: deliveryPoints
         }
    ],
    mode: 'history'
})