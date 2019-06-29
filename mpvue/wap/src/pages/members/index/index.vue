<template>
  <div class="card-center">
    <scroller>
      <div class="members-card" :style="{cardBg}">
        <div class="members-card__item g-flex g-flex__updown-center">
          <img class="members-card__img" :src="info.headimgurl"/>
          <div>
            <p class="members-card__name">{{info.username || 'xxx'}}</p>
            <p>{{info.score || 0}}<span class="f-font-sm"> 积分</span></p>
          </div>
        </div>
        <div class="members-card__item members-card__ft">
          <p class="members-card__type f-font-md" :style="{color: config.title_color}">{{config.title || 'VIP会员'}}</p>
          <p class="members-card__type" :style="{color: config.number_color}">NO:{{info.number || 'xxxx'}}</p>
        </div>
      </div>

      <div class="weui-grids">
        <!-- <router-link to="" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_1.png">
            </div>
            <p class="weui-grid__label">销售记录</p>
        </router-link> -->
        <router-link to="/coupon/lists" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_2.png">
            </div>
            <p class="weui-grid__label">优惠劵</p>
        </router-link>
        <router-link to="/members/score_exchange" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_3.png">
            </div>
            <p class="weui-grid__label">积分兑换</p>
        </router-link>
        <div @click="isPopup=true" to="" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_4.png">
            </div>
            <p class="weui-grid__label">会员特权</p>
        </div>
        <!-- <router-link to="" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_5.png">
            </div>
            <p class="weui-grid__label">金生钱</p>
        </router-link> -->
        <router-link to="/members/gift" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_6.png">
            </div>
            <p class="weui-grid__label">会员有礼</p>
        </router-link>
        <router-link to="/members/signin" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_7.png">
            </div>
            <p class="weui-grid__label">签到</p>
        </router-link>
        <router-link to="/" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_8.png">
            </div>
            <p class="weui-grid__label">商城中心</p>
        </router-link>
        <router-link to="/members/perfect_info" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_9.png">
            </div>
            <p class="weui-grid__label">完善资料</p>
        </router-link>
        <router-link to="/service" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_10.png">
            </div>
            <p class="weui-grid__label">客服</p>
        </router-link>
        <router-link to="/members/inform" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_11.png">
            </div>
            <p class="weui-grid__label">通知</p>
        </router-link>
        <div @click="isShowShare=true" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="./icon-members_12.png">
            </div>
            <p class="weui-grid__label">分享</p>
        </div>
      </div>
    </scroller>
    
    <popupRight :popupData="privilegeData" :isPopup="isPopup" @closePopup="isPopup=false"></popupRight>
  </div>
</template>

<script>
import { post, host, goShare } from "@/utils";
import { api } from "@/utils/api";
import popupRight from "@/components/popupRight"
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
  },
  computed: {
    cardBg() {
			if(this.config.background_url) {
				return `background: url(${this.config.background_url})`
			}
		}
  },

  methods: {
    async getData() {
      const _this = this;
      const data = await api.getMemberCenter();
			// 没有领卡跳转
			if(data.redirect_code) {
				this.$router.push('/members/get_card')
				
				// 是否需要验证码,存入全局
				this.$store.commit('saveData', {
					isVerification: data.config.need_verify
				})
				
				return false
			}
      this.info = data.info;
      this.config = data.config;
      this.privilegeData = data.config.privilege_intro;
			
			var shareData = {
					title: '会员卡', // 分享标题
					desc: this.config.title, // 分享描述
					link: window.location.href, //分享的链接地址
					imgUrl: this.info.headimgurl, // 分享图标
					type: 'link', // 分享类型,music、video或link，不填默认为link
			};
			goShare(shareData)
    },
  },

  created() {
    this.getData()
  }
};
</script>
<style lang="scss" scoped>
.card-center {
	/deep/ ._v-container {padding-top: 0;}
	/deep/ ._v-container > ._v-content {
		padding-bottom: 0;
	}
}
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
</style>
