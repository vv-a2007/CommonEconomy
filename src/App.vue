<template>
    <div class="container">
      <div class="row">
        <div class="col-lg-10">
                <b-nav justified pills>
                    <b-nav-item :to="'/'"exact >Home</b-nav-item>
                    <b-nav-item :to="'userorders'">User Orders</b-nav-item>
                    <b-nav-item :to="'geographylist'">Geography</b-nav-item>
                    <b-nav-item :to="'geostructure'">Geo-Structure</b-nav-item>
                </b-nav>
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
        name: 'App',
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

<!-- <router-link tag="li" class="nav-item nav-link"  to="/sites" active-class="active">Sites</router-link> -->