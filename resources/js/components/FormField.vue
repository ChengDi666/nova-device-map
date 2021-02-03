<template>
  <default-field :field="field" :errors="errors"  :full-width-content="true">
    <template slot="field" class="w-4/5">
      <div class="amap-page-container" v-bind:class="{ 'big-map': isBigMap }">
        <el-amap
          v-if="center.length"
          vid="amapDemo"
          :center="center"
          :zoom="zoom"
          :amap-manager="amapManager"
          class="amap-field"
          :events="events"
        >
        </el-amap>
        <div class="screen-zoom-icon" @click="screenZoom()">
          <svg v-if="!isBigMap" t="1602731505008" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1721" width="32" height="32"><path d="M218.688721 168.644955l-0.013303 0 0-0.014326L218.688721 168.644955l128.45665-0.556679c19.003819 0.508583 36.624129-13.658068 39.493479-37.807071L386.638851 104.19713c-0.474814-20.503986-16.169261-37.442774-35.158754-37.897122l-245.311055 1.561565c-0.37146-0.040932-0.605797-0.186242-0.935302-0.186242l-17.193591-0.412392c-9.494235-0.24764-18.012236 3.756557-24.087605 10.389628-6.151094 6.591115-8.428973 15.797801-8.18031 26.090215l1.843998 18.562774c0 0.37146-1.280156 0.61296-1.280156 1.025353l0.956791 265.449721c0.412392 20.454868 16.121166 32.736589 35.165918 33.190937l25.552979 0c19.003819 0.454348 34.092469-17.359366 33.665751-37.786605l-1.073448-144.370085 169.152515 179.211615c18.377556 19.84293 48.128137 19.84293 66.518996 0 18.329461-19.835767 18.329461-51.897997 0-71.755254L218.688721 168.644955z" p-id="1722"></path><path d="M948.293761 899.895471c-0.034792-0.460488 1.238201-0.722454 1.238201-1.073448l-0.014326-0.007163-0.977257-261.362636c-0.481977-20.441565-16.182564-32.67519-35.186384-33.128515l-24.163329-0.034792c-18.934235-0.467651-34.085306 17.385972-33.603329 37.849026l1.073448 141.253094L687.535899 603.016947c-18.405185-19.850094-48.106648-19.850094-66.49853 0-18.36323 19.835767-18.36323 51.897997 0 71.734788l169.104419 180.25027-128.297015 0.550539c-18.989493-0.454348-36.576033 12.115945-39.493479 36.273135l0 26.083052c0.481977 20.4958 16.237823 37.442774 35.17922 37.951357l242.160295-1.582031c0.391926 0 0.611937 0.164752 0.970094 0.164752l17.173125 0.454348c9.495258 0.240477 18.054191-3.76372 24.115234-10.417257 6.212492-6.529717 8.407484-15.763009 8.222265-26.062586L948.293761 899.895471z" p-id="1723"></path><path d="M386.225435 603.009783l-0.014326 0c-18.36323-19.84907-48.14144-19.84907-66.505693 0L150.561088 782.214235l1.086751-142.119835c0.413416-20.4958-14.675234-38.364773-33.610492-37.849026l-25.574469 0c-19.051915 0.509606-34.745339 12.68695-35.172057 33.183773l-0.99056 263.323291c0 0.37146 1.286296 0.61296 1.286296 1.025353l-1.843998 18.521842c-0.206708 10.299577 2.00875 19.540032 8.167007 26.062586 6.068206 6.653537 14.634302 10.657734 24.067138 10.416234l17.207917-0.454348c0.358157 0 0.578168-0.164752 0.970094-0.164752l245.290589 1.589195c18.989493-0.522909 34.71157-17.455557 35.172057-37.95852l0-26.076912c-2.862187-24.157189-20.482497-36.72032-39.438221-36.273135l-129.955794-0.454348 169.001065-180.24413C404.568199 654.970202 404.568199 622.845551 386.225435 603.009783z" p-id="1724"></path><path d="M941.984055 77.652568c-6.068206-6.632047-14.634302-10.637268-24.115234-10.354835l-17.152658 0.412392c-0.385786 0-0.61296 0.144286-0.99056 0.206708L654.063553 66.333778c-19.017122 0.474814-34.704406 17.414625-35.186384 37.910425l-0.048095 26.090215c2.917446 24.190959 20.565385 38.302351 39.486316 37.841863l130.368186 0.556679L621.181655 347.381755c-18.418488 19.75288-18.418488 51.815109-0.048095 71.6519l0 0.007163c18.377556 19.84293 48.093345 19.84293 66.491367 0l169.132048-180.327018-1.086751 145.471163c-0.461511 20.434401 14.696724 38.309514 33.617655 37.85619l24.163329 0c18.989493-0.522909 34.69008-12.756535 35.172057-33.197076l0.977257-265.512143c0-0.412392-1.258667-0.661056-1.258667-1.032516l1.851161-18.562774C950.391539 93.449345 948.183244 84.237543 941.984055 77.652568z" p-id="1725"></path></svg>
          <svg v-else t="1602731599766" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5056" width="32" height="32"><path d="M400.595 345.365l-0.948-245.022c-0.42-18.881-16.018-30.215-34.956-30.637h-25.406c-18.88-0.42-33.874 16.018-33.457 34.881l1.061 133.251-168.117-165.421c-18.274-18.311-47.844-18.311-66.119 0-18.218 18.314-18.218 47.907 0 66.236l166.575 164.885-127.697 0.512c-18.88-0.477-36.394 12.606-39.26 34.899v24.080c0.477 18.917 16.077 34.558 34.957 34.972l243.826-1.438c0.362 0.035 0.608 0.171 0.928 0.171l17.1 0.378c9.441 0.226 17.9-3.467 23.923-9.593 6.124-6.083 8.382-14.58 8.131-24.078l-1.821-17.138c0.001-0.335 1.27-0.562 1.27-0.945z" p-id="5057"></path><path d="M766.211 701.451l127.524-0.512c18.88 0.421 36.357-11.183 39.26-33.474v-24.077c-0.478-18.922-16.134-34.558-34.957-35.037l-240.702 1.458c-0.378 0-0.605-0.151-0.967-0.151l-17.062-0.42c-9.441-0.226-17.95 3.469-23.98 9.611-6.159 6.030-8.361 14.559-8.173 24.057l1.881 17.1c0.033 0.42-1.234 0.661-1.234 0.986l0.986 241.248c0.477 18.863 16.078 30.162 34.957 30.576l24.017 0.037c18.827 0.433 33.874-16.055 33.403-34.941l-1.062-130.388 168.117 166.502c18.276 18.314 47.809 18.314 66.085 0 18.255-18.31 18.255-47.906 0-66.218l-168.095-166.366z" p-id="5058"></path><path d="M392.992 618.855c-6.028-6.14-14.541-9.834-23.923-9.61l-17.104 0.42c-0.346 0-0.566 0.151-0.948 0.151l-243.81-1.458c-18.881 0.478-34.503 16.112-34.956 35.034v24.078c2.843 22.292 20.357 33.892 39.206 33.474l129.158 0.42-167.983 166.37c-18.234 18.255-18.234 47.906 0 66.218 18.256 18.314 47.845 18.314 66.102 0l168.137-165.418-1.079 131.185c-0.42 18.922 14.579 35.413 33.424 34.938h25.406c18.937-0.477 34.54-11.713 34.956-30.637l0.987-243.050c0-0.346-1.267-0.571-1.267-0.949l1.821-17.104c0.206-9.495-1.993-18.025-8.116-24.053z" p-id="5059"></path><path d="M615.434 387.559c6.030 6.123 14.541 9.819 23.965 9.553l17.060-0.378c0.378 0 0.608-0.132 0.986-0.19l244.19 1.457c18.88-0.434 34.482-16.078 34.956-34.994l0.058-24.078c-2.898-22.331-20.439-35.355-39.26-34.939l-129.573-0.511 166.483-164.893c18.31-18.235 18.31-47.83 0.054-66.143-18.276-18.311-47.809-18.311-66.084 0l-168.117 166.447 1.079-134.276c0.454-18.863-14.598-35.355-33.424-34.939h-24.017c-18.881 0.477-34.484 11.773-34.957 30.637l-0.967 245.075c0 0.378 1.251 0.608 1.251 0.948l-1.859 17.138c-0.192 9.499 2.007 17.991 8.173 24.078z" p-id="5060"></path></svg>
        </div>
        <div class="screen-zoom-icon" v-if="field.shapetype == 'setTrack'" style="right: 3.5rem; padding: 8px 5px;">
          <div v-if="route.CLASS_NAME == undefined">
            <label style="padding: 0 5px;"> <input type="radio" name="shezhi" value="start" @click="setMyMarkers($event)" :checked="dianType == 'start'" :disabled="dian.start"/> 设置起点 </label>
            <label style="padding: 0 5px;"> <input type="radio" name="shezhi" value="end" @click="setMyMarkers($event)" :checked="dianType == 'end'" :disabled="dian.end" /> 设置终点 </label>
          </div>
          <div v-else>
            <label style="padding: 0 5px;"> <a @click="delMarkers($event)"> 销毁轨迹 </a></label>
          </div>
        </div>
      </div>
      <div v-if="isBigMap" class="zhezhao"></div>
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
      zoom: 15,
      amapManager,
      myMap: {},
      isBigMap: false,
      center: [],
      newOverlays: [],
      polylines: [],
      initoverlay: {},
      overlaysData: {},
      isClick: true,    //  地图点击
      mouseTool: '',
      dian: {
        start: false,
        end: false
      },
      dianType: '',
      infoWindows: {},
      events: {
        init:(map) => {
          // console.log(map);
          this.myMap = map;
        },
        click: e => {
          this.eventsclick(e);
        }
      },
      lng: 0,
      lat: 0,
      route: {}
    };
  },
  mounted() {
    let lng, lat, zoom = 16;
    setTimeout(() => {
      this.initMouseTool();
      this.draw(this.field.shapetype);
    }, 1000);
    console.log(this.field);
    if (this.field.value instanceof Object && this.field.value.lng && this.field.value.lat) {
      lng = this.field.value.lng;
      lat = this.field.value.lat;
    } else {
      lng = this.field.lng;
      lat = this.field.lat;
      zoom = this.field.zoom;
    }
    this.lat = lat;
    this.lng = lng;
    this.zoom = zoom;
    this.center = [lng, lat];
    if(this.field.value) {  //  初始化覆盖物
      setTimeout(() => this.initAddOverlays(this.field), 500);
    }
  },
  methods: {
    delMarkers(e) {
      this.route.destroy();   //  销毁轨迹
      this.route = {};    //  清空可拖拽轨迹实例
      this.dian.start = false;    //  禁止选择起点
      this.dian.end = false;    //  禁止选择终点
      this.isClick = true;    //  地图点击
      console.log('销毁轨迹')
      this.handleChange({
        lat: this.lat,
        lng: this.lng
      });
      // let polyline = new AMap.Polyline({
      //   path: this.polylines,
      //   map: this.myMap
      // })

    },
    setMyMarkers(e) {
      // console.log(e);
      // console.log(e.target.value);
      this.isStart = (e.target.value == 'start');
      this.dianType = e.target.value;
    },
    setMarkers(lnglat) {
      if(this.dianType == '') return;
      let icon, dianType;
      this.isStart = !this.isStart;
      dianType = this.dianType == 'start' ? 'end' : 'start';
      icon = `https://webapi.amap.com/theme/v1.3/markers/n/${this.dianType}.png`;
      let marker = new AMap.Marker({
        position: [lnglat.lng, lnglat.lat],
        clickable: true,
        icon: icon,
        offset: new AMap.Pixel(-13, -30),
      });
      this.myMap.add(marker);
      this.dian[this.dianType] = true;
      this.dian[this.dianType + 'Marker'] = marker;
      this.dian[this.dianType + 'Position'] = [lnglat.lng, lnglat.lat];
      this.dianType = dianType;
      // console.log(this.dian);
      if(this.dian.start && this.dian.end) {
        this.dianType = undefined;
        this.dian.path = [this.dian.startPosition, this.dian.endPosition]
        this.opens1(this.dian);
        return;
      }
    },
    opens1(data) {    //  拖拽导航
      // console.log(data);
      let position = {};
      if(data.startMarker && data.endMarker) this.myMap.remove([data.startMarker, data.endMarker]);
      this.isClick = false;
      (this.myMap).plugin("AMap.DragRoute", () => {
        this.route = new AMap.DragRoute(this.myMap, data.path, AMap.DrivingPolicy.LEAST_DISTANCE); //构造拖拽导航类
        this.route.search(); //查询导航路径并开启拖拽导航
        // this.route.on('addway', (e) => {
        //   console.log(e);
        // });
        this.route.on('complete', (e) => {
          let lists = [];
          // console.log(e);
          this.polylines = this.route.getRoute(); //  所有的点
          // const distance = Math.round(AMap.GeometryUtil.distanceOfLine(this.polylines));
          // console.log('路径总长： ', distance, ' 米');
          // console.log(this.polylines);
          const polylines = this.polylines.map( item => { return [item.lng,item.lat] });  //  获取路径的所有点
          // console.log(e.target.Hr); //  轨迹起、途、终点
          if((e.target.Hr).length) {
            (e.target.Hr).map(item => {
              lists.push([item.lng, item.lat]);
            });
          }
          position.path = lists;
          position.pathList = polylines;
          position.lng = this.lng;
          position.lat = this.lat;
          // console.log(position);
          // console.log(JSON.stringify(position).length);
          this.handleChange(position);
        });
      });
    },
    getSpots(){   //  加载清运点
      axios.get('/api/spots')
          .then(response => {
            // console.log(response);
            if(response.status == 200) {
              this.spots = response.data.data;
              this.setSpots(response.data.data, '清')

            }
          });
    },
    getTransfers(){   //  加载转运站
      axios.get('/api/transfer')
          .then(response => {
            // console.log(response);
            if(response.status == 200) {
              this.transfers = response.data.data;
              this.setSpots(response.data.data, '转')
            }
          });
    },
    setSpots(data, type, content) {
      AMapUI.loadUI(['overlay/SimpleMarker'], (SimpleMarker) => {
        data.forEach(item => {
          const marker = new SimpleMarker({
            iconLabel: {
              innerHTML: type, //设置文字内容
              style: {
                color: '#000'  //设置文字颜色
              }
            },
            iconStyle: type == '清' ? 'lightgreen' : 'darkgreen',
            map: this.myMap,
            position: [item.position.lng, item.position.lat]
          });
          marker.setzIndex(10);
          if(type == '清') marker.content = `<p>清运点：${item.name}</p><p>地址：${item.address.fullname}</p>`
          else marker.content = `<p>转运站：${item.name}</p><p>地址：${item.address.fullname}</p>`;
          marker.on("mouseover", this.infoWindowOpen);
          marker.emit("mouseover", { target: marker});
          marker.on("mouseout", this.infoWindowClose);
          marker.emit("mouseout", { target: marker});
        });
      });
    },
    screenZoom() {  //  放大缩小地图
      this.isBigMap = !this.isBigMap;
      setTimeout(() => {  //  覆盖物居中
        this.myMap.setFitView(this.myMap.getAllOverlays());
      }, 500);
    },
    setInitialValue() {   //  设置字段的初始内部值
      this.value = this.field.value || "";
    },

    fill(formData) {    //  用字段的内部值填充给定的FormData对象
      formData.append(this.field.attribute, JSON.stringify(this.value || ""));
    },

    handleChange(value) {   //  更新字段的内部值
      this.value = value;
    },
    setAmapValue() {  //  设置字段的内部值
      let value = {
        lng: this.lng,
        lat: this.lat,
      };
      Object.assign(value, this.overlaysData);
      this.handleChange(value);
    },
    initAddOverlays(data) { //  初始化添加覆盖物
      let Overlays;
      if(data.shapetype == 'setTrack') {
        console.log('设置轨迹');
        if(data.value.path && data.value.path.length) {
          this.opens1(data.value);
          this.dian.start = true;
          this.dian.end = true;
        }
        return ;
      } else if (data.value.type == 'polygon') {
        let polygonPath = [];
        data.value.positions.forEach(element => {
          polygonPath.push(new AMap.LngLat(element.lng, element.lat))
        });
        Overlays = new AMap.Polygon({
            path: polygonPath,
            fillColor:'#00b0ff',
            strokeColor:'#80d8ff',
            fillOpacity:'0.4',
            strokeOpacity: '0.4',
            bubble: true
        });
      } else if (data.value.type == 'circle') {
        const centerPath = new AMap.LngLat(data.value.center.lng, data.value.center.lat);
        Overlays = new AMap.Circle({
            center: centerPath,
            radius: data.value.radius,
            fillColor:'#00b0ff',
            strokeColor:'#80d8ff',
            fillOpacity:'0.4',
            strokeOpacity: '0.4',
            bubble: true
        });
      } else if (data.value.type == undefined && data.value.lng && data.value.lat) {
        Overlays = new AMap.Marker({
          position: [data.value.lng, data.value.lat],
          offset: new AMap.Pixel(-13, -30)
        });
      }
      this.initoverlay = Overlays;
      this.myMap.add(Overlays);
      this.myMap.setFitView(Overlays);
    },

    eventsclick(e) {  //  地图点击事件
      // console.log(e.lnglat);
      if(this.field.shapetype == 'setTrack' && this.isClick) {
        this.setMarkers(e.lnglat);
        return ;
      }
      this.clears('');
    },

    clears(e) { //  清除覆盖物
      if(this.initoverlay) {
        this.myMap.remove(this.initoverlay);
        this.initoverlay = undefined;
      }
      this.myMap.remove(this.newOverlays);
      this.newOverlays = [];
      this.lng = '';
      this.lat = '';
    },
    initMouseTool() {   //  绑定添加覆盖物成功事件
      this.mouseTool = new AMap.MouseTool(this.myMap);
      this.mouseTool.on('draw', (event) => {
        // event.obj 为绘制出来的覆盖物对象
        if (event.obj.CLASS_NAME == 'AMap.Circle') {  //  圆
          this.clears('');
          this.overlaysData = {};
          this.overlaysData.type = 'circle';
          const {lng, lat} = event.obj.getCenter()
          this.lng = lng;
          this.lat = lat;
          this.overlaysData.center = {lng, lat};
          this.overlaysData.radius = event.obj.getRadius();
        } else if(event.obj.CLASS_NAME == "AMap.Marker") {  //  点
          // console.log(event.obj.getPosition());
          let { lng, lat } = event.obj.getPosition();
          this.lng = lng;
          this.lat = lat;
        } else if(event.obj.CLASS_NAME == "AMap.Polygon")  {  //  多边形
          this.overlaysData = {};
          this.overlaysData.positions = [];
          this.overlaysData.type = 'polygon';
          const polygonPath = event.obj.getPath();
          // console.log(polygonPath);
          this.lng = polygonPath[0].lng;
          this.lat = polygonPath[0].lat;
          polygonPath.forEach(item => {
            const {lat, lng} = item;
            this.overlaysData.positions.push({lat, lng});
          });
        } else {
          console.log('传入的值无效');
        }
        this.newOverlays = [event.obj];
        this.setAmapValue();
        console.log('覆盖物对象绘制完成')
      })
    },

    infoWindowOpen(e) { //  鼠标悬停，打开信息窗
      if (e.lnglat === undefined) return; //  加载时，不显示
      var infoWindow = this.infoWindows;
      if(infoWindow.CLASS_NAME == undefined) {
        infoWindow = new AMap.InfoWindow({ offset: new AMap.Pixel(0, -45), closeWhenClickMap: true });
        // console.log('鼠标移入');
      }
      infoWindow.setContent(e.target.content);
      infoWindow.open(this.myMap, e.target.getPosition());
      this.infoWindows = infoWindow;

    },
    infoWindowClose(e) { //  鼠标移除，关闭信息窗
      if (e.lnglat === undefined) return; //  加载时，不显示
      // console.log('鼠标移出');
      this.infoWindows.close();
    },


    draw(type) {  //  根据传入值选择绘制类型
      console.log(type);
      switch(type) {
        case 1:{ //  marker
            this.mouseTool.marker({
              //同Marker的Option设置
            });
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
        case 'setTrack':{ //  轨迹
          // setTimeout(() => {
          //   this.opens1();
          // }, 3000)
          this.getSpots();
          this.getTransfers();
          break;
        }
      }
    },
  }
};
</script>
