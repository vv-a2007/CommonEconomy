<template>
    <div class="col-lg-12">
        <span>GeoStructure : </span>
        <span>{{mes}}</span>
    </div>
</template>

<script>

    import geoItemComp from './geoitem.vue'

    export default {

        data(){
            return {
                loadUrl:"",
                geoArray:[],
                mes:"Load start"

            }
        },
        components: { geoItem:geoItemComp},

        methods : {

            DDD_created() {
                let jqxhr = $.get(this.loadUrl, "json");
                jqxhr.done(function () {
                    try {
                        let geoArray = [];
                        let options = JSON.parse(jqxhr.responseText);
                        let count_root_element = 0;
                        let number_root = 0;
                        let root_id = 0;
                        for (let i = 0; i < options.length; i++) {
                            if (options[i]['id_parent'] === 0 && options[i]['id_option'] === 0) {
                                root_id = options[i]['id'];
                                number_root = i;
                                count_root_element++
                            }
                        }
                        const return_tree = function ($element_id) {
                            let treeArray = [];
                            treeArray[0][0]['id'] = $element_id;
                            let def = 0;
                            let opt = 0;
                            for (let i = 0; i < options.length; i++) {
                                if (options[i]['id_parent'] === $element_id) {
                                    if (options[i]['id_option'] === 0) {
                                        treeArray[def][1]['id'] = options[i]['id'];
                                        treeArray[def][1]['id_parent'] = $element_id;
                                        def++;
                                    } else {
                                        treeArray[0][opt]['id'] = options[i]['id'];
                                        treeArray[0][opt]['id_option'] = options[i]['id_option'];
                                        treeArray[def][1]['id_parent'] = $element_id;
                                        opt++;
                                        def++;
                                    }
                                }
                            }
                            opt--;
                            def--;
                            for (let x = 0; x < opt; x++) {
                                for (let y = 0; y < opt; y++) {
                                    if (treeArray[x][y] === undefined) {
                                        treeArray[x][y] = 0
                                    }
                                    if (treeArray[x][y]['id'] !== $element_id) {
                                        let newArray = return_tree(treeArray[x][y]['id']);
                                        let end_array = treeArray.splice(x);
                                        for (let i = 0; i < newArray.length; i++) {
                                            for (let z = 0; z < newArray[i].length; z++) {
                                                treeArray[x + i][y + z] = newArray[i][z];
                                            }
                                            treeArray = treeArray + end_array;
                                        }
                                    }
                                }
                            }
                            return treeArray;
                        };


                        if (count_root_element < 2) {

                            geoArray = return_tree(root_id);
                            for (let i = 0; i < geoArray.length; i++) {
                                for (let z = 0; z < geoArray[i].length; z++) {
                                    let newGeo = new Vue({render: h => h(GeoItem)});
                                    newGeo.$data.id = geoArray[i][z]['id'];
                                    newGeo.$data.parent_id = geoArray[i][z]['id'];
                                    newGeo.$data.geoOption_id = geoArray[i][z]['id_option'];

                                    geoArray[i][z] = newGeo;
                                }
                            }

                            return true;

                        } else {
                            this.mes = "More then one root elements, wrong data";
                            return (false);
                        }
                    }
                    catch (e) {
                        this.mes = "SERVER not working, try later";
                        return (false);
                    }
                });
                jqxhr.fail(function () {
                    this.mes = "SERVER not available, try later";
                    return (false);
                })
            },

            DDD_beforeUpdate() {
            }
        }

    }
</script>

<style scoped>

</style>