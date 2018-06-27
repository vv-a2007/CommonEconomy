<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12"><pre> </pre></div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <geography-item id="country-box"
                         set-item-name="Country"
                         set-start-url="http://ce.my/Get_list_countries.php"
                         set-add-url="http://ce.my/Add_country.php"
                         set-edit-url="http://ce.my/Edit_country.php"
                         set-clear-url="http://ce.my/Del_country.php"
                         ref="countries">
                    </geography-item>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><pre> </pre></div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div >
                        <geography-item id="region-box"
                             set-item-name="Region"
                             set-start-url="http://ce.my/Get_list_regions.php"
                             set-add-url="http://ce.my/Add_region.php"
                             set-edit-url="http://ce.my/php/Edit_region.php"
                             set-clear-url="http://ce.my/php/Del_region.php"
                             ref="regions">
                        </geography-item>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><pre> </pre></div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div >
                        <geography-item id="city-box"
                             set-item-name="City"
                             set-start-url="http://ce.my/Get_list_cities.php"
                             set-add-url="http://ce.my/Add_city.php"
                             set-edit-url="http://ce.my/Edit_city.php"
                             set-clear-url="http://ce.my/Del_city.php"
                             ref="cities">
                        </geography-item>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><pre> </pre></div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div >
                        <geography-item id="area-box"
                             set-item-name="Area"
                             set-start-url="http://ce.my/Get_list_areas.php"
                             set-add-url="http://ce.my/Add_area.php"
                             set-edit-url="http://ce.my/Edit_area.php"
                             set-clear-url="http://ce.my/Del_area.php"
                             ref="areas">
                         </geography-item>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><pre> </pre></div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div >
                        <geography-item id="postcode-box"
                             set-item-name="Postcode"
                             set-start-url="http://ce.my/Get_list_postcodes.php"
                             set-add-url="http://ce.my/Add_postcode.php"
                             set-edit-url="http://ce.my/Edit_postcode.php"
                             set-clear-url="http://ce.my/Del_postcode.php"
                             ref="postcodes">
                        </geography-item>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>

    import GeographyItem from "./geographyItem";


    export default {

        name: "geographyList",

        data(){
            return {

                country_box:null,
                region_box:null,
                city_box:null,
                area_box:null,
                postcode_box:null,

                max_count_trying:5
            }
        },

        components: {GeographyItem},

    mounted () {

          this.country_box = this.$children[0];
          this.region_box = this.$children[1];
          this.city_box = this.$children[2];
          this.area_box = this.$children[3];
          this.postcode_box = this.$children[4];

          this.country_box.child[0] = this.region_box;
          this.region_box.parent = this.country_box;
          this.region_box.child[0] = this.city_box;
          this.city_box.parent = this.region_box;
          this.city_box.child[0] = this.area_box;
          this.area_box.parent = this.city_box;
          this.postcode_box.parent = this.region_box;
          this.region_box.child[1] = this.postcode_box;

          }
    }
</script>

<style>

</style>