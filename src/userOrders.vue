<template>
    <div class="container-fluid userOrders">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <span>Delivery points : </span><span id="delivery_list">{{delivery_points}}</span>
                </div>
                <div class="col-lg-12">
                    <table class="table table-responsive table-bordered" id="wish_table" >
                        <thead class="thead">
                        <tr class="tr">
                            <th class="th">ID order</th>
                            <th class="th">Site</th>
                            <th class="th">Number items</th>
                            <th class="th">Weigth, kg</th>
                            <th class="th">Currency</th>
                            <th class="th">Sum</th>
                            <th class="th">Standart delivery</th>
                            <th class="th">Saving</th>
                            <th class="th">Sum total</th>
                            <th class="th">Delivery point</th>
                            <th class="th">Common order</th>
                            <th class="th">Status</th>
                            <th class="th">Action</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "userOrders",
        data() {
            return { delivery_points:"default"}
        }
    }
</script>

<style scoped>

</style>