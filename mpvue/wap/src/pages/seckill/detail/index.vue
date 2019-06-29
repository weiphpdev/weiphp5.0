<template>
  <div class="goods-detail">
    <navbar :text="goods.title"></navbar>

    <scroller v-if="goods.id">
      <!-- 商品图 -->
      <div class="slide">
        <van-swipe show-indicators @change="toggleSwiper">
          <van-swipe-item v-for="(item,index) in slides" :key="index">
            <a class="slide-url pic-align-center" @click="pvwImg(index)">
              <lazy-component>
                <img class="slide-image" mode="aspectFill" v-lazy="item">
              </lazy-component>
            </a>
          </van-swipe-item>
          <div class="custom-indicator" slot="indicator">{{ current + 1 }}/{{slides.length}}</div>
        </van-swipe>
        <div class="u-time-bar" v-if="activeTime">距结束还有 {{activeTime}}</div>
        <div class="u-time-bar due" v-else>活动已到期</div>
      </div>

      <!-- 商品信息 -->
      <div class="goods-detail__info">
        <p class="goods-detail__price s-red">
          <span class="icon-price">¥</span>
          {{goods.sale_price}}
        </p>
        <p
          class="goods__price-cost"
          v-if="goods.market_price>goods.sale_price"
        >¥{{goods.market_price}}</p>
        <p class="u-float-r u-badge u-badge--xs">秒杀</p>
        <p class="active-hint" @click="isPopup = !isPopup">
          <span class="iconfont icon-gantanhao"></span>活动说明
        </p>
        <p class="goods-detail__tt">{{goods.title}}</p>
      </div>

      <div @click="jump(goods.id, goods.tab)" class="m-list link g-flex" v-if="goods.tab">
        <div class="m-list__l g-flex__item">同款</div>
        <i class="iconfont icon-fanhui right"></i>
      </div>

      <!-- switch卡片 -->
      <div class="switch-card" v-if="goods.goods_param">
        <div class="switch-card__hd">
          <p class="switch-card__tt">产品参数</p>
          <p class="switch-card__icon iconfont icon-fanhui" :class="arrowDir" @click="toggleArrow"></p>
        </div>
        <div class="switch-card__bd" v-show="arrowDir == 'top'">
          <div
            class="switch-card__item"
            v-for="(param, paramIdx) in goods.goods_param"
            :key="paramIdx"
          >
            <p class="switch-card__param overflow-dot_row">{{param.title}}</p>
            <p class="switch-card__attr overflow-dot_row">{{param.param_value}}</p>
          </div>
        </div>
      </div>

      <!-- 详情图片 -->
      <div class="goods-detail__pic" v-if="goods">
        <div v-html="goodsDetail"></div>
      </div>
    </scroller>
    <!-- 底部栏 -->
    <div class="u-button__bar">
      <button class="u-button u-button--square" @click="buy">立即秒杀</button>
    </div>

    <van-popup class="hint-popup" v-model="isPopup">
      <div class="hint-popup__box" v-if="activeInfo.content" v-html="activeInfo.content"></div>
    </van-popup>
  </div>
</template>

