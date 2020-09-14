<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <el-amap-search-box
        class="search-box"
        :search-option="searchOption"
        :on-search-result="onSearchResult"
      ></el-amap-search-box>
      <div class="amap-page-container">
        <el-amap
          vid="amapDemo"
          :center="center"
          :zoom="zoom"
          :amap-manager="amapManager"
          :plugin="!field.value?plugin:null"
          class="amap-field"
          :events="events"
        >
          <el-amap-marker v-if="position.length" vid="component-marker" :position="position"></el-amap-marker>
        </el-amap>
        <!-- <div style=" padding: 5px; position: absolute; top: 5px; left: 5px; background: rgba(204, 204, 204, 0.59);">
          <div class="input-item">
            <label>
              <input type="radio" name='func' v-on:click="draw('marker')" value='marker'>
              <span class="input-text">选点</span>
            </label><br>
            <label>
              <input type="radio" name='func' v-on:click="draw('polygon')" value='polygon'>
              <span class="input-text" style='width:5rem;'>画多边形</span>
            </label><br>
            <label>
              <input type="radio" name='func' v-on:click="draw('circle')" value='circle'>
              <span class="input-text">画圆</span>
            </label><br>
            <input id="clears" type="button" v-on:click="clears" class="btn" value="清除" />
          </div>
        </div> -->
      </div>
      <input
        v-if="address"
        :id="field.name"
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.name"
        v-model="address"
      >

    </template>
  </default-field>
</template>


