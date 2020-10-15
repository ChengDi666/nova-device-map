import VueAMap from 'vue-amap';
Nova.booting((Vue, router, store) => {
    Vue.component('index-devicemap', require('./components/IndexField'))
    Vue.component('detail-devicemap', require('./components/DetailField'))
    Vue.component('form-devicemap', require('./components/FormField'))


    Vue.use(VueAMap);
    VueAMap.initAMapApiLoader({
        key: 'eeb7e7e703b57e8d106f6f352563bd71',
        plugin: ['AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MouseTool', 'AMap.MapType','Geocoder','Geolocation']
    });
})
