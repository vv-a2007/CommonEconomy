<template>
    <div>
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <ul class="nav nav-pills">
                    <router-link tag="li" class="nav-item" exact to="/" active-class="active"><a class="nav-link">Home</a></router-link>>
                    <router-link tag="li" class="nav-item" exact to="userorders" active-class="active"><a class="nav-link">User orders</a></router-link>
                    <router-link tag="li" class="nav-item" exact  to="sites" active-class="active"><a class="nav-link">Sites</a></router-link>
                    <router-link tag="li" class="nav-item" exact  to="geographylist" active-class="active"><a class="nav-link">Geography</a></router-link>
                    <router-link tag="li" class="nav-item" exact  to="geostructure" active-class="active"><a class="nav-link">Geo-Structure</a></router-link>
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="row" >
                    <div class="col-lg-6 "><span> User name : </span><span>{{ name_value }}</span></div>
                    <div class="col-lg-6"><span> User ID :</span><span> {{ ID_value }}</span> </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><pre> </pre></div>
        </div>
        <router-view></router-view>
       </div>
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

<style scoped>

</style>