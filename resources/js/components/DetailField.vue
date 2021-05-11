<template>
  <panel-item :field="field">
    <div slot="value" v-if="field.value">
      <div class="amap-page-container" style="position: relative;">
        <el-amap
          v-if="center.length"
          vid="amapDemo"
          :center="center"
          :zoom="zoom"
          :amap-manager="amapManager"
          class="amap-demo"
          :events="mapEvents"
        >
          <el-amap-marker v-if="position.length" vid="component-marker" :position="position"></el-amap-marker>
          <el-amap-polygon v-if="obmobile.type == 'polygon' ? true : false" vid="polygonss" :path="obmobile.positions" :events="RangeEvents"></el-amap-polygon>
          <el-amap-circle v-if="obmobile.type == 'circle' ? true : false" :center="obmobile.center" :radius="obmobile.radius" :events="RangeEvents"></el-amap-circle>
          <el-amap-polyline v-if="field.shapetype == 'track' ? true : false" :path="obmobile" :events="polylineEvent"></el-amap-polyline>
          <el-amap-marker v-if="dian.isShow" vid="component-marker" :position="dian.position" :icon="dian.icon" :events="catEvent" :offset="offsets" autoRotation="true" angle="-90"></el-amap-marker>
        </el-amap>
      </div>
    </div>
  </panel-item>
</template>

<script>
import { AMapManager, lazyAMapApiLoaderInstance } from "vue-amap";
let amapManager = new AMapManager(); // 新建生成地图画布

