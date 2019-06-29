<template>
  <div class="coupon-get">
    <navbar text="领取优惠卷"></navbar>
    <scroller v-if="data.info.id">
    <div class="coupon-not" v-if="info" v-cloak>
      <!-- 优惠卷图片 -->
      <img v-if="info.background_img" class="coupon-img" :src="info.background_img">

      <div class="coupon-item">
        <!-- 金额 -->
        <div class="coupon-item__l">
          <span class="coupon-item__price">{{info.money}}</span>
          <span class="f-font-sm">元</span>
        </div>

        <!-- 满减 -->
        <div class="coupon-item__c">
          <p>{{info.title}}</p>
          <p class="coupon-item__time">{{startTime}}-{{endTime}}</p>
        </div>
      </div>
    </div>

    <!-- 使用说明 -->
    <div class="page-block" v-if="info">
      <h4 class="page-tt">优惠券使用说明</h4>
      <div class="page-content" v-if="info" v-html="info.use_tips"></div>
    </div>
    </scroller>

    <div class="u-button__bar" v-if="info">
      <button class="u-button u-button--square" @click="getCoupon">立即领取</button>
    </div>
  </div>
</template>

<script>
import { post, get, timeChange } from "@/utils";
import navbar from "@/components/navbar";
import { Toast } from "vant";
export default {
  data() {
    return {
      data: [],
      info: []
    };
  },
  computed: {
    startTime() {
      return timeChange(this.info.use_start_time, true);
    },
    endTime() {
      return timeChange(this.info.use_start_time, true);
    }
  },

  components: {
    navbar
  },

  methods: {
    getCoupon() {
      // 解析跳转的url，set_sn_code
      let apiUrl =
        this.data.jumpURL.split("index.php/")[1] +
        "/PHPSESSID/" +
        window.localStorage.getItem("PHPSESSID");
      // 判断是否领取成功
      get(apiUrl).then(res => {
        if (res.code == 0) {
          Toast(res.error);
        } else {
          Toast.success("领取优惠劵成功");
          apiUrl =
            res.url.split("index.php/")[1] +
            "/PHPSESSID/" +
            window.localStorage.getItem("PHPSESSID");
         this.$router.push({ name: "coupon_show", params: { str: apiUrl } });
        }
      });
    }
  },

  created() {
    let id = this.$route.params.id;
    console.log("id为", id);
    post("coupon/api/index", {
      PHPSESSID: window.localStorage.getItem("PHPSESSID"),
      id: id
    }).then(res => {
      this.data = res;
      this.info = res.info;
      // 已经领取过了,返回的接口是带show
      if (res.url) {
        let apiUrl =
          res.url.split("index.php/")[1] +
          "/PHPSESSID/" +
          window.localStorage.getItem("PHPSESSID");
        this.$router.push({ name: "coupon_show", params: { str: apiUrl } });
      }
    });
  }
};
</script>

<style lang="scss" scoped>
.coupon-get {
  margin-top: 45px;
  margin-bottom: 45px;
  background: #fff;
  /deep/ ._v-container > ._v-content {padding-bottom: 90px;}
  .coupon-img {
    height: 200px;
    width: 100%;
  }
  .coupon-not {
    padding-top: 1px;
  }
}
.page-block {
  padding: 15px;
  margin-top: 50px;
}
.page-tt {
  margin-bottom: 15px;
}
</style>
