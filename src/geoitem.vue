<template>
    <div class="row geoitem">
        <span  class="col-lg-12 geoName">{{geoName}}</span>
        <span v-show="!choiseMode" class="col-lg-10 geoOption">{{geoOption}}</span>
        <button v-show="geoOption_id===0" class="col-lg-2 choiseButton" v-on:click.stop="'choiseMode=true'">...</button>
        <select v-show="choiseMode" class="col-lg-12 dropdown unpadding choiseList" v-on:change="choiseOption">
          <option v-for="item in listOptions"  class="dropdown-item" v:key="item.id">{{item.text}}</option>
        </select>
    </div>
</template>

<script>
    export default {
          name: "geoItem",
 //       props:{startListOptions:Array, startParentId:Number},
        data () {
            return {
                id: 0,
                geoName: "default",
                geoOption: "default",
                geoOption_id: 0,
                listOptions:[{id:0,
                              text:""}],
                parent_id: 0,
                choiseMode:false
            }
        },
 //       mounted:{},
        methods:{
           choiseOption() {
               this.$emit('addOptionGeo',[this.id,this.geoOption_id]);
               choiseMode=true;
               geoOption="";
               geoOption_id=0
           }
        }
    }
</script>

<style scoped>
    .geoitem {border:2px ;
                     border-color:black}
</style>