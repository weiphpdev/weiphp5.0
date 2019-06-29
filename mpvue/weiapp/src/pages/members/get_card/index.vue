<template>
  <div class="get-card">
      <div class="members-card" :style="{background: 'url('+config.background_url+')'}">
        <p :style="{color: config.title_color}">{{config.title}}</p>
      </div>

      <router-link to="/members/write_info" class="u-button u-button--primary u-button--big">立即领卡</router-link>
      <button @click="isPopup=true" href class="u-button u-button--primary u-button--big u-button--disable">会员特权</button>

    <popupRight :isPopup="isPopup" :popupData="config.privilege_intro" @closePopup="isPopup=false">
		</popupRight>
  </div>
</template>

<script>
import { post, host } from "@/utils";
import { api } from "@/utils/api";
import popupRight from "@/components/popupRight";
export default {
  data() {
    return {
      datas: [],
      config: {},
      isPopup: false
    };
  },
  components: {
    popupRight
  },
  computed: {},

  methods: {
    async getData() {
      const _this = this
      const data = await api.getCard()
      _this.config = data.config
    }
  },

  onLoad() {
    this.getData()
  }
};
</script>
<style lang="scss" scoped>
// 会员卡
.members-card {
    background-image: url("./bg-members.jpg");
    background-size: 100% 100%;
    height: 210px;
    margin: 15px;
    @extend .g-flex-center;
    font-size: 24px;
    box-shadow: 0 0 10px hsla(0, 0%, 0%, 0.1);
    border-radius: 10px;
    color: #fff;
}

.get-card {
  .u-button--disable {
    color: $red;
    margin-top: 0;
  }
}

</style>
