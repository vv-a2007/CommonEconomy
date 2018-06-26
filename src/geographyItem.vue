<template>
    <div class="geographyItem">

        <div v-if="mes!==''" class="row">
            <div  class="col-lg-12 ">
                <span>Message:  </span>
                <span v-bind:style="'color:red'">{{mes}}</span>
                <span>'    '</span>
                <button v-on:click="mes=''">ok</button>
            </div>
        </div>

        <div v-if="mes===''" class="row">
            <div class="col-lg-1 ">
                <span class="full_width" v-bind:style="'color:mediumblue'" >{{itemName}}</span>
            </div>
            <div class="col-lg-4 ">
                <select  v-model.lazy="selected" class="dropdown full_width" @:change="OnChangeBox" name="select_in_box">
                    <option disabled value="">Select from ....</option>
                    <option v-for="option in options" :value="option.value" v:key="option.value">
                        {{option.text}}
                    </option>
                </select>
            </div>
            <div class="col-lg-4 ">
                <input  v-model.trim.prevent="new_item"
                        placeholder="add new value and save"
                        type="text"
                        class="new_item full_width"
                        v-bind:text="new_item">

            </div>
            <div class="col-lg-1 ">
                <button  class="button_add, full_width" @:click="AddInBox" :style="'background-color:lime'" > New </button>
            </div>
            <div class="col-lg-1 ">
                <button  v-show="!edit_flag" class="button_edit_off full_width" @:click="EditOn" :style="'background-color:gold'" > Edit </button>
                <button  v-show="edit_flag" class="button_edit_on full_width" @:click="EditInBox" :style="'background-color:yellow'" > Save </button>
            </div>

            <div class="col-lg-1 ">
                <button class="button_del full_width" @:click="ClearFromBox" :style="'background-color:tomato'"> Delete </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "geographyItem",

        props:{setItemName:String, setStartUrl:String, setAddUrl:String, setEditUrl:String, setClearUrl:String},

        data: function () {
            return {
                mes:"",
                itemName:this.setItemName,
                options:[{
                    text:'',
                    id_item:0,
                    value:""
                }],
                selected:null,
                startUrl:this.setStartUrl,
                addUrl:this.setAddUrl,
                editUrl:this.setEditUrl,
                clearUrl:this.setClearUrl,
                id_current:0,
                input_field:false,
                new_item:"",
                child:[],
                parent:null,
                full_loaded:false,
                filter_id:0,
                edit_flag:false

            }
        },

        created () { this.OnStartBox() },

        methods : {

            OnStartBox : function () {

                const Init_list_box = function (start, link, filter_id) {

                    let jqxhr = $.get(start,{'filter_id':filter_id},"json");
                    jqxhr.done(function () {
                        try {
                            options = JSON.parse(jqxhr.responseText);
                            link.options = [{text: "", id_item: 0, value: ""}];
                            for (let i = 0; i < options.length; i++) {
                                link.options[i] = options[i];
                            }
                            link.selected = sessionStorage.getItem("select_" + link.itemName);

                            if (link.selected !== null) {

                                try {

                                    link.id_current = link.options.find(unit => unit.value === link.selected).id_item;
                                    count_trying_items = max_count_trying;
                                    link.full_loaded = true;
                                    link.mes = "";
                                }
                                catch (e) {
                                    link.id_current = 0;
                                    sessionStorage.setItem("select_" + link.itemName, "");
                                }

                                for (let i = 0; i < link.child.length; i++) {

                                    if (link.child[i] !== null) {
                                        link.child[i].filter_id = link.id_current;
                                        link.child[i].OnStartBox();
                                    }

                                }

                                return (true);
                            }
                        }
                        catch (e) {
                            link.mes = "Try connecting to SERVER ";
                            if (count_trying_items < max_count_trying) {
                                count_trying_items++;
                                link.full_loaded = false;
                                Init_list_box(start, link, filter_id);
                            } else {
                                link.mes = "SERVER not available, try later";
                                link.full_loaded = false;
                                return (false);
                            }
                        }
                    });
                    jqxhr.fail(function () {
                        link.mes = "Try connecting to SERVER ";
                        if (count_trying_items < max_count_trying) {
                            count_trying_items++;
                            link.full_loaded = false;
                            Init_list_box(start, link, filter_id);
                        } else {
                            link.mes = "SERVER not available, try later";
                            link.full_loaded = false;
                            return (false);
                        }
                    });
                };

                let count_trying_items = 0;
                let options = [];

                let link = this;

                if ( link.parent !== null && link.parent.full_loaded === false) { }

                else {

                    Init_list_box(link.startUrl, link, link.filter_id);

                    for (let i=0; i<link.child.length; i++) {
                        if ((link.child[i] !== null) && (count_trying_items = max_count_trying)) {
                            link.child[i].filter_id = link.id_current;
                            link.child[i].OnStartBox();
                        }
                    }
                }
            },

            OnChangeBox  : function () {

                if (this.selected !== null) {

                    sessionStorage.setItem("select_"+this.itemName,this.selected);
                    for (i=0; i<this.child.length; i++) {
                        if (this.child[i] !== null) {
                            sessionStorage.setItem("select_" + this.child[i].itemName, "");
                        }
                    }

                    try {

                        this.id_current = this.options.find(unit => unit.value === this.selected).id_item;

                    }
                    catch (e) {
                        this.selected = "";
                        this.id_current = 0;

                    }
                    for (let i=0; i<this.child.length; i++) {
                        if (this.child[i] !== null) {
                            this.child[i].filter_id = this.id_current;
                            Vue.nextTick(function () {
                            });
                            this.child[i].OnStartBox();
                        }
                    }
                }
            },

            AddInBox     : function () {
                const Add_item = function (item, link) {

                    let parent_id; if (link.parent != null) { parent_id = link.parent.id_current} else {parent_id=0}

                    let jqxhr = $.post(link.addUrl,{"item":item,"parent_id":parent_id}, "json");
                    jqxhr.done(function () {
                            try {
                                let responce = JSON.parse(jqxhr.responseText);
                                link.mes = responce.message;
                                sessionStorage.setItem("select_" + link.itemName, item);
                                link.options[link.options.length]={text:item, id_item:responce.result, value:item};
                                link.id_current = responce.result;
                                link.selected = item;

                                if (link.selected !== null) {

                                    try {
                                        link.id_current = link.options.find(unit => unit.value === link.selected).id_item;
                                    }
                                    catch (e) {
                                        link.selected = "";
                                        link.id_current = 0;
                                        sessionStorage.setItem("select_" + link.itemName, "");
                                    }

                                    for (let i = 0; i < link.child.length; i++) {
                                        if (link.child[i] !== null) {
                                            link.child[i].filter_id = link.id_current;
                                            link.child[i].OnStartBox();
                                        }
                                    }
                                    return (true);
                                }
                            }
                            catch (e) {
                                link.mes = "SERVER not available, try later";
                                return (false);
                            }
                        }
                    );
                    jqxhr.fail(function () {
                        link.mes = "SERVER not available, try later";
                        return (false);
                    })
                };

                let link = this;
                let parent_id;
                if (this.new_item !== "") {
                    if (link.parent != null) {
                        parent_id = link.parent.id_current;
                        if (parent_id !== 0) {Add_item(this.new_item,link)}
                    } else {parent_id=0; Add_item(this.new_item,link) }
                }


            },

            EditOn : function () {
                this.new_item = this.options.find(unit => unit.value === this.selected).text;
                this.edit_flag = true;
            },

            EditInBox     : function () {
                const Edit_item = function (item, link) {

                    let jqxhr = $.post(link.editUrl,{"item":item,"id":link.id_current}, "json");
                    jqxhr.done(function () {
                            try {
                                let responce = JSON.parse(jqxhr.responseText);
                                link.mes = responce.message;
                                sessionStorage.setItem("select_" + link.itemName, item);

                                link.selected = item;

                                if (link.selected !== null) {

                                    try {
                                        let current_item = link.options.find(unit => unit.id_item === link.id_current);
                                        current_item.value = item;
                                        current_item.text = item;
                                        link.selected = current_item.value;
                                    }
                                    catch (e) {
                                        link.selected = "";
                                        link.id_current = 0;
                                        sessionStorage.setItem("select_" + link.itemName, "");
                                    }

                                    for (let i = 0; i < link.child.length; i++) {
                                        if (link.child[i] !== null) {
                                            link.child[i].filter_id = link.id_current;
                                            link.child[i].OnStartBox();
                                        }
                                    }
                                    return (true);
                                }
                            }
                            catch (e) {
                                link.mes = "SERVER not available, try later";
                                return (false);
                            }
                        }
                    );
                    jqxhr.fail(function () {
                        link.mes = "SERVER not available, try later";
                        return (false);
                    })
                };

                let link = this;
                this.edit_flag = false;
                if (this.new_item !== "") {Edit_item(this.new_item,link)}
                this.new_item = "";


            },


            ClearFromBox : function () {
                const Del_item = function (item, link) {

                    let jqxhr = $.post(link.clearUrl,{"item":item}, "json");
                    jqxhr.done(function () {
                            try {
                                let responce = JSON.parse(jqxhr.responseText);
                                link.mes = responce.message;
                                sessionStorage.setItem("select_"+link.itemName,"");
                                return (true);
                            }
                            catch (e) {
                                link.mes = "SERVER not available, try later";
                                return (false);
                            }
                        }
                    );
                    jqxhr.fail(function () {
                        link.mes = "SERVER not available, try later";
                        return (false);
                    })
                };

                let link = this;

                if (this.selected !== 0) {
                    let item=this.selected;
                    Del_item(item,link)
                }



            }
        }
    }
</script>

<style>

</style>