<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import {AMapManager, lazyAMapApiLoaderInstance} from 'vue-amap'
let amapManager = new AMapManager() // 新建生成地图画布

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ["resourceName", "resourceId", "field"],
  data() {
    return {
      zoom: 12,
      amapManager,
      center: [],
      position: [],
      overlays: [],
      address: "",
      shapes: {},
      istrues: false,
      searchOption: {
        city: "山东",
        citylimit: false
      },
      mouseTool: '',
      events: {
        click: e => {
          this.eventsclick(e);
        }
      },
      plugin: [
        {
          pName: "Geolocation",
          events: {
            init: o => {
              o.getCurrentPosition((status, result) => {
                if (result && result.position) {
                  // console.log(result.position);
                  let { lng, lat } = result.position;
                  this.lng = lng;
                  this.lat = lat;
                  this.setMarker(lng, lat);
                  this.geocoder(lng, lat);
                  this.setAmapValue();
                  this.zoom = 20;
                  this.$nextTick();
                }
              });
            }
          }
        }
      ],
      lng: 0,
      lat: 0
    };
  },
  mounted() {
    let lng,
      lat,
      zoom = 12;
      setTimeout(() => {
        let map = this.amapManager._map;
        this.mouseTool = new AMap.MouseTool(map);
        // console.log(222);

        this.mouseTool.on('draw', (event) => {
          // console.log(event.obj);
          this.clears('');
          // event.obj 为绘制出来的覆盖物对象
          if (event.obj.CLASS_NAME == 'AMap.Circle') {
            this.shapes = {};
            this.shapes.type = 'circle';
            const {lng, lat} = event.obj.getCenter()
            this.shapes.center = {lng, lat};
            this.shapes.radius = event.obj.getRadius();
          } else {
            this.shapes = {};
            this.shapes.positions = [];
            this.shapes.type = 'polygon';
            console.log(event.obj.getPath());
            (event.obj.getPath()).forEach(item => {
              const {lat, lng} = item;
              this.shapes.positions.push({lat, lng});
            });
          }
          // console.log(this.shapes);
          this.overlays = [event.obj];
          this.setAmapValue();
          // console.log(this.overlays);
          console.log('覆盖物对象绘制完成')
        })
        // this.draw('marker')
        this.draw(this.field.shapetype);
      }, 1000);
    console.log(this.field);
    if (this.field.value instanceof Object && this.field.value.lng && this.field.value.lat) {
        lng = this.field.value.lng;
        lat = this.field.value.lat;
        setTimeout(() => {
          this.setMarker(lng, lat);
        }, 500);
    } else {
      // this.field.value.type == 'circle' ? {lng, lat} = this.field.value.center : {lng, lat} = this.field.value.positions[0] ;
      // console.log(123456);
      lng = this.field.lng;
      lat = this.field.lat;
      zoom = this.field.zoom;
    }
    this.lat = lat;
    this.lng = lng;
    this.zoom = zoom;
    this.center = [lng, lat];
    this.position = [lng, lat];
    // console.log(this.center);
    setTimeout(() => {
      this.tianjia(this.field.value);
    }, 500);
  },
  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || "";
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, JSON.stringify(this.value || ""));
      // console.log('测试');
      // console.log(this.value || "");
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      // Object.assign(this.value, value);
      this.value = value;
      // console.log(this.value);
    },
    setAmapValue() {
      let value = {
        lng: this.lng,
        lat: this.lat,
        address: this.address
      };
      Object.assign(value, this.shapes);
      // const value = this.shapes;
      // console.log(333);
      // console.log(value);
      this.handleChange(value);
    },
    geocoder(lng, lat) {
      // 这里通过高德 SDK 完成。
      
      let geocoder = new AMap.Geocoder({
        radius: 1000,
        extensions: "all"
      });
      geocoder.getAddress([lng, lat], (status, result) => {
        if (status === "complete" && result.info === "OK") {
          if (result && result.regeocode) {
            this.address = result.regeocode.formattedAddress;
            this.setAmapValue();
            this.$nextTick();
          }
        }
      });
    },
    setMarker(lng, lat) {
      this.position = [lng, lat];
      let istrue = true;
      const map = this.amapManager._map;
      const fugaiwu = map.getAllOverlays();
      if(fugaiwu) {
        // console.log(map.getAllOverlays());
        (map.getAllOverlays()).forEach(item => {
          // console.log(item);
          if(item.CLASS_NAME == 'AMap.Marker') {
            item.setPosition(new AMap.LngLat(lng, lat));
            item.setzIndex(101);
            istrue = false;
          }
        });
      }
      if (istrue) {
        const marker = new AMap.Marker({
          position: [lng, lat],
          offset: new AMap.Pixel(-13, -30)
        });
        map.add(marker);
      }
    },
    onSearchResult(pois) {
      if (pois.length > 0) {
        let { lng, lat } = pois[0];
        this.center = [lng, lat];
        this.setMarker(lng, lat);
        this.geocoder(lng, lat);
        this.lng = lng;
        this.lat = lat;
        this.setAmapValue();
      }
    },

    tianjia(data) {
      let map = this.amapManager._map;
      // console.log(data);
      if (data.type == 'polygon') {
        let polygonPath = [];
        data.positions.forEach(element => {
          polygonPath.push(new AMap.LngLat(element.lng, element.lat))
        });
        let polygon = new AMap.Polygon({
            path: polygonPath,
            fillColor:'#00b0ff',
            strokeColor:'#80d8ff',
            fillOpacity:'0.4',
            strokeOpacity: '0.4',
            bubble: true
        });
        map.add(polygon);
      } else if (data.type == 'circle') {
        const centerPath = new AMap.LngLat(data.center.lng, data.center.lat);
        let circle = new AMap.Circle({
            center: centerPath,
            radius: data.radius,
            fillColor:'#00b0ff',
            strokeColor:'#80d8ff',
            fillOpacity:'0.4',
            strokeOpacity: '0.4',
            bubble: true
        });
        map.add(circle);
      }
      map.setFitView(this.zoom);

    },

    eventsclick(e) {
      // console.log(e.lnglat);
      if(this.istrues) {
        let { lng, lat } = e.lnglat;
        this.lng = lng;
        this.lat = lat;
        this.setMarker(lng, lat);
        this.geocoder(lng, lat);
        this.setAmapValue();
      }
    },

    clears(e) {
      let map = this.amapManager._map;
      if (e && e.type == 'click') {
        const aa = document.getElementsByName('func');
        // console.log(aa);
        aa.forEach(item => item.checked = false);
        this.istrues = false;
        this.mouseTool.close(true);
        // console.log(map.getAllOverlays());
        // const type = ;
        const mypolygon = map.getAllOverlays();
        map.remove(mypolygon);
        // map.clearMap();
      }
      map.remove(this.overlays);
      this.overlays = [];
      this.lng = '';
      this.lat = '';
    },

    draw(type) {
      console.log(type);
      // console.log(this.field);
      this.istrues = false;
      switch(type) {
        case 1:{ //  marker
            // this.mouseTool.marker({
            //   //同Marker的Option设置
            // });
            this.istrues = true;
            break;
        }
        case 2:{ //  polygon
            this.mouseTool.polygon({
              fillColor:'#00b0ff',
              strokeColor:'#80d8ff'
              //同Polygon的Option设置
            });
            break;
        }
        case 3:{ //  circle
            this.mouseTool.circle({
              fillColor:'#00b0ff',
              strokeColor:'#80d8ff'
              //同Circle的Option设置
            });
            break;
        }
      }
    },
  }
};
</script>
