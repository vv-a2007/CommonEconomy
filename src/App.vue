<template>
    <div>
      <div class="row">
        <div class="col-lg-10">
                <ul class="nav nav-pills">
                    <router-link tag="a" class="nav-item nav-link" exact  to="/" active-class="active">Home</router-link>
                    <router-link tag="a" class="nav-item nav-link" exact  to="/userorders" active-class="active">Geography</router-link>
                    <router-link tag="a" class="nav-item nav-link" exact  to="/sites" active-class="active">Sites</router-link>
                    <router-link tag="a" class="nav-item nav-link" exact  to="/geographylist" active-class="active">Geography</router-link>
                    <router-link tag="a" class="nav-item nav-link" exact  to="/geostructure" active-class="active">Geo-Structure</router-link>
                </ul>
          </div>
          <div class="col-lg-2">
                <div class="row">
                    <div class="col-lg-12 "><span> User name : </span><span>{{ name_value }}</span></div>
                </div>
                <div class="row">
                    <div class="col-lg-12"><span> User ID :</span><span> {{ ID_value }}</span> </div>
                </div>
           </div>
        </div>

        <div class="row">
            <div class="col-lg-12"><pre> </pre></div>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                name_value: "Vladimir",
                ID_value:"12345"
            }
        }
    };
</script>

<style>

</style>