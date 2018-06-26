<template>
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12"><pre> </pre></div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <box id="country-box"
                         set-item-name="Country"
                         set-start-url="Get_list_countries.php"
                         set-add-url="Add_country.php"
                         set-edit-url="Edit_country.php"
                         set-clear-url="Del_country.php"
                         ref="countries">
                    </box>
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
                             set-start-url="Get_list_regions.php"
                             set-add-url="Add_region.php"
                             set-edit-url="Edit_region.php"
                             set-clear-url="Del_region.php"
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
                             set-start-url="Get_list_cities.php"
                             set-add-url="Add_city.php"
                             set-edit-url="Edit_city.php"
                             set-clear-url="Del_city.php"
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
                             set-start-url="Get_list_areas.php"
                             set-add-url="Add_area.php"
                             set-edit-url="Edit_area.php"
                             set-clear-url="Del_area.php"
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
                             set-start-url="Get_list_postcodes.php"
                             set-add-url="Add_postcode.php"
                             set-edit-url="Edit_postcode.php"
                             set-clear-url="Del_postcode.php"
                             ref="postcodes">
                        </geography-item>
                    </div>
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
        components: {GeographyItem},

    created () {

        let max_count_trying = 5;

        let country_box = new Vue({el: '#country-box'});

        let region_box = new Vue({el: '#region-box'});

        let city_box = new Vue({el: '#city-box'});

        let area_box = new Vue({el: '#area-box'});

        let postcode_box = new Vue({el: '#postcode-box'});


        country_box.$refs.countries.child[0] = region_box.$refs.regions;

        region_box.$refs.regions.parent = country_box.$refs.countries;

        region_box.$refs.regions.child[0] = city_box.$refs.cities;

        city_box.$refs.cities.parent = region_box.$refs.regions;

        city_box.$refs.cities.child[0] = area_box.$refs.areas;

        area_box.$refs.areas.parent = city_box.$refs.cities;

        postcode_box.$refs.postcodes.parent = region_box.$refs.regions;

        region_box.$refs.regions.child[1] = postcode_box.$refs.postcodes;



     }
    }
</script>

<style scoped>

</style>