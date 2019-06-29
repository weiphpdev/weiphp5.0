<template>
  <div class="collage active" v-if="eventinfo != null">
    <!-- 活动banner -->
    <activeBanner v-bind:active="active" v-bind:eventinfo="eventinfo"></activeBanner>
    <!-- 活动商品 -->
    <activeContent v-bind:goodslists="goodslists" v-bind:active="active" v-bind:eventinfo="eventinfo" :cd="cd"></activeContent>
    <!--我的拼团-->
    <div class="bottom-btn">
      <a class="my_collage" :href="'../my_collage/index?id=' + eventinfo.id ">我的拼团</a>
    </div>
  </div>
  <div class="active_end" v-else>
    <img lazy-load :src="imgRoot+'error.png'"><br>
    <span>该活动已结束</span>
  </div>
</template>
<script>
  import activeBanner from '@/components/active/activeBanner'
  import activeContent from '@/components/active/activeContent'
  import {post, host} from "@/utils"
  export default {
    data () {
      return {
				imgRoot: this.imgRoot,
        cd: {day: 0, hour: 0, min: 0, sec: 0, satrttime: 0, endtime: 0, nowtime: 0},
        eventinfo: {},
        goodslists: [],
        active: {name: '拼团', img: this.imgRoot+'collagebanner.jpg', url: '../collage_detail/index?id='}
      }
    },
    components: {
      activeBanner,
      activeContent
    },
    methods: {
      // 发送请求
      getData () {
        post(host+"/collage/Api/index", {
          collage_id: 38,
          PHPSESSID: wx.getStorageSync('PHPSESSID')
        }).then((data) => {
          this.goodslists = data.goods_lists;
          this.eventinfo = data.event_info;
          this.cd.endtime = data.event_info.end_time;
          this.cd.starttime = data.event_info.start_time;
      })
      },
      countdown: function () {
        var that = this;
        // const endtime = Date.parse(new Date('2019-12-01'))
        const endtime = that.cd.endtime;
        this.cd.nowtime = Date.parse(new Date()) / 1000;
        const msec = endtime - Date.parse(new Date()) / 1000;
        let d = parseInt(msec / 60 / 60 / 24);
        let h = parseInt(msec / 60 / 60 % 24);
        let m = parseInt(msec / 60 % 60);
        let s = parseInt(msec % 60);
        this.cd.day = d;
        this.cd.hour = h;
        this.cd.min = m;
        this.cd.sec = s;
        setTimeout(function () {
          that.countdown()
        }, 1000)
      }
    },
    created () {
      // var id = this.$root.$mp.query.id;
      this.getData();
      this.countdown()
    }
  }
</script>
<style>
  .bottom-btn{text-align:center;color:white;position:fixed;width:100%;bottom:0;display:inline-flex;z-index:2;}
  .my_collage{width:100%;height:100%;padding:10px 0;color:white;background:#ff0204;}
</style>
