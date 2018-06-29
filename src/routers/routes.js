import VueRouter from 'vue-router'
import homePage from '../Home.vue'
import geographyList from "../geographyList.vue"
import geoStructure from "../geoStructure.vue"
import userOrders from '../userOrders'
import sites from '../Sites'

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
            path:'/sites',
            component: sites
        },
        {
            path:'/geographylist',
            component: geographyList
        },
        {
            path:'/geostructure',
            component: geoStructure
        }
        ],
    mode: 'history'
})