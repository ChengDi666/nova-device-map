<template>
  <panel-item :field="field">
    <div slot="value" v-if="field.value">
      <div class="amap-page-container">
        <el-amap
          v-if="center.length"
          vid="amapDemo"
          :center="center"
          :zoom="zoom"
          class="amap-field"
        >
          <el-amap-marker v-if="position.length" vid="component-marker" :position="position"></el-amap-marker>
          <el-amap-polygon v-if="obmobile.type == 'polygon' ? true : false" vid="polygonss" :path="obmobile.positions" :events="events"></el-amap-polygon>
          <el-amap-circle v-if="obmobile.type == 'circle' ? true : false" :center="obmobile.center" :radius="obmobile.radius" :events="events"></el-amap-circle>
        </el-amap>
      </div>
    </div>
    <span v-else slot="value">&mdash;</span>
  </panel-item>
</template>

<script>
export default {
  props: ["resource", "resourceName", "resourceId", "field"],
  data() {
    return {
      zoom: 12,
      center: [],
      position: [],
      polygons: [],
      obmobile: {},
      events: {
        init(o) {
          o.setOptions({
            fillColor:'#00b0ff',
            strokeColor:'#80d8ff',
            fillOpacity:'0.4',
            strokeOpacity: '0.4'
          });
        }
      }
    };
  },
  mounted() {
    let lng,
      lat,
      zoom = 12;
    console.log(this.field);
    if (this.field.value instanceof Object) {
      lng = this.field.value.lng;
      lat = this.field.value.lat;
      // console.log(this.field);
      this.obmobile = this.field.value;
      if (this.field.value.type == 'polygon') { //  多边形
        
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
      }
      // console.log(this.obmobile);
      this.center = [lng, lat];
      if (this.field.value.lng != '') {
        this.position = [lng, lat];
      }
      // console.log(this.center);
      // console.log(this.position);
    } else {
      lng = this.field.lng;
      lat = this.field.lat;
      this.center = [lng, lat];
      this.position = [lng, lat];
    }
  }
};
</script>
