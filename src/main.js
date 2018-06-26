import Vue from 'vue'
import geoStructure from "./geostructure.vue";
import geoItemComp from './geoitem.vue'

Vue.productionTip = false;

Vue.component('geo-structure', geoStructure);
Vue.component('geo-item', geoItemComp);


