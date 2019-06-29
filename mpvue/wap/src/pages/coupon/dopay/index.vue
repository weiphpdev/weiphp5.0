<template>
  <div class="coupon-show">
    <scroller>
      <template v-if="!isDopay">
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
              <p
                class="coupon-item__time"
              >{{startTime || "2018.11.11"}} - {{endTime || "2018.11.11"}}</p>
            </div>
          </div>
        </div>

        <!-- 使用说明 -->
        <div class="page-block" v-if="info.use_tips">
          <p style="margin-bottom:15px">会员名称：{{data.info.uid}}</p>
          <h4 class="page-tt">优惠券使用说明</h4>
          <div class="page-content" v-html="info.use_tips"></div>
        </div>
      </template>

      <template v-else>
       <div class="hint-page">
        <i class="weui-icon-success weui-icon_msg"></i>
        <p class="hint-page__text">核销成功</p>
      </div>
      </template>
    </scroller>
    <div class="u-button__bar">
      <button @click="dopay" v-if="!isDopay" class="u-button u-button--square">立即核销</button>
      <router-link to="/center" v-else class="u-button u-button--square">返回个人中心</router-link>
    </div>
  </div>
</template>
  
<script>
import { get, timeChange, host } from "@/utils";

import navbar from "@/components/navbar";
import {Toast} from "vant";
let qrcode;
export default {
  data() {
    return {
      tabActive: 0,
      data: [],
      info: {},
      isDopay: false,
      id: 0
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
    dopay () {
      get(`coupon/api/do_pay_ok/sn_id/${this.id}/PHPSESSID/${window.localStorage.getItem('PHPSESSID')}`).then(res => {
        if(res.msg.includes("成功")) {
          this.isDopay = true
        } else {
          Toast(res.msg)
        }
      })
    }
  },
  created () {
    this.id = this.$route.params.id || 12;
    get(`coupon/api/do_pay/sn_id/${this.id}/PHPSESSID/${window.localStorage.getItem('PHPSESSID')}`).then(res => {
      console.log('res为',res)
      this.data = res
      this.info = res.coupon
    })
  }
};
</script>


<style lang="scss" scoped>
.coupon-show {
  margin-bottom: 45px;
  background: #fff;
  padding-bottom: 20px;
  /deep/ .u-button--square {
    @extend .g-flex-center;
  }
  /deep/ ._v-container {
    padding-top:0
  }

  .weui-icon_msg {
    font-size: 80px;
    color: $red;
  }
  .hint-page {
    height: 60vh;
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
  min-height: 200px;
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
