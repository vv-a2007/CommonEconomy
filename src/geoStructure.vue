<template>
  <div>
      <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12 ">
                    <ul id="geo" class="nav nav-pills">
                        <li  v-for="item in geoList" class="nav-item" :value="item.value" @click.click.stop.prevent="selectGeo($event)"><a class="nav-link" :value="item.value" href="">{{item.geoname}}</a></li>
                    </ul>
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
            <button @:click="mes=''">ok</button>
        </div>
    </div>
    <div class="row">
        <geography-tree id="geostructure"></geography-tree>>
    </div>
  </div>
</template>

<script>

import geographyTree from "./geographyTree.vue";

export default {
    name: "geoStructure",

    components:{geographyTree:geographyTree},

    data() {
        return {
                geoList:[{
                          geoname:"default",
                          value:0
                        }],
                activGeo:0
               }
     },

    beforeMount() {this.refresh_list()},

    methods: {

        refresh_list: function () {
            let jqxhr = $.get("Get_list_geos.php", "json");
            jqxhr.done(function () {
                    try {
                        geo.geoList=[{
                            geoname:"default",
                            value:0
                        }];
                        let options = JSON.parse(jqxhr.responseText);
                        for (let i = 0; i < options.length; i++) {
                            geo.geoList[i] = {geoname:options[i]['geo_name'],
                                geoId:options[i]['id'],
                                geoTable:options[i]['geo_table'],
                                value:i};

                        }
                        return (true);
                    }
                    catch (e) {
                        message.mes = "SERVER not working, try later";
                        return (false);
                    }
                }
            );
            jqxhr.fail(function () {
                message.mes = "SERVER not available, try later";
                return (false);
            })
        },

        selectGeo : function ($event) {
            geo.activGeo = event.target.getAttribute("value");
            $("#geo a").removeClass("active");
            event.target.setAttribute("class","nav-link active");
        }
    }
}
</script>
<style>

</style>