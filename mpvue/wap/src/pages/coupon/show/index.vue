<template>
  <div class="coupon-show">
    <navbar text="优惠卷" jumpUrl="/center"></navbar>
    <scroller>
    <template v-if="!data.error">
      <!-- 优惠卷图片 -->
      <img v-if="info.background_img" class="coupon-img" :src="info.background_img">

      <div class="coupon-not" v-cloak>
        <div class="coupon-item">
          <!-- 金额 -->
          <div class="coupon-item__l">
            <span class="coupon-item__price">{{info.money || 100}}</span>
            <span class="f-font-sm">元</span>
          </div>

          <!-- 满减 -->
          <div class="coupon-item__c">
            <p>{{info.title || "优惠卷"}}</p>
            <p class="coupon-item__time">{{startTime || "2018.11.11"}} - {{endTime || "2018.11.11"}}</p>
          </div>
        </div>
      </div>
      <div class="qrcode-box" v-if="sn.is_use == 0">
        <svg class="barcode" id="barcode" ref="barcode"></svg>
        <div class="qrcode" id="qrcode" ref="qrcode"></div>
        <p class="qrcode-hint">如果线下门店使用，将本页面展示给商家即可使用</p>
      </div>

      <div class="hint-page" v-else>
        <i class="weui-icon-success weui-icon_msg"></i>
        <p class="hint-page__text">已使用该优惠券</p>
      </div>
      <!-- 使用说明 -->
      <div class="page-block" v-if="info.use_tips">
        <h4 class="page-tt">优惠券使用说明</h4>
        <div class="page-content" v-html="info.use_tips"></div>
      </div>

      
    </template>

    <template v-else>
      <div class="hint-page">
        <img src="~images/coupon_error.png">
        <p class="hint-page__text">{{data.error}}</p>
      </div>
    </template>
    </scroller>
    <div class="u-button__bar">
        <router-link to="/coupon/lists" class="u-button u-button--square">查看更多优惠券</router-link>
      </div>

  </div>
</template>
  
<script>
import { get, timeChange, host } from "@/utils";
import navbar from "@/components/navbar";
import QRCode from "qrcodejs2";
var JsBarcode = require("jsbarcode");
let qrcode;
export default {
  data() {
    return {
      tabActive: 0,
      data: [],
      info: {},
      sn: {},
      apiUrl: ""
    };
  },
  computed: {
    startTime() {
      return timeChange(this.info.end_time, true);
    },
    endTime() {
      return timeChange(this.info.end_time, true);
    }
  },

  components: {
    navbar
  },

  methods: {
    qrcode() {
      const _this = this;
      console.log('qrcode', qrcode)
      if(!qrcode) {
        qrcode = new QRCode("qrcode", {
          width: 200, // 设置宽度
          height: 200, // 设置高度
          // text: host + `coupon/wap/do_pay/sn_id/${_this.sn.id}`
          text: `${window.location.href.split('coupon')[0]}coupon/dopay/${_this.sn.id}`
        });
      }
      
    },
    setData(res) {
      const _this = this;
      this.data = res;
      this.info = res.data;
      this.sn = res.sn;
      this.$nextTick(() => {
        this.qrcode();
        JsBarcode("#barcode", _this.sn.sn, { barWidth: 2, barHeight: 50 });
      });
      
    }
  },
  activated() {
    if (!this.$route.meta.isBack) {
      const _this = this;
      let apiUrl = this.$route.params.str;
      get(apiUrl).then(res => {
        console.log(res);
        // 第一次领取
        if (res.url) {
          apiUrl =
            res.url.split("index.php/")[1] +
            "/PHPSESSID/" +
            window.localStorage.getItem("PHPSESSID");
          get(apiUrl).then(data => {
            _this.setData(data);
          });
        } else {
          _this.setData(res);
        }
      });
    }
    // 恢复成默认的false，避免isBack一直是true，导致下次无法获取数据
    this.$route.meta.isBack = false;
  }
};
</script>


<style lang="scss" scoped>
.coupon-show {
  margin-top: 45px;
  margin-bottom: 45px;
  background: #fff;
  padding-bottom: 20px;
  /deep/ .u-button--square {
    @extend .g-flex-center;
  }
  /deep/ ._v-container > ._v-content {padding-bottom: 90px;}

  .weui-icon_msg {
    font-size: 80px;
    color: $red;
  }
  .hint-page {
    height: 30vh;
    &__text {
      font-size: 14px;
    }
    img,
    image {
      height: auto;
      width: 30%;
    }
  }
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

.qrcode-box {
  margin: 5vh 0;
  @extend .g-flex-center;
  flex-direction: column;
  .barcode {
    width: 100%;
    min-height: 120px;
  }
}
.qrcode {
  min-height: 200PX;
  overflow: hidden;
  margin: 10px auto 15px;
}
.qrcode-hint {
  font-size: 12px;
  margin: 0 auto;
}

.page-block {
  padding: 15px;
  margin-top: 50px;
}
.page-tt {
  margin-bottom: 15px;
}
</style>
