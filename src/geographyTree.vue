<template>
    <div>
        <div v-for="(row, indexX) in elArray" :key="indexX"class="col-lg-12" >
           <div class="row">
               <geo-item-comp v-if="elArray[indexX][indexY].id>0" v-for="(col, indexY) in row" :key="indexY"
                :id="elArray[indexX][indexY].cage"
                :_id_geo="elArray[indexX][indexY].id"
                :_geoName="elArray[indexX][indexY].geo_name">
               </geo-item-comp>
             </div>
         </div>
    </div>
</template>

<script>

    import geoItemComp from './geoitem.vue'

    export default {
        name: 'geographyTree',
        data() {
            return {
                geoArray: [[{}]],
                elArray:[[{}]],
                mes:"",
                cur:0
            }
        },
        components :{geoItemComp},
        watch: {
            // при изменениях маршрута запрашиваем данные снова
            '$route': 'UpdateTree(this)'
        },

    created() {this.UpdateTree(this)},


        methods: {
            UpdateTree ($this){
                let link = $this;
                let jqxhr = $.get("http://ce.my/Get_geo_tree.php", "json");
                jqxhr.done(function () {
 //                   try {
                        let options = JSON.parse(jqxhr.responseText);
                        let count_root_element = 0;
                        let number_root = 0;
                        let root_id = 0;
                        let root_geo_name ="";
                        for (let i = 0; i < options.length; i++) {
                             let notparent = options[i].id_parent;
                             let nooption = options[i].id_option;
                            if (notparent === 0 && nooption === 0) {
                                root_id = options[i]['id'];
                                root_geo_name = options[i]['geo_name'];
                                number_root = i;
                                count_root_element++
                            }
                        }

                        const return_tree = function ($element_id,$root_geo_name) {
                            let treeArray=[[]];
                            treeArray[0] = new Array (100);
                            treeArray[0].fill(0);
                            treeArray[0][0] = {'id':$element_id,'id_option':0, 'id_parent': 0, 'geo_name':$root_geo_name};
                            let str = 0;
                            let col = 0;
                            for (let i = 0; i < options.length; i++) {
                                if ((options[i].id_parent === $element_id) && (options[i].id_option === 0)) {
                                        col=1;
                                        treeArray[str][1]={'id': options[i].id, 'id_parent' : $element_id, 'id_option':0, 'geo_name':options[i].geo_name};
                                        for (let ii = 0; ii < options.length; ii++) {
                                              if ((options[ii].id === options[i].id) &&(options[ii].id_option !== 0)) {
                                                  treeArray[str][1]={'id': options[ii].id, 'id_parent' : $element_id, 'id_option':options[ii].id_option, 'geo_name': options[ii].geo_name};
                                                  str++;
                                                  treeArray[str] = new Array (100);
                                                  treeArray[str].fill(0);
                                              }
                                        }
                                       str++;
                                       treeArray[str] = new Array (100);
                                       treeArray[str].fill(0);
                                }
                            }

                            let x=0; let y=0;
                            for (x = 0; x <= str; x++) {
                                for (let y = 0; y <= col; y++) {
                                     if ( treeArray[x][y] === 0) { treeArray[x][y] = {'id': 0, 'id_option': 0, 'id_parent': 0,'geo_name':"" }}}}

                            x=0;y=0;
                            treeArray.slice(0,str+1);
                            for ( x = 0; x <=str; x++) {treeArray[x] = treeArray[x].slice(0,col+1)}

                            if ((treeArray[0].length<2) && (treeArray.length<2))
                            {   treeArray[0][0]=null;
                                treeArray = treeArray[0].slice(-1);
                                treeArray = treeArray.slice(-1);
                                str=-1; col=0;
                            }
                            let endArray = [[]];
                            x=0;y=0;
                            for ( x = 0; x <= str; x++) {
                                    for ( y = 0; y <= col; y++) {

                                        if ((treeArray[x][y].id !== $element_id) && (treeArray[x][y].id !==0)) {
                                            let newArray = return_tree(treeArray[x][y].id, treeArray[x][y].geo_name);
                                            if (newArray.length > 1 && newArray[0].length>1) {
                                                let width = newArray[0].length;
                                                let high = newArray.length;


                                                endArray[0] = new Array(str + high);
                                                for (let k = 0; k < (str + high); k++) {
                                                    endArray[k] = new Array(col + width);
                                                    endArray[k].fill(0)
                                                }
                                                let xx=0; let yy=0;
                                                for ( xx = 0; xx <= str; xx++) {
                                                    for (yy = 0; yy <= col; yy++) {
                                                        let newX, newY;
                                                        if (xx > x) {
                                                            newX = xx + high-1
                                                        } else {newX = xx}
                                                        if (yy > y) {
                                                            newY = yy + width-1
                                                        }else {newY = yy}

                                                        if ((xx <= x) && (yy <= y)) {
                                                            endArray[newX][newY] = treeArray[xx][yy]
                                                        }
                                                        else if ((xx > x) && (yy <= y)) {
                                                            endArray[newX][newY] = treeArray[xx][yy]
                                                        }
                                                        else if ((xx <= x) && (yy > y)) {
                                                            endArray[newX][newY] = treeArray[xx][yy]
                                                        }
                                                        else if ((xx > x) && (yy > y)) {
                                                            endArray[newX][newY] = treeArray[xx][yy]
                                                        }
                                                    }
                                                }
                                                xx=0; yy=0;
                                                for (xx = 0; xx <= high-1; xx++) {
                                                    for (yy = 0; yy <= width-1; yy++) {
                                                        if (!((xx === 0) && (yy === 0))) {
                                                            endArray[xx-1 + high-1][yy + width-1] = newArray[xx][yy]
                                                        }
                                                    }
                                                }

                                            }
                                            else { endArray = treeArray}
                                        }
                                    }
                                }

                            return endArray;
                        };


                        if ((count_root_element) < 2 && (count_root_element) > 0) {
                            let newGeo;
                            link.geoArray = return_tree(root_id, root_geo_name);
                            for (let www = 0; www < link.geoArray.length; www++) {
                                for (let zzz = 0; zzz < link.geoArray[www].length; zzz++) {
                                    if (!(link.geoArray[www][zzz])){
                                        link.geoArray[www][zzz]={};
                                        link.geoArray[www][zzz].id=0;
                                        link.geoArray[www][zzz].id_parent=0;
                                        link.geoArray[www][zzz].id_option=0;
                                        link.geoArray[www][zzz].geo_name="";
                                    }
                                    link.geoArray[www][zzz].cage = "geoitem" + String(www * 12 + zzz);
                                }
                            }

                            link.elArray=[];
                            for (let ww = 0; ww < link.geoArray.length; ww++) {
                                link.elArray[ww]=[];
                                for (let zz = 0; zz < link.geoArray[ww].length; zz++) {
                                    link.elArray[ww][zz]={id:0, id_parent:0, id_option:0, geo_name:""};
                                }
                            }

                            for (let w = 0; w < link.geoArray.length; w++) {
                                for (let z = 0; z < link.geoArray[w].length; z++) {
                                    if (link.geoArray[w][z] && ((link.geoArray[w][z].id !==0))) {
                                        newGeo = link.elArray[w][z];
                                        newGeo.id = link.geoArray[w][z].id;
                                        newGeo.id_parent = link.geoArray[w][z].id_parent;
                                        newGeo.id_option = link.geoArray[w][z].id_option;
                                        newGeo.geo_name = link.geoArray[w][z].geo_name;

                                    }
                                    else {
                                        newGeo = link.elArray[w][z];

                                        }
                                    }
                            }
                    return true;

                } else {
                            link.mes = "Must be only one root item, wrong data";
                            return (false);
                        }
  //                  }
  //                  catch (e) {
  //                      link.mes = "SERVER not working, try later";
  //                      return (false);
  //                  }
                });
                jqxhr.fail(function () {
                    link.mes = "SERVER not available, try later";
                    return (false);
                })}
        }
    }
</script>

<style>

</style>