<script>
import { post, host } from "@/utils";
import navbar from "@/components/navbar";
import { ImagePreview, Toast, Popup } from "vant";
export default {
  data() {
    return {
      data: [],
      current: 0,
      slides: [],
      goods: [],
      arrowDir: "top",
      selfSwiperNum: 1,
      detailPic: "",
      activeInfo: [],
      activeTime: "",
      isPopup: false,
      goodsDetail: ""
    };
  },
  components: {
    navbar
  },
  computed: {
    totalSwiperNum() {
      return this.slides.length;
    }
  },

  methods: {
    toggleSwiper(index) {
      this.current = index;
    },
    countTime: function() {
      var _this = this;
      // const endtime = Date.parse(new Date('2019-12-01'))
      const endtime = _this.activeInfo.end_time;
      const msec = endtime - Date.parse(new Date()) / 1000;
      let d = parseInt(msec / 60 / 60 / 24);
      let h = parseInt((msec / 60 / 60) % 24);
      let m = parseInt((msec / 60) % 60);
      let s = parseInt(msec % 60);
      _this.activeTime = `${d}天${h}时${m}分${s}秒`;
      setTimeout(function() {
        _this.countTime();
      }, 1000);
    },
    jump(ids, tabs) {
      this.$router.push({ name: "lists", params: { id: ids, tab: tabs } });
    },
    // 购买
    buy() {
      post("seckill/api/bug_now", {
        PHPSESSID: window.localStorage.getItem("PHPSESSID"),
        goods_id: this.goods.goods_id
      }).then(res => {
        console.log(res);
        if (res.msg != "") {
          Toast(res.msg);
          return false;
        }
        //    解析url
        let reg = /event_type\/(\d+)\/event_id\/(\d+)\/shop_order_id\/(\d+)\/pbid\/(\d+)/.exec(
          res.url
        );
        console.log(reg);
        let event_type = reg[1];
        let event_id = reg[2];
        let shop_order_id = reg[3];
        let pbid = reg[4];
        let goods_id = this.goods.shop_goods_id;
        let activePrice = this.goods.sale_price;

        let opt = {
          event_type: event_type,
          event_id: event_id,
          shop_order_id: shop_order_id,
          pbid: pbid,
          goods_id: goods_id,
          activePrice: activePrice
        };
        this.$store.commit("saveData", {
          key: "activeOrderParams",
          value: JSON.stringify(opt)
        });

        this.$router.push("/confirm_order/" + goods_id);
      });
    },
    // 切换箭头方向
    toggleArrow() {
      this.arrowDir == "top"
        ? (this.arrowDir = "bottom")
        : (this.arrowDir = "top");
    },
    pvwImg(idx) {
      // 预览图片
      ImagePreview({
        images: this.slides,
        startPosition: idx
      });
    }
  },

  created() {
    const _this = this;
    const id = this.$route.params.id;
    post("seckill/api/goods_detail", {
      id: id
    }).then(res => {
      if(res.code==0 && res.msg != ''){
         Toast(res.msg);
          return false;
      }
      this.data = res;
      // 商品图
      this.slides = res.goods.goods.imgs_url;
      this.goods = res.goods;
      this.goodsDetail = res.goods.goods.content;
      this.activeInfo = res.event_info;
    });
    this.countTime();
  }
};
</script>
<style lang="scss" scoped>
@import "../../../../static/styles/mixin.scss";
.navbar {
  background: $body-bg;
}

.goods-detail {
  padding-top: 45px;
  padding-bottom: 55px;
  overflow: hidden;
  /deep/ ._v-container > ._v-content {padding-bottom: 90px;}

  .active-hint {
    color: #aaa;
    &,
    .iconfont {
      font-size: 12px;
    }
    .iconfont {
      margin-right: 4px;
    }
  }

  .hint-popup {
    border-radius: 0;
    padding-bottom: 0;
    width: 80%;
    height: 60%;
    &__box {
      padding: 10px;
      height: 100%;
      padding: 10px;
      box-sizing: border-box;
      overflow-y: scroll;
      -webkit-overflow-scrolling: touch;
      /deep/ img,
      image {
        width: 100% !important;
      }
    }
  }

  .van-swipe {
    position: relative;
    height: 10rem;
  }
  .custom-indicator {
    position: absolute;
    right: 10px;
    bottom: 45px;
  }
  /deep/ .icon-fanhui {
    font-size: 14px;
  }
  &__pic {
    background: #fff;
    font-size: 14px;
    margin-top: 15px;
    /deep/ p {
      padding: 10px;
    }
    /deep/ table,
    /deep/ img {
      width: 100%;
    }
  }

  .slide {
    position: relative;
    height: 375px;
    overflow: hidden;
    &-count {
      position: absolute;
      right: 10px;
      bottom: 10px;
      .s-gray {
        font-size: 12px;
      }
    }
    .slide-url {
      background: #fff;
    }
  }

  // 商品信息
  &__info {
    padding: 18px;
    background: #fff;
  }
  &__price {
    font-size: 20px;
    margin-right: 5px;
  }
  &__price,
  .goods__price-cost {
    display: inline-block;
  }

  &__tt {
    font-size: 16px;
  }
  &__cell {
    display: block;
  }
  &__tt,
  &__cell {
    margin-top: $box-size;
  }

  // 库存
  &__stock {
    font-size: 12px;
    display: inline-block;
    float: right;
    margin-top: 10px;
  }
}

// 商品评价
.goods-comment {
  margin-top: $box-size;
  background: #fff;
  &__bd {
    padding: 10px 15px;
    white-space: nowrap;
    width: 100%;
    display: block;
    overflow-x: scroll;
    box-sizing: border-box;
    -webkit-overflow-scrolling: touch;
  }
  &__item {
    display: -webkit-inline-box;
    align-items: center;
    border: 1px solid #ececec;
    width: 300px;
    margin-right: 10px;
    overflow: hidden;
    border-radius: 3px;
    height: 130px;
    &:last-child {
      margin-right: 0;
    }
  }
  &__left {
    margin: 15px 10px 15px;
    flex: 1;
  }
  &__right {
    background: #f9f9f9;
    padding: 15px 10px;
  }
  &__name {
    font-size: 14px;
    margin-left: 5px;
  }
  &__text {
    margin-top: 10px;
    font-size: 14px;
    @include overflow-dot(3);
    white-space: normal;
  }
  /deep/ .u-goods__img {
    background-color: #ddd;
  }
}
</style>
