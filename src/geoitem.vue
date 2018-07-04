<template>
        <div class="col-lg-1">
            <div class="row">
            <div v-if="id_geo!==0" class="col-lg-12 geoitem">
                <div class="row">
                   <span  class="col-lg-12 geoName" :bind="geoName">{{geoName}}</span>
                </div>
                <div class="row">
                  <b-select  v-model="geoOption_id" :options="listOptions"  class="col-lg-12 dropdown unpadding" v-on:change="choiceOption"></b-select>
                </div>
                <div class="row">
                 <button  class="col-lg-2 addOptionButton" v-on:click.stop="addOption">∆</button>
                 <button v-show="geoOption_id === 0" class="col-lg-2 pluseButton" v-on:click.stop="plusItem">+</button>
                 <button  class="col-lg-2 delnButton" v-on:click.stop="delItem">x</button>
                </div>

            </div>
         </div>
        </div>
</template>

<script>
    export default {
          name: "geoItemComp",
          props:{'_id_geo' : Number, '_geoName' : String},
  //        geoOption:String, geoOption_id:Number, listOptions:Array[{id:Number,text:String}], parent_id:Number},
        data () {
            return {
                id_geo: this._id_geo,
                geoName : this._geoName,
                geoOption_id: 0,
                listOptions:[{text:"any", value:0}],
                geoOption: "",
                parent_id: 0,
                choiceMode:false,

            }
        },

        //       mounted:{},
        methods:{
           choiceOption() {
               this.$emit('addOptionGeo', [this.id_geo, this.geoOption_id]);
           },
         addOption (){},
         plusItem () {}  ,
         delItem (){}
        }
    }
</script>

<style scoped>
    .geoitem {border-style:solid; border-width:1px ;
                     border-color:black}
</style>