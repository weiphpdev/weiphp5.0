<template>
  <div class="active_lists">
    <scroller>
		<template v-if="!msg">
      <!-- 活动图 -->
      <activeBanner :activeInfo="activeInfo"></activeBanner>
      <activeGoods :activeData="activeData" activeType="拼团" :activeInfo="activeInfo" :activeTime="activeTime" v-if=activeData></activeGoods>
          <!--我的拼团-->

        </template>

    <div class="hint-page" v-else>
      <img src="~images/nothing.png" alt="">
      <p class="hint-page__text">{{msg}}</p>
    </div>
    </scroller>
    <div class="bottom-btn">
      <router-link class="my_collage" :to="'/collage/my_collage/' + activeInfo.id ">我的拼团</router-link>
      <!--<a class="my_collage" :href="'../my_collage/main?id=' + eventinfo.id ">我的拼团</a>-->
    </div>
  </div>
</template>

<script>
  import activeGoods from '@/components/activeGoods'
  import activeBanner from '@/components/activeBanner'
  import {post, host} from "@/utils"
  import navbar from "@/components/navbar";
  export default {
    data () {
      return {
        activeInfo: {},
        activeData: [],
        activeTime: '',
        msg: ''
      }
    },
    components: {
      activeGoods,
      activeBanner,
      navbar
    },
    methods: {
      // 发送请求
      getData (id) {
        post(host + "/collage/Api/index", {
          collage_id: id
        }).then((data) => {
          if(data.code == 0) {
            this.msg = data.msg
          } else {
            this.activeData = data.goods_lists
            this.activeInfo = data.event_info;
          }
      })
      },
      countTime: function () {
        var _this = this;
        // const endtime = Date.parse(new Date('2019-12-01'))
        const endtime = _this.activeInfo.end_time
        const msec = endtime - Date.parse(new Date()) / 1000;
        let d = parseInt(msec / 60 / 60 / 24);
        let h = parseInt(msec / 60 / 60 % 24);
        let m = parseInt(msec / 60 % 60);
        let s = parseInt(msec % 60);

        _this.activeTime = `${d}天${h}时${m}分${s}秒`
        setTimeout(function () {
          _this.countTime()
        }, 1000)
      }
    },
    created () {
      var id = this.$route.params.id;
      this.getData(id);
      this.countTime();
    }
  }
</script>
<style lang="scss" scoped>
	.hint-page {height: 60vh;}
    .bottom-btn{text-align:center;color:white;position:fixed;width:100%;bottom:0;display:inline-flex;z-index:2;}
    .my_collage{width:100%;height:100%;padding:10px 0;color:white;background:#ff0204;}
</style>
