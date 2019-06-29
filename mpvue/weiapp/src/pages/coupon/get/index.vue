<template>
  <div class="coupon-get">
    <div class="coupon-not" v-if="info">
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
      <div v-html="couponDetail"></div>
    </div>

    <div class="u-button__bar" v-if="info">
      <button class="u-button u-button--square" @click="getCoupon">立即领取</button>
    </div>
  </div>
</template>

<script>
import { post, get, timeChange } from "@/utils";
import wxParse from "mpvue-wxparse";

export default {
  data() {
    return {
      data: [],
      info: []
    };
  },
  components: {
    wxParse
  },
  computed: {
    startTime() {
      if (this.info) {
        let startTime = this.info.start_time || new Date().getTime();
        return timeChange(startTime, true);
      }
    },
    endTime() {
      if (this.info) {
        let endTime = this.info.end_time || new Date().getTime();
        return timeChange(endTime, true);
      }
    },
    couponDetail() {
      return String(this.info.use_tips).replace(/\<img/gi, '<img lazy-load style="width:100%;height:auto" ')
    }
  },

  components: {},

  methods: {
    getCoupon() {
      const _this = this;
      // 解析跳转的url，set_sn_code
      let apiUrl =
        this.data.jumpURL.split("index.php/")[1] +
          "/PHPSESSID/" +
          wx.getStorageSync("PHPSESSID") || "";
      // 判断是否领取成功
      get(apiUrl).then(res => {
        if (res.code == 0) {
          wx.showToast({ title: "成功", icon: res.error });
        } else {
          apiUrl =
            res.url.split("index.php/")[1] +
            "/PHPSESSID/" +
            wx.getStorageSync("PHPSESSID");
          wx.redirectTo({ url: "../show/index?str=" + apiUrl });
        }
      });
    }
  },

  onLoad() {
    let id = this.$mp.query.id;
    console.log("id为", id);
    post("coupon/api/index", {
      PHPSESSID: wx.getStorageSync("PHPSESSID"),
      id: id
    }).then(res => {
      this.data = res;
      this.info = res.info;
      // 已经领取过了,返回的接口是带show
      if (res.url) {
        let apiUrl =
          res.url.split("index.php/")[1] +
          "/PHPSESSID/" +
          wx.getStorageSync("PHPSESSID");

        wx.redirectTo({ url: "../show/index?str=" + apiUrl });
      }
    });
  }
};
</script>

<style lang="scss" scoped>
.coupon-get {
  margin-bottom: 45px;
  background: #fff;
  .coupon-img {
    min-height: 200px;
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
