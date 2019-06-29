<template>
  <div class="haggle active" v-if="eventinfo != null">
    <!-- 活动banner -->
    <activeBanner v-bind:active="active" v-bind:eventinfo="eventinfo"></activeBanner>
    <!-- 活动商品 -->
    <div class="active_goods">
      <div class="goods">
        <div class="active_img">
          <img class="good_img" v-bind:src='goods.cover'/>
        </div>
        <!-- 时间 -->
        <!--<count-down :target="eventinfo.end_time" :clear-timer="false"></count-down>-->
        <div class="active_time" v-if="cd.endtime > cd.nowtime && cd.nowtime > cd.starttime">剩余时间:{{cd.day}}天{{cd.hour}}小时{{cd.min}}分钟{{cd.sec}}秒</div>
        <div class="active_time active_timeout" v-else-if="cd.nowtime > cd.endtime">活动已结束</div>
        <div class="active_time active_not_begin" v-else>活动未开始</div>
        <!--商品信息-->
        <div class="active_good_detail">
          <div class="good_detail">
            <p class="title">{{goods.title}}</p>
            <p class="red active_price">
              <span class="price-icon">¥</span><strong>{{saleprice}}</strong>
              <small class="tag">{{active.name}}</small>
            </p>
            <p class="market_price" v-if="saleprice != eventinfo.market_price">
              <del><span class="prize-icon" >¥</span>{{eventinfo.market_price}}</del>
            </p>
          </div>
          <!--活动按钮-->
          <router-link class="active-btn" :to="'/haggle/detail/' + eventinfo.id" >{{active.name}}</router-link>
        </div>
      </div>
    </div>
  </div>
  <div class="active_end" v-else>
    <img src="~images/error.png"><br>
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
        cd: {day: 0, hour: 0, min: 0, sec: 0, starttime: 0, endtime: 0, nowtime: 0},
        eventinfo: {},
        goods: {},
        saleprice: 0.00,
        active: {name: '砍价', img: '~images/hagglebanner.jpg', url: '/haggle/detail/'}
      }
    },
    components: {
      activeBanner,
      activeContent
    },
    methods: {
      // 发送请求
      getData (id) {
        post(host + "/haggle/Api/index", {
          haggle_id: id,
          PHPSESSID: window.localStorage.getItem('PHPSESSID'),
        }).then((data) => {
          this.goods = data.goods;
          this.eventinfo = data.event_info;
          this.saleprice = data.sale_price;
          this.cd.endtime = data.event_info.end_time;
          this.cd.starttime = data.event_info.start_time
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
    created () {var id = this.$route.params.id;
      this.getData(id);
      this.countdown();
    }
  }
</script>
<style>
</style>
