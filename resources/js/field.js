import VueAMap from 'vue-amap';
Nova.booting((Vue, router, store) => {
    Vue.component('myindex-amap', require('./components/IndexField'))
    Vue.component('mydetail-amap', require('./components/DetailField'))
    Vue.component('myform-amap', require('./components/FormField'))


    Vue.use(VueAMap);
    VueAMap.initAMapApiLoader({
        key: 'eeb7e7e703b57e8d106f6f352563bd71',
        plugin: ['AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MouseTool', 'AMap.MapType','Geocoder','Geolocation']
    });
})
