<template>
    <b-container>
      <b-row>
        <b-col md="10">
                <b-nav justified pills>
                    <b-nav-item  :to="'/'" exact >Home</b-nav-item>
                    <b-nav-item  :to="'/userorders'" >User Orders</b-nav-item>
                    <b-nav-item  :to="'/geographylist'">Geography</b-nav-item>
                    <b-nav-item  :to="'/geostructure'">Geo-Structure</b-nav-item>
                    <b-nav-item  :to="'/delivery'">Delivery Points</b-nav-item>
                </b-nav>
        </b-col>
          <b-col md="2">
                <b-row >
                    <b-col md="12"><span> User name : </span><span>{{name_value}}</span></b-col>
                </b-row>
                <b-row class="row">
                    <b-col md="12"><span> User ID :</span><span> {{ID_value}}</span> </b-col>
                </b-row>
           </b-col>
      </b-row>

        <b-row>
            <b-col md="12"><pre> </pre></b-col>
        </b-row>
        <router-view></router-view>
    </b-container>
</template>

<script>
    export default {
        name: 'App',
        data () {
            return {
                name_value: "Vladimir",
                ID_value: "12345"
            }
        }
    };
</script>

<style>

</style>

<!-- <router-link tag="li" class="nav-item nav-link"  to="/sites" active-class="active">Sites</router-link> -->