export default {
  props: ["resource", "resourceName", "resourceId", "field"],
  data() {
    let self = this;
    return {
      zoom: 13,
      center: [],
      position: [],
      polygons: [],
      obmobile: {},
      offsets: [-26,-13],
      myMap: {},
      markerss: {},
      infoWindows: {},
      myMarker: {},
      amapManager,
      dian: {
        isShow: false,
        position: [118.717815,32.124495],
        icon: "https://webapi.amap.com/images/car.png",
      },
      mapEvents: {
        init(o) {
          // console.log(o);
          self.myMap = o;
          setTimeout(() => {  //  覆盖物居中
            o.setFitView(o.getAllOverlays());
          }, 5000);
          if(self.field.shapetype == 'setTrack' && self.field.value.path && self.field.value.path.length) { //  轨迹设置-显示
            self.showPath(self.field.value.path);
          }
          if(self.field.shapetype == 'track' && self.field.value && self.field.value.length > 1) {
            self.addMarkers(self.field.value);
          }
        }
      },
      RangeEvents: {  //  覆盖物范围
        init(o) {
          o.setOptions({
            fillColor:'#00b0ff',
            strokeColor:'#80d8ff',
            fillOpacity:'0.4',
            strokeOpacity: '0.4'
          });
        }
      },
      catEvent: {   //  车辆
        init: (o) => {
          self.myMarker = o;
          // console.log(o);
          // console.log('车辆加载完成');
          this.startPlay();
        }
      },
      polylineEvent: {   //  历史轨迹
        init: (o) => {
          o.setOptions({
            showDir: true,
            strokeWeight: 5,
            lineJoin: "round",
            strokeColor: "#28F"
          });
        }},
    };
  },
  mounted() {
    let lng, lat, zoom = 12;
    console.log(this.field);
    // console.log(this.field.shapetype);
    if (this.field.value instanceof Object) {
      // lng = this.field.value.lng;
      // console.log(this.field.value.coordinates);
      // lat = this.field.value.lat;
      // console.log(this.field);
      this.obmobile = this.field.value;
      if(this.field.shapetype == 'track' && this.field.value) {  //  历史轨迹
        this.dian.isShow = true;
        // console.log(this.field.value);
        if(this.field.value.length) { // 有轨迹信息
          if(this.field.value.length > 1) { // 轨迹超过一个点
            this.obmobile = this.field.value.map(item => {
              return [item.lng, item.lat];
            });
          } else this.obmobile = []
          lat = this.field.value[0].lat;
          lng = this.field.value[0].lng;
        } else {
          lat = this.field.lat;
          lng = this.field.lng;
        }
        this.dian.position = [lng, lat];
        // console.log(this.dian.position);
      } else if(this.field.shapetype == 'setTrack') { //  轨迹设置-显示
        if(this.field.value.path && this.field.value.path.length) {
          lat = this.field.value.path[0][1];
          lng = this.field.value.path[0][0];
        }
      } else if (this.field.value.type == 'polygon') { //  多边形
        this.field.value.positions.forEach((element, index) => {
          this.obmobile.positions[index] = [element.lng, element.lat];
        });
        if (this.field.value.lng == '') {
          lng = this.obmobile.positions[0][0];
          lat = this.obmobile.positions[0][1];
          // console.log(lng, lat);
        }
      } else if (this.field.value.type == 'circle') {   //  圆形
        // {lat, lng} = this.obmobile.center;
        if (this.field.value.lng == '') {
          lng = this.field.value.center.lng;
          lat = this.field.value.center.lat;
        }
        this.obmobile.center = [lng, lat];
      } else { // 点
      // } else if(this.field.value.type == 'Point') { // 点
        // lat = this.field.value.coordinates[1];
        // lng = this.field.value.coordinates[0];
        lng = this.field.value.lng;
        lat = this.field.value.lat;
        this.position = [lng, lat];
      }
      // console.log(this.obmobile);
      this.center = [lng, lat];
    } else {
      lng = this.field.lng;
      lat = this.field.lat;
      this.center = [lng, lat];
      this.position = [lng, lat];
    }
  },
  methods: {
    addMarkers(data) {
      for(let i=0;i<data.length;i+=1){
        const item = data[i];
        let circleMarker = new AMap.CircleMarker({
          center: [item.lng, item.lat],
          // center: new AMap.LngLat(item.lng, item.lat),
          radius:6,//3D视图下，CircleMarker半径不要超过64px
          // strokeColor:'black',
          strokeWeight:0,
          fillColor:'rgba(255,255,255,0)',
          strokeOpacity: 0,
          zIndex:100,
          bubble:true,
          cursor:'pointer',
          clickable: true
        })
        circleMarker.content = item.time
        circleMarker.setMap(this.myMap)
        circleMarker.on("mouseover", this.infoWindowOpen);
        circleMarker.emit("mouseover", { target: circleMarker});
        circleMarker.on("mouseout", this.infoWindowClose);
        circleMarker.emit("mouseout", { target: circleMarker});
      }
    },
    startPlay() {
      console.log('播放轨迹');
      // console.log(this.myMap);
      // console.log(this.myMarker);
      // 轨迹
      let passedPolyline = new AMap.Polyline({
        map: this.myMap,
        // path: lineArr,
        showDir: true,
        strokeColor: "#AF5",  //线颜色
        // strokeOpacity: 1,     //线透明度
        strokeWeight: 6,      //线宽
        // strokeStyle: "solid"  //线样式
      });
      this.myMarker.on('moving', (e) => {
        passedPolyline.setPath(e.passedPath);
      });
      this.myMarker.moveAlong(this.obmobile, 60, function(k){return k}, true);
    },
    showPath(data) {  //  路线规划显示
      // console.log(data);
      const start = data[0], end = data[data.length-1];
      let list = data.slice(1,data.length-1)
      list = list.map(item => { return new AMap.LngLat(...item); });
      let driving = new AMap.Driving({
        map: this.myMap,
        policy: AMap.DrivingPolicy.LEAST_DISTANCE
      });    //  声明经纬度规划驾车导航路线
      // 根据起终点经纬度规划驾车导航路线
      driving.search(new AMap.LngLat(...start), new AMap.LngLat(...end),{
        waypoints:list
      }, (status, result) => {
        if (status === 'complete') {
          console.log('绘制驾车路线完成')
        } else {
          console.log('获取驾车数据失败：' + result)
        }

      });
    },   

    async infoWindowOpen(e) { //  鼠标悬停，打开信息窗
      if (e.lnglat === undefined) return; //  加载时，不显示
      var infoWindow = this.infoWindows;
      if(infoWindow.CLASS_NAME == undefined) {
        infoWindow = new AMap.InfoWindow({ offset: new AMap.Pixel(0, -15), closeWhenClickMap: true });
        // console.log('鼠标移入');
      }
      const content = await this.formatDate(new Date(e.target.content), 'yyyy-MM-dd hh:mm:ss')
      const position = e.target.getCenter()
      infoWindow.setContent(`<p>坐标： ${position}</p><p>时间： ${content}</p>`);
      infoWindow.open(this.myMap, position);
      this.infoWindows = infoWindow;

    },
    infoWindowClose(e) { //  鼠标移除，关闭信息窗
      if (e.lnglat === undefined) return; //  加载时，不显示
      // console.log('鼠标移出');
      this.infoWindows.close();
    },
    
    padLeftZero(str) {
      return ('00' + str).substr(str.length)
    },

    formatDate(date, fmt) {
      if (/(y+)/.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, (date.getFullYear() + '').substr(4 - RegExp.$1.length))
      }
      let o = {
        'M+': date.getMonth() + 1,
        'd+': date.getDate(),
        'h+': date.getHours(),
        'm+': date.getMinutes(),
        's+': date.getSeconds()
      }
      for (let k in o) {
        if (new RegExp(`(${k})`).test(fmt)) {
          let str = o[k] + ''
          fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? str : (('00' + str).substr(str.length)))
        }
      }
      return fmt
    }

  }
};
</script>
