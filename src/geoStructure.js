
new Vue({
    el:"#geostructure"
});

let user;
user = new Vue({
    el: '#user',
    data: {
        name_value:"Vladimir",
        ID_value:"12345"
    }
});

let message;
message = new Vue({
    el:'#message',
    data: {
        mes:''
    }
});

let geo;
geo = new Vue ({
    el: '#geo',

    data: {
        geoList:[{
            geoname:"default",
            value:0
        }],
        activGeo:0
    } ,

    beforeMount: function() {
        //this.refresh_list()
    },

    methods: {

        refresh_list: function () {
            let jqxhr = $.get("Get_list_geos.php", "json");
            jqxhr.done(function () {
                    try {
                        geo.geoList=[{
                            geoname:"default",
                            value:0
                        }];
                        let options = JSON.parse(jqxhr.responseText);
                        for (let i = 0; i < options.length; i++) {
                            geo.geoList[i] = {geoname:options[i]['geo_name'],
                                geoId:options[i]['id'],
                                geoTable:options[i]['geo_table'],
                                value:i};

                        }
                        return (true);
                    }
                    catch (e) {
                        message.mes = "SERVER not working, try later";
                        return (false);
                    }
                }
            );
            jqxhr.fail(function () {
                message.mes = "SERVER not available, try later";
                return (false);
            })
        },

        selectGeo : function ($event) {
            geo.activGeo = event.target.getAttribute("value");
            $("#geo a").removeClass("active");
            event.target.setAttribute("class","nav-link active");
        }
    }
});
