<template>
  <div>
      <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12 ">
                    <b-nav id="geo" pills>
                        <b-nav-item  v-for="item in geoList"  :key="item.value" :value="item.value" @click.prevent="selectGeo($event)">{{item.geoname}}</b-nav-item>
                    </b-nav>
                </div>
                <div class="row">
                    <div class="col-lg-12" id="basic-grid"></div>
                </div>
            </div>
        </div>
    </div>
    <div v-if=" mes!=='' " class="row" id="message" >
        <div  class="col-lg-12 ">
            <span> Message:  </span>
            <span :style="'color:red'">{{mes}}</span>
            <span>       </span>
            <button v-on:click="mes = ''">ok</button>
        </div>
    </div>
        <geography-tree></geography-tree>>
  </div>
</template>

<script>

import geographyTree from "./geographyTree.vue";

export default {

    name: "geoStructure",

    components:{geographyTree},

    data() {
        return {
                geoList:[{
                          geoname:"Geography structures",
                          geoId:0,
                          geoTable:"",
                          value:0
                        }],
                activGeo:0,
                mes:"Start loading ....."
               }
     },

    watch: {
        // при изменениях маршрута запрашиваем данные снова
        '$route':'refresh_list'},

    mounted() {this.refresh_list()},

    methods: {

        refresh_list: function () {
            let link = this;
            let jqxhr = $.get("http://ce.my/Get_list_geos.php", "json");
            jqxhr.done(function () {
                    try {
                        let options = JSON.parse(jqxhr.responseText);
                        for (let i = 0; i < options.length; i++) {
                            link.geoList[i] = {
                                                geoname : options[i]['geo_name'],
                                                geoId : options[i]['id'],
                                                geoTable : options[i]['table_name'],
                                                value : i
                                              };
                        }
                        this.mes = "";
                        return (true);
                    }
                    catch (e) {
                        link.mes = "SERVER not working, try later";
                        return (false);
                    }
                }
            );
            jqxhr.fail(function () {
                link.mes = "SERVER not available, try later";
                return (false);
            })
        },

        selectGeo : function ($event) {
            this.activGeo = event.target.getAttribute("value");
            $("#geo a").removeClass("active");
            event.target.setAttribute("class","nav-link active");
        }
    }
}

</script>

<style>

</style>