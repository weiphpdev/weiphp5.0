<template>
  <div class="goods-detail">
    <!-- 商品图 -->
    <div class="slide">
      <swiper class="swiper" :indicator-dots="false" autoplay @change="toggleSwiper">
        <swiper-item v-for="(item, index) in slides" :key="index" @click="pvwImg(item)">
          <a class="slide-url">
            <img lazy-load :src="item" class="slide-image" mode="aspectFill">
          </a>
        </swiper-item>
      </swiper>
      <!-- 计数 -->
      <p class="slide-count">
        {{selfSwiperNum}}/
        <span class="s-gray">{{totalSwiperNum}}</span>
      </p>
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
    <van-popup class="hint-popup" :show="isPopup" @close="isPopup=false">
      <wxParse :content="activeInfo.content" @preview="preview" @navigate="navigate"/>
    </van-popup>

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
    <div class="goods-detail__pic" v-if="goods.goods.content">
      <wxParse :content="goods.goods.content" @preview="preview" @navigate="navigate"/>
    </div>
    <!-- 底部栏 -->
    <div class="bottom-bar">
      <button class="u-button u-button--square" @click="buy">立即秒杀</button>
    </div>
    <van-toast id="van-toast"/>
  </div>
</template>

<script>
import { post, host } from "@/utils";
import Toast from "@/../static/vant/toast/toast";
import wxParse from "mpvue-wxparse";

export default {
  mpType: 'page',
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
      isPopup: false
    };
  },
  components: {
    wxParse
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
    pvwImg(url) {
      // 预览图片
      const _this = this;
      wx.previewImage({
        current: url, // 当前显示图片的http链接
        urls: _this.slides // 需要预览的图片http链接列表
      });
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
      const _this = this;
      post("seckill/api/bug_now", {
        goods_id: this.goods.goods_id,
        PHPSESSID: wx.getStorageSync("PHPSESSID")
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
          activePrice: activePrice,
          PHPSESSID: wx.getStorageSync('PHPSESSID')
        };
        this.$store.commit("saveData", {
          key: "activeOrderParams",
          value: JSON.stringify(opt)
        });
        wx.navigateTo({
          url: "../../shop/confirm_order/index?goodsId=" + goods_id
        });

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

  onLoad() {
    const _this = this;
    console.log(this);
    const id = this.$mp.query.id;
    post("seckill/api/goods_detail", {
      PHPSESSID: wx.getStorageSync("PHPSESSID"),
      id: id
    }).then(res => {
      this.data = res;
      // 商品图
      this.slides = res.goods.goods.imgs_url;
      this.goods = res.goods;
      this.activeInfo = res.event_info;
    });
    this.countTime();
  }
};
</script>
<style lang="scss" scoped>
.goods-detail {
  padding-bottom: 55px;
  overflow: hidden;

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
    /deep/ .van-popup {
      padding: 10px;
      width: 80%;
      height: 60%;
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
    overflow: hidden;
    &,
    swiper,
    /deep/ image {
      height: 375px;
    }
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
    @extend .overflow-dot;
    white-space: normal;
  }
  /deep/ .u-goods__img {
    background-color: #ddd;
  }
}

.bottom-bar {
  display: flex;
  align-items: center;
  box-shadow: 1px 0 10px rgba(0, 0, 0, 0.1);
  position: fixed;
  bottom: 0;
  width: 100%;
  height: 45PX;
  background: #fff;
  max-width: 750px;
}
</style>
