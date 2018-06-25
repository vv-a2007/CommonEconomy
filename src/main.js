import Vue from 'vue'
import geoStructure from "./geostructure";
import geoItem from './geoitem'

Vue.productionTip = false;

Vue.component('geo-structure', geoStructure);
Vue.component('geo-item', geoItem);


