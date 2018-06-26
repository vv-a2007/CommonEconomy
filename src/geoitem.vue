<template>
    <div class="row geoitem">
        <span  class="col-lg-12 geoName">{{geoName}}</span>
        <hr style="line-height:1px">
        <span v-show="!choiseMode" class="col-lg-10 geoOption">{{geoOption}}</span>
        <button v-show="(!choiseMode && geoOption_id===0)" class="col-lg-2 choiseButton" @:click.stop="'choiseMode=true'">...</button>
        <select v-show="choiseMode" class="col-lg-12 choiseList" @:change="choiseOption">
          <option v-show="option in listOptions" :geoOption_id="option.id" :geoOption="option.text" v:key="options.id">{{option.text}}</option>
        </select>
    </div>
</template>

<script>
    export default {
//        name: "geoItem",
 //       props:{startListOptions:Array, startParentId:Number},
        data () {
            return {
                id: 0,
                geoName: "default",
                geoOption: "default",
                geoOption_id: 0,
                listOptions:this.startListOptions,
                parent_id: this.startParentId,
                choiseMode:false
            }
        },
        mounted:{},
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