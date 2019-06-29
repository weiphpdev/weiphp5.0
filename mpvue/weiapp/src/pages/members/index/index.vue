<template>
  <div class="card-center">
    <div class="members-card" :style="{background: 'url('+config.background_url+')'}">
    <div class="members-card__item g-flex g-flex__updown-center">
        <img class="members-card__img" :src="info.headimgurl"/>
        <div>
        <p class="members-card__name">{{info.username}}</p>
        <p>{{info.score}}<span class="f-font-sm"> 积分1</span></p>
        </div>
    </div>
    <div class="members-card__item members-card__ft">
        <p class="members-card__type f-font-md">{{info.level_name || 'VIP会员'}}</p>
        <p class="members-card__type">NO:{{info.number}}</p>
    </div>
    </div>

    <div class="weui-grids">

    <a href="../../coupon/lists/index" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_2.png">
        </div>
        <p class="weui-grid__label">优惠劵</p>
    </a>
    <a href="../score_exchange/index" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_3.png">
        </div>
        <p class="weui-grid__label">积分兑换</p>
    </a>
    <div @click="isPopup=true" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_4.png">
        </div>
        <p class="weui-grid__label">会员特权</p>
    </div>

    <a href="../gift/index" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_6.png">
        </div>
        <p class="weui-grid__label">会员有礼</p>
    </a>
    <a href="../signin/index" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_7.png">
        </div>
        <p class="weui-grid__label">签到</p>
    </a>
    <a href="/" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_8.png">
        </div>
        <p class="weui-grid__label">商城中心</p>
    </a>
    <a href="../perfect_info/index" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_9.png">
        </div>
        <p class="weui-grid__label">完善资料</p>
    </a>
    <a href="../../shop/service/index" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_10.png">
        </div>
        <p class="weui-grid__label">客服</p>
    </a>
    <a href="../inform/index" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_11.png">
        </div>
        <p class="weui-grid__label">通知</p>
    </a>
    <div @click="isShowShare=true" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="./icon-members_12.png">
        </div>
        <p class="weui-grid__label">分享</p>
    </div>
    </div>
    
    <popupRight :popupData="privilegeData" :isPopup="isPopup" @closePopup="isPopup=false"></popupRight>
    <shareHint :isShow="isShowShare" @closeHint="isShowShare=false"></shareHint>
  </div>
</template>

<script>
import { post, host } from "@/utils";
import { api } from "@/utils/api";
import popupRight from "@/components/popupRight"
import shareHint from "@/components/shareHint"
export default {
  data() {
    return {
      datas: [],
      config: {},
      info: {},
      privilegeData: '',
      isPopup: false,
      isShowShare: false
    };
  },
  components: {
    popupRight,
    shareHint
  },
  computed: {
    
  },

  methods: {
    async getData() {
      const _this = this;
      const data = await api.getMemberCenter();
      this.info = data.info;
      this.config = data.config;
      this.privilegeData = data.config.privilege_intro;
    },
  },

  onLoad() {
    this.getData()
  }
};
</script>
<style lang="scss" scoped>
._v-container {padding-top: 0;}

// 会员卡
.members-card {
  position: relative;
    background-image: url("../get_card/bg-members.jpg");
    background-size: 100% 100%;
    height: 210px;
    margin: 15px;
    box-shadow: 0 0 10px hsla(0, 0%, 0%, 0.1);
    border-radius: 5px;
    color: #fff;
    padding: 15px;
    box-sizing: border-box;
    font-size: 14px;
    &__name {font-size: 17px}

    &__img {
      width: 50px;
      height: 50px;
      background: #eee;
      border-radius: 50%;
      margin-right: 15px;
      box-shadow: 0 0 0px 4px rgba(255, 255, 255, .2);
    }

    &__ft {
      position: absolute;
      bottom: 15px;
      right: 15px;
      text-align: right;
      font-size: 12px;
    }

}

.weui-grids {
  &:before,&:after,
  .weui-grid:before,
  .weui-grid:after {border: 0}

}
.weui-tabbar {
  background: #fff;
}

.weui-bar__item_on .weui-tabbar__label {color: $red}

.van-popup--right {
  width: 100%;
  height: 100%;
  padding: 15px;
  box-sizing: border-box;
  background: #f9f9f9;
}

.weui-grid__icon image {
  width: 54rpx;
  height: 54rpx;
}
.weui-grid,
.weui-grids,
.weui-grid:before,
.weui-grids:before,
.weui-grid:after,
.weui-grids:after,
 {
  border: 0
}
</style>
