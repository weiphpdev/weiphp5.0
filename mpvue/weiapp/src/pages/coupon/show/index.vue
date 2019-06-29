<template>
  <div class="coupon-show">
    <template v-if="!data.error">
      <!-- 优惠卷图片 -->
      <img lazy-load v-if="info.background_img" class="coupon-img" :src="info.background_img">

      <div class="coupon-not">
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
        <canvas class="canvas barcode" canvas-id="barcode"></canvas>
        <canvas class="canvas qrcode" style="width: 200px;height;200px" canvas-id="qrcode" @longtap="jumpUrl"></canvas>
        
        <p class="qrcode-hint">如果线下门店使用，将本页面展示给商家即可使用</p>
      </div>

      <div class="hint-page" v-else>
        <van-icon name="checked" size="5em" color="red" />
        <p class="hint-page__text">已使用该优惠券</p>
      </div>
      <!-- 使用说明 -->
      <div class="page-block" v-if="info">
        <h4 class="page-tt">优惠券使用说明</h4>
        <div v-html="couponDetail"></div>
    </div>

      <div class="u-button__bar">
        <a href="../lists/index" class="u-button u-button--square">查看更多优惠券</a>
      </div>
    </template>

    <template v-else>
      <div class="hint-page">
        <img lazy-load :src="imgRoot+'error.png'">
        <p class="hint-page__text">{{data.error}}</p>
      </div>
    </template>
  </div>
</template>
  
<script>
import { get, timeChange, host } from "@/utils";
import wxbarcode from 'wxbarcode';
import wxParse from "mpvue-wxparse";
export default {
  data() {
    return {
			imgRoot: this.imgRoot,
      tabActive: 0,
      data: [],
      info: {},
      sn: {},
      apiUrl: ""
    };
  },
  components: {
    wxParse
  },
  computed: {
    startTime() {
      if(this.info) {
      let startTime = this.info.start_time || new Date().getTime()
      return timeChange(startTime, true);
      }
    },
    endTime() {
      if(this.info) {
      let endTime = this.info.end_time || new Date().getTime()
      return timeChange(endTime, true);
      }
    },
    couponDetail() {
      return String(this.info.use_tips).replace(/\<img/gi, '<img lazy-load style="width:100%;height:auto" ')
    }
  },

  components: {},

  methods: {
    jumpUrl() {
      console.log('长按了')
      wx.switchTab({'url': '../dopay/index?id=' + this.sn.id})
    },
    setData(res) {
      console.log("这是res", res);
      this.data = res;
      this.info = res.data;
      this.sn = res.sn;

      wxbarcode.barcode('barcode', this.sn.sn, 600, 100);
      wxbarcode.qrcode('qrcode', '1234567890123456789', 400, 400);
    }
  },
  onLoad() {
    const _this = this;
    let apiUrl = this.$mp.query.str;
    get(apiUrl).then(res => {
      console.log(res);
      // 第一次领取
      if (res.url) {
        console.log("第一次领取");
        apiUrl =
          res.url.split("index.php/")[1] +
          "/PHPSESSID/" +
          wx.getStorageSync("PHPSESSID");
        get(apiUrl).then(data => {
          _this.setData(data);
        });
      } else {
        _this.setData(res);
      }
    });
    
    
  }
};
</script>


<style lang="scss" scoped>
.coupon-show {
  margin-bottom: 45px;
  background: #fff;
  /deep/ .u-button--square {
    @extend .g-flex-center;
  }

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

.qrcode-box {
  @extend .g-flex-center;
  flex-direction: column;
  .barcode {
    height: 50px;
    margin: 15px auto 0;
  }
}
.qrcode {
  min-height: 200px;
  overflow: hidden;
  margin: auto;
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
