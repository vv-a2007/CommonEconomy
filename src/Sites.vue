<template>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row newsite" id="newsite" >
                        <div class="col-lg-9">
                            <input v-model.trim.prevent="value"
                                   v-on:click.prevent="eraseMessage()"
                                   placeholder="add new seller site"
                                   type="text"
                                   class="input unpadding, full_width"
                                   name="site"
                            >
                        </div>

                        <div class="col-lg-3  ">
                            <button v-on:click.prevent="addSite(value)" type="submit" class="button unpadding, full_width "> add site</button>
                        </div>
                    </div>

                    <div class="row" id="message">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12"><pre> </pre></div>
                            </div>
                            <div class="row col-lg-12">
                                <span>Message:  </span>
                                <span v-bind:style="'color:red'"> {{mes}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button v-on:click="Page_Up()" class="button_page_up_sites full_width" id="Sites_Up">Up</button>
                        </div>

                        <div class="col-lg-12">
                            <table class="table table-responsive table-bordered full_width" id="site_table" >

                                <thead class="thead thead-dark full_width ">
                                <tr class="tr full_width">
                                    <th class="th col-lg-1">ID</th>
                                    <th class="th col-lg-6">Site name</th>
                                    <th class="th col-lg-4">Status</th>
                                    <th class="th col-lg-1" >Action</th>
                                </tr>
                                </thead>
                                <tbody class="table-hover full_width " id="site_body" >
                                </tbody>
                            </table>
                        </div>

                        <div class="col-lg-12">
                            <button v-on:click="Page_Down()" class="button_page_down_sites full_width" id="Sites_Down">Down</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="row"></div>
                </div>
                <div class="col-lg-7" >
                    <div id="current_site">
                        <div class="row">
                            <span> Site parameters :  </span>
                        </div>
                        <div class="row">
                            <template v-if="!edit_name" >
                                <span class="col-lg-2"> Site name :  </span>
                                <span class="col-lg-8" :style="colorName" >{{name}}</span>
                                <button class="col-lg-2" @click.prevent="Edit_name">Edit</button>
                            </template>
                            <template v-else >
                                <span class="col-lg-2"> Site name :  </span>
                                <input class="col-lg-8" type="text" v-model.trim.prevent="name" :text="name">
                                <button class="col-lg-1"  @click.prevent="Save_name">Save</button>
                                <button class="col-lg-1" @click.prevent="edit_name=false">Exit</button>
                            </template>
                        </div>
                        <div class="row">
                            <template v-if="!edit_cart" >
                                <span class="col-lg-2"> Cart path :  </span>
                                <span class="col-lg-8"  >{{cart_path}}</span>
                                <button class="col-lg-2" @click.prevent="Edit_cart">Edit</button>
                            </template>
                            <template v-else >
                                <span class="col-lg-2"> Cart path :  </span>
                                <input class="col-lg-8" type="text" v-model.trim.prevent="cart_path" :text="cart_path">
                                <button class="col-lg-1"  @click.prevent="Save_cart">Save</button>
                                <button class="col-lg-1" @click.prevent="edit_cart=false">Exit</button>
                            </template>
                        </div>
                        <div class="row">
                            <span class="col-lg-2" > Border options :  </span>
                            <span class="col-lg-8" v-show="!edit_border">{{border}}</span>
                            <button class="col-lg-2" v-show="!edit_border" v-on:click.prevent="Edit_border">Edit</button>
                            <textarea class="col-lg-8" v-show="edit_border" type="text" v-model.trim.prevent="border" v-bind:text="border"></textarea>
                            <button class="col-lg-1" v-show="edit_border" v-on:click.prevent="Save_border">Save</button>
                            <button class="col-lg-1" v-show="edit_border" v-on:click.prevent="edit_border=false">Exit</button>
                        </div>
                        <div class="row">
                            <span class="col-lg-2"> Item options :  </span>
                            <span class="col-lg-8" v-show="!edit_position" >{{position}}</span>
                            <button class="col-lg-2" v-show="!edit_position" v-on:click.prevent="Edit_position">Edit</button>
                            <textarea class="col-lg-8" v-show="edit_position" type="text" v-model.trim.prevent="position" v-bind:text="position"></textarea>
                            <button class="col-lg-1" v-show="edit_position" v-on:click.prevent="Save_position">Save</button>
                            <button class="col-lg-1" v-show="edit_position" v-on:click.prevent="edit_position=false">Exit</button>
                        </div>
                        <div class="row">
                            <span class="col-lg-2" > Item structure :  </span>
                            <span class="col-lg-8" v-show="!edit_structure" >{{structure}}</span>
                            <button class="col-lg-2" v-show="!edit_structure" v-on:click.prevent="Edit_structure">Edit</button>
                            <textarea class="col-lg-8" v-show="edit_structure" type="text" v-model.trim.prevent="structure" v-bind:text="structure"></textarea>
                            <button class="col-lg-1" v-show="edit_structure" v-on:click.prevent="Save_structure">Save</button>
                            <button class="col-lg-1" v-show="edit_structure" v-on:click.prevent="edit_structure=false">Exit</button>
                        </div>
                        <div class="row">
                            <span class="col-lg-2"> Status :  </span>
                            <span v-show="!edit_status" class="col-lg-8">{{status_name}}</span>
                            <button class="col-lg-2" v-show="!edit_status" v-on:click.prevent="Edit_status">Edit</button>

                            <select class="col-lg-8dropdown " v-show="edit_status" v-model.lazy="selected_status" v-on:change.prevent="">
                                <option disabled value=0>Select from ....</option>
                                <option  v-for="status in status_list" v-bind:value="status.value" v:key="status.value">
                                    {{status.text}}
                                </option>
                            </select>
                            <button class="col-lg-1" v-show="edit_status" v-on:click.prevent="Save_status">Save</button>
                            <button class="col-lg-1" v-show="edit_status" v-on:click.prevent="edit_status=false">Exit</button>
                        </div>
                    </div>
                    <form>
                        <div class="row">
                            <span class="col-lg-12"> Root location :  </span>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row" id="country" >
                                    <span class="col-lg-2" >   Country : </span>
                                    <span  v-show="!edit_country" class="col-lg-8">{{current_country}}</span>
                                    <select v-show="edit_country" class="col-lg-8 dropdown" v-model.lazy="selected" v-on:change="OnChangeCountry">
                                        <option v-for="option in options"
                                                v-bind:value="option.value">
                                            {{option.text}}
                                        </option>
                                    </select>
                                </div>
                                <div class="row" id="region" >
                                    <span class="col-lg-2" >   Region : </span>
                                    <span  v-show="!edit_region" class="col-lg-8">{{current_region}}</span>
                                    <select v-show="edit_region" class="col-lg-8 dropdown" v-model.lazy="selected"  v-on:change="OnChangeRegion">
                                        <option v-for="option in options"
                                                v-bind:value="option.value">
                                            {{option.text}}
                                        </option>
                                    </select>
                                </div>
                                <div class="row"  id="city">
                                    <span class="col-lg-2">   City : </span>
                                    <span  v-show="!edit_city" class="col-lg-8">{{current_city}}</span>
                                    <select v-show="edit_city" class="col-lg-8 dropdown" v-model.lazy="selected" v-on:change="OnChangeCity">
                                        <option v-for="option in options"
                                                v-bind:value="option.value">
                                            {{option.text}}
                                        </option>
                                    </select>
                                </div>
                                <div class="row"  id="area">
                                    <span class="col-lg-2">   Area : </span>
                                    <span  v-show="!edit_area" class="col-lg-8">{{current_area}}</span>
                                    <select  v-show="edit_area" class="col-lg-8 dropdown" v-model.lazy="selected" v-on:change="OnChangeArea">
                                        <option v-for="option in options"
                                                v-bind:value="option.value">
                                            {{option.text}}
                                        </option>
                                    </select>
                                </div>
                                <div class="row"  id="postcode">
                                    <span class="col-lg-2">   Postcode : </span>
                                    <span  v-show="!edit_postcode" class="col-lg-8">{{current_postcode}}</span>
                                    <select v-show="edit_postcode"  class="col-lg-8 dropdown" v-model.lazy="selected" v-on:change="OnChangePostcode">
                                        <option v-for="option in options"
                                                v-bind:value="option.value">
                                            {{option.text}}
                                        </option>
                                    </select>
                                </div>
                                <div id="address" class="row">
                                    <template v-if="!edit_address" >
                                        <span class="col-lg-2"> Address :  </span>
                                        <span class="col-lg-8"  >{{address_field}}</span>
                                        <button class="col-lg-2" @click.prevent="Edit_location">Edit</button>
                                    </template>
                                    <template v-else >
                                        <span class="col-lg-2"> Address :  </span>
                                        <input class="col-lg-8" type="text" placeholder="write address here " v-model.trim.prevent="address_field" :text="address_field">
                                        <button class="col-lg-1"  @click.prevent="Save_location">Save</button>
                                        <button class="col-lg-1" @click.prevent="Exit_location">Exit</button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</template>

<script>
 export default {

     name: "Sites",

     data () {




     },

     created() {
         let all_regions = [];
         let all_cities = [];
         let all_areas = [];
         let all_postcodes = [];
         let all_status = [];

         let table_data_sites = {"start_position": 0, "row_number": 10, "last_row": -1};
         let table_sites = [];
         let flag_sites = true;

         let message;
         message = new Vue({
             el: '#message',
             data: {
                 mes: ''
             }
         });

         let newsite;
         newsite = new Vue({
             el: '#newsite',
             data: {
                 value: ""
             },
             methods: {
                 addSite: function (value) {
                     let jqxhr = $.post('Add_site.php', {'site': value}, "json");
                     jqxhr.done(function () {
                         let textmes = JSON.parse(jqxhr.responseText);
                         message.mes = textmes.message;
                         newsite.value = "";
                         flag_sites = true;
                         Get_site_list();
                     })
                 },
                 eraseMessage: function () {
                     message.mes = "";
                 }
             }
         });

         let current_site;
         current_site = new Vue({
             el: '#current_site',
             data: {
                 ID: 0,
                 name: 'drop and put here site for editing',
                 cart_path: "",
                 border: null,
                 position: null,
                 structure: null,
                 status_ID: 0,
                 status_name: "",
                 location_ID: 0,
                 edit_name: false,
                 edit_cart: false,
                 edit_border: false,
                 edit_position: false,
                 edit_structure: false,
                 edit_status: false,
                 status_list: [{text: "", id_status: 0, value: 0}],
                 selected_status: 0
             },
             computed: {
                 colorName: function () {
                     if (this.ID === 0) {
                         return {'color': 'red'}
                     } else {
                         return {'color': 'black'}
                     }
                 }
             },
             methods: {

                 Save_for_all: function () {
                     this.edit_name = false;
                     this.edit_cart = false;
                     this.edit_border = false;
                     this.edit_position = false;
                     this.edit_structure = false;
                     this.edit_status = false;
                     address.edit_address = false
                 },

                 Edit_name: function () {
                     current_site.edit_name = true
                 },
                 Save_name: function () {
                     this.Save_site();
                     current_site.edit_name = false
                 },
                 Edit_cart: function () {
                     current_site.edit_cart = true
                 },
                 Save_cart: function () {
                     this.Save_site();
                     current_site.edit_cart = false
                 },
                 Edit_border: function () {
                     current_site.edit_border = true
                 },
                 Save_border: function () {
                     this.Save_site();
                     current_site.edit_border = false
                 },
                 Edit_position: function () {
                     current_site.edit_position = true
                 },
                 Save_position: function () {
                     this.Save_site();
                     current_site.edit_position = false
                 },
                 Edit_structure: function () {
                     current_site.edit_structure = true
                 },
                 Save_structure: function () {
                     this.Save_site();
                     current_site.edit_structure = false
                 },
                 Edit_status: function () {
                     current_site.edit_status = true
                 },

                 Save_status: function () {
                     current_site.status_ID = current_site.status_list[current_site.selected_status].id_status;
                     current_site.status_name = current_site.status_list[current_site.selected_status].text;
                     this.Save_site();
                     current_site.edit_status = false
                 },


                 Save_site: function () {
                     let site_info = {
                         id: current_site.ID,
                         name: current_site.name,
                         cart_path: current_site.cart_path,
                         border: current_site.border,
                         position: current_site.position,
                         structure: current_site.structure,
                         id_status: current_site.status_ID,
                         id_location: current_site.location_ID,
                         id_country: current_location.country_ID,
                         id_region: current_location.region_ID,
                         id_city: current_location.city_ID,
                         id_area: current_location.area_ID,
                         id_postcode: current_location.postcode_ID,
                         address: current_location.address
                     };

                     current_site.Save_for_all();

                     let jqxhr = $.post('Save_current_site.php', site_info, "json");
                     jqxhr.done(function () {
                             try {
                                 let responce = JSON.parse(jqxhr.responseText);
                                 message.mes = responce.message;
                                 flag_sites = true;
                                 setTimeout(Get_site_list(), 700);

                                 return (true)
                             }
                             catch (e) {
                                 message.mes = "SERVER not working, try later";
                                 return (false)
                             }
                         }
                     );
                     jqxhr.fail(function () {
                         message.mes = "SERVER not available, try later";
                         return (false);
                     })
                 }
             }
         });

         let current_location = {
             ID: 0,
             country_ID: 0,
             region_ID: 0,
             city_ID: 0,
             area_ID: 0,
             postcode_ID: 0,
             address: ""
         };

         let country;
         country = new Vue({
             el: '#country',
             data: {
                 selected: 0,
                 options: [{
                     text: '',
                     id_country: 0,
                     value: 0
                 }],
                 edit_country: false
             },

             computed: {
                 current_country: function () {
                     return this.options[this.selected].text
                 }
             },

             methods: {
                 OnChangeCountry: function () {

                     current_location.country_ID = this.options.find(unit => unit.value === this.selected).id_country;

                     region.selected = 0;
                     region.options.length = 0;
                     region.options = [{
                         text: '',
                         id_region: 0,
                         id_country: 0,
                         value: 0
                     }];

                     city.selected = 0;
                     city.options.length = 0;
                     city.options = [{
                         text: '',
                         id_city: 0,
                         id_country: 0,
                         id_region: 0,
                         value: 0
                     }];

                     area.selected = 0;
                     area.options.length = 0;
                     area.options = [{
                         text: '',
                         id_area: 0,
                         id_city: 0,
                         id_country: 0,
                         id_region: 0,
                         value: 0
                     }];

                     postcode.selected = 0;
                     postcode.options.length = 0;
                     postcode.options = [{
                         text: '',
                         id_postcode: 0,
                         id_city: 0,
                         id_country: 0,
                         id_region: 0,
                         value: 0
                     }];

                     if (country.selected !== 0) {

                         let value = 1;

                         all_regions.forEach(function (oneregion) {
                             if ((oneregion.id_country === country.options[country.selected].id_country) || (country.options[country.selected].id_country === 0)) {
                                 let changeregion = {};
                                 for (let key in oneregion) {
                                     changeregion[key] = oneregion[key]
                                 }
                                 changeregion.value = value;
                                 value++;
                                 region.options.push(changeregion);
                             }
                         });

                         value = 1;
                         all_cities.forEach(function (onecity) {
                             if ((onecity.id_country === country.options[country.selected].id_country) || (country.options[country.selected].id_country === 0)) {
                                 let changecity = {};
                                 for (let key in onecity) {
                                     changecity[key] = onecity[key]
                                 }
                                 changecity.value = value;
                                 value++;
                                 city.options.push(changecity);
                             }
                         });

                         value = 1;
                         all_areas.forEach(function (onearea) {
                             if ((onearea.id_country === country.options[country.selected].id_country) || (country.options[country.selected].id_country === 0)) {
                                 let changearea = {};
                                 for (let key in onearea) {
                                     changearea[key] = onearea[key]
                                 }
                                 changearea.value = value;
                                 value++;
                                 area.options.push(changearea);
                             }
                         });

                         value = 1;
                         all_postcodes.forEach(function (onepostcode) {
                             if ((onepostcode.id_country === country.options[country.selected].id_country) || (country.options[country.selected].id_country === 0)) {
                                 let changepostcode = {};
                                 for (let key in onepostcode) {
                                     changepostcode[key] = onepostcode[key]
                                 }
                                 changepostcode.value = value;
                                 value++;
                                 postcode.options.push(changepostcode);
                             }
                         });
                     }
                     else {
                         region.options = all_regions.slice(0, all_regions.length);
                         city.options = all_cities.slice(0, all_cities.length);
                         area.options = all_areas.slice(0, all_areas.length);
                         postcode.options = all_postcodes.slice(0, all_postcodes.length);
                     }
                     Vue.nextTick(function () {
                     });
                 }
             }
         });

         let region;
         region = new Vue({
             el: '#region',
             data: {
                 selected: 0,
                 options: [{
                     text: '',
                     id_region: 0,
                     id_country: 0,
                     value: 0
                 }],
                 edit_region: false
             },
             computed: {
                 current_region: function () {
                     return this.options[this.selected].text
                 }
             },
             methods: {
                 OnChangeRegion: function () {

                     current_location.region_ID = this.options.find(unit => unit.value === this.selected).id_region;

                     city.options.length = 0;
                     city.selected = 0;
                     city.options = [{
                         text: '',
                         id_city: 0,
                         id_country: 0,
                         id_region: 0,
                         value: 0
                     }];

                     area.selected = 0;
                     area.options.length = 0;
                     area.options = [{
                         text: '',
                         id_area: 0,
                         id_city: 0,
                         id_country: 0,
                         id_region: 0,
                         value: 0
                     }];

                     postcode.selected = 0;
                     postcode.options.length = 0;
                     postcode.options = [{
                         text: '',
                         id_postcode: 0,
                         id_city: 0,
                         id_country: 0,
                         id_region: 0,
                         value: 0
                     }];

                     Vue.nextTick(function () {
                     });


                     if (region.selected !== 0) {

                         Set_selecter_in_value(country, 'id_country', region.options[region.selected].id_country);

                         let value = 1;

                         all_cities.forEach(function (onecity) {

                             let check1 = true;
                             let check2 = true;
                             if (country.options[country.selected].id_country !== 0) {
                                 check1 = (onecity.id_country === country.options[country.selected].id_country);
                             }
                             if (region.options[region.selected].id_region !== 0) {
                                 check2 = (onecity.id_region === region.options[region.selected].id_region);
                             }

                             if (check1 && check2) {

                                 let changecity = {};
                                 for (let key in onecity) {
                                     changecity[key] = onecity[key]
                                 }
                                 changecity.value = value;
                                 value++;
                                 city.options.push(changecity);
                             }
                         });

                         value = 1;

                         all_areas.forEach(function (onearea) {
                             let check1 = true;
                             let check2 = true;
                             let check3 = true;
                             if (country.options[country.selected].id_country !== 0) {
                                 check1 = (onearea.id_country === country.options[country.selected].id_country);
                             }
                             if (region.options[region.selected].id_region !== 0) {
                                 check2 = (onearea.id_region === region.options[region.selected].id_region);
                             }
                             if (city.options[city.selected].id_city !== 0) {
                                 check3 = (onearea.id_city === city.options[city.selected].id_city);
                             }


                             if (check1 && check2 && check3) {

                                 let changearea = {};
                                 for (let key in onearea) {
                                     changearea[key] = onearea[key]
                                 }
                                 changearea.value = value;
                                 value++;
                                 area.options.push(changearea);
                             }
                         });

                         value = 1;

                         all_postcodes.forEach(function (onepostcode) {

                             let check1 = true;
                             let check2 = true;
                             if (country.options[country.selected].id_country !== 0) {
                                 check1 = (onepostcode.id_country === country.options[country.selected].id_country);
                             }
                             if (region.options[region.selected].id_region !== 0) {
                                 check2 = (onepostcode.id_region === region.options[region.selected].id_region);
                             }

                             if (check1 && check2) {

                                 let changepostcode = {};
                                 for (let key in onepostcode) {
                                     changepostcode[key] = onepostcode[key]
                                 }
                                 changepostcode.value = value;
                                 value++;
                                 postcode.options.push(changepostcode);
                             }
                         });


                         Vue.nextTick(function () {
                         });
                     }
                 }
             }
         });

         let city;
         city = new Vue({
             el: '#city',
             data: {
                 selected: 0,
                 options: [{
                     text: '',
                     id_city: 0,
                     id_country: 0,
                     id_region: 0,
                     value: 0
                 }],
                 edit_city: false
             },
             computed: {
                 current_city: function () {
                     return this.options[this.selected].text
                 }
             },
             methods: {
                 OnChangeCity: function () {

                     current_location.city_ID = this.options.find(unit => unit.value === this.selected).id_city;

                     area.selected = 0;
                     area.options.length = 0;
                     area.options = [{
                         text: '',
                         id_area: 0,
                         id_city: 0,
                         id_country: 0,
                         id_region: 0,
                         value: 0
                     }];


                     Vue.nextTick(function () {
                     });

                     let value = 1;

                     all_areas.forEach(function (onearea) {
                         let check1 = true;
                         let check2 = true;
                         let check3 = true;
                         if (country.options[country.selected].id_country !== 0) {
                             check1 = (onearea.id_country === country.options[country.selected].id_country);
                         }
                         if (region.options[region.selected].id_region !== 0) {
                             check2 = (onearea.id_region === region.options[region.selected].id_region);
                         }
                         if (city.options[city.selected].id_city !== 0) {
                             check3 = (onearea.id_city === city.options[city.selected].id_city);
                         }


                         if (check1 && check2 && check3) {

                             let changearea = {};
                             for (let key in onearea) {
                                 changearea[key] = onearea[key]
                             }
                             changearea.value = value;
                             value++;
                             area.options.push(changearea);
                         }
                     });

                     Vue.nextTick(function () {
                     });
                 }
             }
         });

         let area;
         area = new Vue({
             el: '#area',
             data: {
                 selected: 0,
                 options: [{
                     text: '',
                     id_area: 0,
                     id_city: 0,
                     id_country: 0,
                     id_region: 0,
                     value: 0
                 }],
                 edit_area: false
             },
             computed: {
                 current_area: function () {
                     return this.options[this.selected].text
                 }
             },
             methods: {
                 OnChangeArea: function () {

                     current_location.area_ID = this.options.find(unit => unit.value === this.selected).id_area;


                     if (area.selected !== 0) {
                         Set_selecter_in_value(country, 'id_country', area.options[area.selected].id_country);
                         Set_selecter_in_value(region, 'id_region', area.options[area.selected].id_region);
                         Set_selecter_in_value(city, 'id_city', area.options[area.selected].id_city);
                     }

                     Vue.nextTick(function () {
                     });
                 }
             }
         });

         let postcode;
         postcode = new Vue({
             el: '#postcode',
             data: {
                 selected: 0,
                 options: [{
                     text: '',
                     id_postcode: 0,
                     id_country: 0,
                     id_region: 0,
                     value: 0
                 }],
                 edit_postcode: false
             },
             computed: {
                 current_postcode: function () {
                     return this.options[this.selected].text
                 }
             },
             methods: {
                 OnChangePostcode: function () {

                     current_location.postcode_ID = this.options.find(unit => unit.value === this.selected).id_postcode;


                     if (postcode.selected !== 0) {
                         Set_selecter_in_value(country, 'id_country', postcode.options[postcode.selected].id_country);
                         Set_selecter_in_value(region, 'id_region', postcode.options[postcode.selected].id_region);
                     }

                     Vue.nextTick(function () {
                     });
                 }
             }
         });

         let address;
         address = new Vue({
             el: '#address',
             data: {
                 address_field: "",
                 edit_address: false
             },
             methods: {
                 OnChangeAddress: function () {

                     current_location.address = this.address_field;

                     Vue.nextTick(function () {
                     });
                 },
                 Edit_location: function () {
                     address.edit_address = true;
                     postcode.edit_postcode = true;
                     area.edit_area = true;
                     city.edit_city = true;
                     region.edit_region = true;
                     country.edit_country = true;
                 },
                 Save_location: function () {
                     address.edit_address = false;
                     postcode.edit_postcode = false;
                     area.edit_area = false;
                     city.edit_city = false;
                     region.edit_region = false;
                     country.edit_country = false;
                     address.OnChangeAddress();
                     current_site.Save_site();
                 },
                 Exit_location: function () {
                     address.edit_address = false;
                     postcode.edit_postcode = false;
                     area.edit_area = false;
                     city.edit_city = false;
                     region.edit_region = false;
                     country.edit_country = false;
                 }
             }
         });

         const Set_selecter_in_value = function (item, field, value) {

             let field_value;
             item.selected = 0;

             for (i = 0; i < item.options.length; i++) {
                 eval('field_value = item.options[' + i + '].' + field);
                 if (field_value === value) {
                     item.selected = i;
                     i = item.options.length
                 }
             }

         };

         const Refresh_location = function () {

             Vue.nextTick(function () {
             });

             Set_selecter_in_value(country, 'id_country', current_location.country_ID);
             country.OnChangeCountry();
             Set_selecter_in_value(region, 'id_region', current_location.region_ID);
             region.OnChangeRegion();
             Set_selecter_in_value(city, 'id_city', current_location.city_ID);
             city.OnChangeCity();
             Set_selecter_in_value(area, 'id_area', current_location.area_ID);
             area.OnChangeArea();
             Set_selecter_in_value(postcode, 'id_postcode', current_location.postcode_ID);
             postcode.OnChangePostcode();

             address.address_field = current_location.address;
             address.OnChangeAddress();

             Vue.nextTick(function () {
             });

         };

         let max_count_trying = 5;
         let flag_server = false;

         const Init_selects = function () {

             let count_trying_countries = 0;
             let count_trying_regions = 0;
             let count_trying_cities = 0;
             let count_trying_areas = 0;
             let count_trying_postcodes = 0;
             let count_trying_statuses = 0;

             const Init_list_countries = function () {

                 let jqxhr = $.get('Get_list_all_countries.php', "json");
                 jqxhr.done(function () {
                     try {
                         country.options = JSON.parse(jqxhr.responseText);
                         flag_server = true;
                         count_trying_countries = max_count_trying;
                         message.mes = "";
                         Vue.nextTick(function () {
                         });
                     }
                     catch (e) {
                         message.mes = "Try connecting to SERVER ";
                         Vue.nextTick(function () {
                         });
                         if (count_trying_countries < max_count_trying) {
                             flag_server = false;
                             count_trying_countries++;
                             Init_list_countries();
                         } else {
                             message.mes = "SERVER not available, try later";
                             Vue.nextTick(function () {
                             });
                             flag_server = false;
                             return (false);
                         }
                     }
                 });
                 jqxhr.fail(function () {
                     message.mes = "Try connecting to SERVER ";
                     Vue.nextTick(function () {
                     });
                     if (count_trying_countries < max_count_trying) {
                         flag_server = false;
                         count_trying_countries++;
                         Init_list_countries();
                     } else {
                         message.mes = "SERVER not available, try later";
                         Vue.nextTick(function () {
                         });
                         flag_server = false;
                         return (false);
                     }
                 });

             };

             const Init_list_regions = function () {

                 let jqxhr1 = $.get('Get_list_all_regions.php', "json");
                 jqxhr1.done(function () {
                     try {
                         all_regions = JSON.parse(jqxhr1.responseText);
                         region.options = all_regions.slice(0, all_regions.length);
                         flag_server = true;
                         count_trying_regions = max_count_trying;
                         message.mes = "";
                         Vue.nextTick(function () {
                         });
                     }
                     catch (e) {
                         message.mes = "Try connecting to SERVER ";
                         Vue.nextTick(function () {
                         });
                         if (count_trying_regions < max_count_trying) {
                             flag_server = false;
                             count_trying_regions++;
                             Init_list_regions();
                         } else {
                             message.mes = "SERVER not available, try later";
                             Vue.nextTick(function () {
                             });
                             flag_server = false;
                             return (false);
                         }
                     }
                 });
                 jqxhr1.fail(function () {
                     message.mes = "Try connecting to SERVER ";
                     Vue.nextTick(function () {
                     });
                     if (count_trying_regions < max_count_trying) {
                         flag_server = false;
                         count_trying_regions++;
                         Init_list_regions();
                     } else {
                         message.mes = "SERVER not available, try later";
                         Vue.nextTick(function () {
                         });
                         flag_server = false;
                         return (false);
                     }
                 });
             };

             const Init_list_cities = function () {

                 let jqxhr2 = $.get('Get_list_all_cities.php', "json");
                 jqxhr2.done(function () {
                     try {
                         all_cities = JSON.parse(jqxhr2.responseText);
                         city.options = all_cities.slice(0, all_cities.length);
                         flag_server = true;
                     }
                     catch (e) {
                         message.mes = "Try connecting to SERVER ";
                         Vue.nextTick(function () {
                         });
                         if (count_trying_cities < max_count_trying) {
                             flag_server = false;
                             count_trying_cities++;
                             Init_list_cities();
                         } else {
                             message.mes = "SERVER not available, try later";
                             Vue.nextTick(function () {
                             });
                             flag_server = false;
                             return (false);
                         }
                     }
                 });
                 jqxhr2.fail(function () {
                     message.mes = "Try connecting to SERVER ";
                     Vue.nextTick(function () {
                     });
                     if (count_trying_cities < max_count_trying) {
                         flag_server = false;
                         count_trying_cities++;
                         Init_list_cities();
                     } else {
                         message.mes = "SERVER not available, try later";
                         Vue.nextTick(function () {
                         });
                         flag_server = false;
                         return (false);
                     }
                 });
             };

             const Init_list_areas = function () {

                 let jqxhr3 = $.get('Get_list_all_areas.php', "json");
                 jqxhr3.done(function () {
                     try {
                         all_areas = JSON.parse(jqxhr3.responseText);
                         area.options = all_areas.slice(0, all_areas.length);
                         flag_server = true;
                     }
                     catch (e) {
                         message.mes = "Try connecting to SERVER ";
                         Vue.nextTick(function () {
                         });
                         if (count_trying_areas < max_count_trying) {
                             flag_server = false;
                             count_trying_areas++;
                             Init_list_areas();
                         } else {
                             message.mes = "SERVER not available, try later";
                             Vue.nextTick(function () {
                             });
                             flag_server = false;
                             return (false);
                         }
                     }
                 });
                 jqxhr3.fail(function () {
                     message.mes = "Try connecting to SERVER ";
                     Vue.nextTick(function () {
                     });
                     if (count_trying_areas < max_count_trying) {
                         flag_server = false;
                         count_trying_areas++;
                         Init_list_areas();
                     } else {
                         message.mes = "SERVER not available, try later";
                         Vue.nextTick(function () {
                         });
                         flag_server = false;
                         return (false);
                     }
                 });
             };

             const Init_list_postcodes = function () {

                 let jqxhr4 = $.get('Get_list_all_postcodes.php', "json");
                 jqxhr4.done(function () {
                     try {
                         all_postcodes = JSON.parse(jqxhr4.responseText);
                         postcode.options = all_postcodes.slice(0, all_postcodes.length);
                         flag_server = true;
                     }
                     catch (e) {
                         message.mes = "Try connecting to SERVER ";
                         Vue.nextTick(function () {
                         });
                         if (count_trying_postcodes < max_count_trying) {
                             flag_server = false;
                             count_trying_postcodes++;
                             Init_list_postcodes();
                         } else {
                             message.mes = "SERVER not available, try later";
                             Vue.nextTick(function () {
                             });
                             flag_server = false;
                             return (false);
                         }
                     }
                 });
                 jqxhr4.fail(function () {
                     message.mes = "Try connecting to SERVER ";
                     Vue.nextTick(function () {
                     });
                     if (count_trying_postcodes < max_count_trying) {
                         flag_server = false;
                         count_trying_postcodes++;
                         Init_list_postcodes();
                     } else {
                         message.mes = "SERVER not available, try later";
                         Vue.nextTick(function () {
                         });
                         flag_server = false;
                         return (false);
                     }
                 });
             };

             const Init_list_statuses = function () {
                 let jqxhr4 = $.get('Get_list_all_statuses.php', "json");
                 jqxhr4.done(function () {
                     try {
                         all_statuses = JSON.parse(jqxhr4.responseText);
                         flag_server = true;
                     }
                     catch (e) {
                         message.mes = "Try connecting to SERVER ";
                         Vue.nextTick(function () {
                         });
                         if (count_trying_statuses < max_count_trying) {
                             flag_server = false;
                             count_trying_statuses++;
                             Init_list_statuses();
                         } else {
                             message.mes = "SERVER not available, try later";
                             Vue.nextTick(function () {
                             });
                             flag_server = false;
                             return (false);
                         }
                     }
                 });
                 jqxhr4.fail(function () {
                     message.mes = "Try connecting to SERVER ";
                     Vue.nextTick(function () {
                     });
                     if (count_trying_statuses < max_count_trying) {
                         flag_server = false;
                         count_trying_statuses++;
                         Init_list_statuses();
                     } else {
                         message.mes = "SERVER not available, try later";
                         Vue.nextTick(function () {
                         });
                         flag_server = false;
                         return (false);
                     }
                 });
             };

             Init_list_countries();
             Init_list_regions();
             Init_list_cities();
             Init_list_areas();
             Init_list_postcodes();
             Init_list_statuses();

         };

         const startDropSite = function () {
             return '<div>' + this.innerText + '</div>'
         };

         const finishDropSite = function (event, ui) {

             current_site.ID = ui.draggable.attr('id');
             message.mes = "";
             if (current_site.ID !== 0) {
                 count_trying_current_site = 0;
                 Get_current_site()
             }

         };

         const InitSiteDropable = function () {
             $("#current_site").droppable({
                 drop: finishDropSite
             })
         };

         const Get_current_site = function () {

             let count_trying_current_site = 0;

             const Init_get_current_site = function () {

                 const jqxhr = $.get('Get_site.php', {'id': current_site.ID}, 'json');
                 jqxhr.done(function (data) {
                     try {
                         let answer = JSON.parse(data);
                         current_site.name = answer["site_name"];
                         current_site.cart_path = answer["cart_path"];
                         current_site.border = answer["border_item_search"];
                         current_site.position = answer["position_item_search"];
                         current_site.structure = answer["item_structure"];
                         current_site.status_ID = answer["id_site_status"];
                         current_site.location_ID = answer["id_root_location"];
                         current_site.status_list = all_statuses.slice(0, all_statuses.length);
                         try {
                             current_site.selected_status = all_statuses.find(unit => unit.id_status === current_site.status_ID).value;
                             current_site.status_name = answer['status']
                         }
                         catch (e) {
                             current_site.status_name = "";
                             current_site.selected_status = 0;
                         }

                         if (current_site.location_ID !== null) {
                             const jqxhr1 = $.get('Get_location.php', {'id': current_site.location_ID}, 'json');

                             jqxhr1.done(function (data) {
                                 let answer1 = JSON.parse(data);
                                 current_location.ID = answer1['id'];
                                 if (current_location.ID === null) {
                                     current_location.ID = 0;
                                     current_site.location_ID = 0
                                 }

                                 current_location.country_ID = answer1['id_country'];
                                 if (current_location.country_ID === null) {
                                     current_location.country_ID = 0
                                 }


                                 current_location.region_ID = answer1['id_region'];
                                 if (current_location.region_ID === null) {
                                     current_location.region_ID = 0
                                 }


                                 current_location.city_ID = answer1['id_city'];
                                 if (current_location.city_ID === null) {
                                     current_location.city_ID = 0
                                 }


                                 current_location.area_ID = answer1['id_area'];
                                 if (current_location.area_ID === null) {
                                     current_location.area_ID = 0
                                 }


                                 current_location.postcode_ID = answer1['id_postcode'];
                                 if (current_location.postcode_ID === null) {
                                     current_location.postcode_ID = 0
                                 }

                                 current_location.address = answer1['address'];
                                 if (current_location.address === null) {
                                     current_location.address = ""
                                 }


                                 Refresh_location();
                             })
                         } else {
                             current_location = {
                                 ID: 0,
                                 country_ID: 0,
                                 region_ID: 0,
                                 city_ID: 0,
                                 area_ID: 0,
                                 postcode_ID: 0,
                                 address: ""
                             };
                             Refresh_location();
                         }

                     }
                     catch (e) {
                         message.mes = "Try connecting to SERVER ";
                         Vue.nextTick(function () {
                         });
                         if (count_trying_current_site < max_count_trying) {
                             count_trying_current_site++;
                             Init_get_current_site();
                         }
                         else {
                             message.mes = "SERVER not available, try later";
                             Vue.nextTick(function () {
                             });
                             return (false);
                         }
                     }
                 });
                 jqxhr.fail(function () {
                     message.mes = "Try connecting to SERVER ";
                     Vue.nextTick(function () {
                     });
                     if (count_trying_current_site < max_count_trying) {
                         count_trying_current_site++;
                         Init_get_current_site();
                     } else {
                         message.mes = "SERVER not available, try later";
                         Vue.nextTick(function () {
                         });
                         return (false);
                     }
                 })
             };
             Init_get_current_site();
         };

         let Sites_Up;
         Sites_Up = new Vue({
             el: '#Sites_Up',
             methods: {
                 Page_Up: function () {
                     if (table_data_sites.start_position > table_data_sites.row_number) {
                         table_data_sites.start_position = table_data_sites.start_position - table_data_sites.row_number - 1
                     }
                     else {
                         table_data_sites.start_position = 0;
                     }
                     Get_site_list();
                 }
             }
         });

         let Sites_Down;
         Sites_Down = new Vue({
             el: '#Sites_Down',
             methods: {
                 Page_Down: function () {
                     if ((table_data_sites.start_position + table_data_sites.row_number) < (table_data_sites.last_row - table_data_sites.row_number)) {
                         table_data_sites.start_position = table_data_sites.start_position + table_data_sites.row_number
                     }
                     else {
                         table_data_sites.start_position = (table_data_sites.last_row - table_data_sites.row_number + 1);
                         if (table_data_sites.start_position < 0) {
                             table_data_sites.start_position = 0
                         }
                     }
                     ;
                     Get_site_list();
                 }
             }
         });

         const Get_site_list = function () {

             let list_sites;
             let count_trying = 0;
             let table = document.getElementById("site_body");

             const Init_site_list = function () {

                 function getXmlHttp() {
                     let xmlhttp;
                     try {
                         xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                     } catch (e) {
                         try {
                             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                         } catch (E) {
                             xmlhttp = false;
                         }
                     }
                     if (!xmlhttp && typeof XMLHttpRequest !== 'undefined') {
                         xmlhttp = new XMLHttpRequest();
                     }
                     return xmlhttp;
                 }

                 xmlhttp = getXmlHttp();
                 xmlhttp.onreadystatechange = function () {

                     event.preventDefault();

                     if (xmlhttp.readyState === 4) {
                         if (xmlhttp.status === 200) {
                             try {
                                 list_sites = JSON.parse(xmlhttp.responseText);
                                 table_sites = [];
                                 let i = 0;
                                 list_sites.forEach(function (item) {
                                     table_sites[i] = {
                                         'id': item['id'],
                                         'site_name': item['site_name'],
                                         'status': item['status']
                                     };
                                     i++;
                                 });
                                 table_data_sites.last_row = i - 1;
                                 flag_sites = false;
                                 Get_site_list();
                             }
                             catch (e) {
                                 message.mes = "Try connecting to SERVER ";
                                 Vue.nextTick(function () {
                                 });
                                 if (count_trying < max_count_trying) {
                                     count_trying++;
                                     Init_site_list();
                                 }
                                 else {
                                     message.mes = "SERVER not available, try later";
                                     Vue.nextTick(function () {
                                     });
                                     return (false);
                                 }
                             }
                         }
                         else {
                             message.mes = "Try connecting to SERVER ";
                             Vue.nextTick(function () {
                             });
                             if (count_trying < max_count_trying) {
                                 count_trying++;
                                 Init_site_list();
                             } else {
                                 message.mes = "SERVER not available, try later";
                                 Vue.nextTick(function () {
                                 });
                                 return (false);
                             }
                         }
                     }
                 };

                 xmlhttp.open('GET', 'List_sites.php', true, "jsonp");
                 xmlhttp.send();
             };
             // проверяем надо ли обновлять список из базы
             if (flag_sites) {
                 Init_site_list();
             }

             $("#site_table").find("tr:gt(0)").remove();
             let ii = table_data_sites.start_position;
             let i = 0;

             while ((i < table_data_sites.row_number) && (ii < (table_data_sites.last_row + 1)) && (flag_sites !== true)) {

                 let table_row = document.createElement("TR");

                 table.appendChild(table_row);
                 table_row.className = 'row_in_table full_width';
                 let col1 = table_row.appendChild(document.createElement("TD"));
                 col1.className = 'td_con id full_width';

                 let col2 = table_row.appendChild(document.createElement("TD"));
                 col2.className = 'td_con site_name full_width  ';
                 let col3 = table_row.appendChild(document.createElement("TD"));
                 col3.className = 'td_con status full_width ';

                 col2.id = table_sites[ii].id;

                 $(col2).draggable({
                     containment: 'document',
                     cursor: 'move',
                     helper: startDropSite,
                     tolerance: 'pointer',
                     zIndex: 999
                 });

                 col1.innerText = table_sites[ii].id;
                 col2.innerText = table_sites[ii].site_name;
                 col3.innerText = table_sites[ii].status;

                 let col4 = table_row.appendChild(document.createElement("TD"));

                 let del_button = document.createElement("button");
                 del_button.innerText = "X";
                 del_button.id = table_sites[ii].id;
                 del_button.className = 'button_in_table full_width ';

                 del_button.onclick = function () {

                     const Del_site = function (id) {
                         let jqxhr = $.post('Del_site.php', {'id': id}, "json");
                         jqxhr.done(function () {
                             try {
                                 textmes = JSON.parse(jqxhr.responseText);
                                 message.mes = textmes.message;
                                 Vue.nextTick(function () {
                                 });
                                 setTimeout(1000, 1);
                                 flag_sites = true;
                                 table_data_sites.last_row--;
                                 if (table_data_sites.start_position > 0) {
                                     table_data_sites.start_position--;
                                 }
                                 clearTimeout(1);
                                 Get_site_list();
                             } catch (e) {
                                 message.mes = 'Something was wrong! Site not deleted';
                                 flag_sites = false;
                             }
                         });
                         jqxhr.fail(function () {
                             message.mes = 'Server not available! Site not deleted';
                             flag_sites = false;
                         })
                     };

                     Del_site(this.id);
                 };
                 col4.appendChild(del_button);
                 i++;
                 ii++;
             }
         };

         const Get_status_list = function () {

         };

         InitSiteDropable();

         Init_selects();

         Get_site_list();

     }
 }
</script>

<style>

</style>