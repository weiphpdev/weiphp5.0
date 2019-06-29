<template>
  <div class="gift">

      <van-collapse :value="activeNames" @change="onChange">
        <van-collapse-item
          :title="item.title"
          :name="index"
          icon="point-gift-o"
          v-for="(item,index) in datas"
          :key="index"
        >
          <div class="g-flex__item">
            <p>赠送时间：{{item.start_time}}-{{item.end_time}}</p>
            <p>{{item.type}}</p>
            <p>描述：{{item.content}}</p>
          </div>
          <button v-if="item.is_send==0" class="u-button u-button--primary">领取</button>
          <button v-else class="u-button u-button--primary disable">已领取</button>
        </van-collapse-item>
      </van-collapse>
  </div>
</template>

<script>
import { post, host } from "@/utils";
import { api } from "@/utils/api";

export default {
  data() {
    return {
      datas: [],
      activeNames: []
    };
  },
  components: {
  },
  computed: {},

  methods: {
    async getData() {
      const _this = this;
      const data = await api.getGiftInfo();
      this.datas = data.list_data;
      this.datas.map(item => {
        _this.activeNames.push(0);
      });
    },
		onChange (e) {
			console.log(e)
		}
  },

  onLoad() {
		Object.assign(this, this.$options.data());
    this.getData();
  }
};
</script>
<style lang="scss" scoped>
.gift {
  /deep/ .van-icon-point-gift-o:before {
    color: $red;
  }
  .van-collapse-item {
    margin-bottom: 10px;
  }

  /deep/ .van-collapse-item__content {
    display: flex;
    align-items: flex-end;
    color: #333;
  }
  .u-button.disable {
    opacity: 1;
    background: #eee;
  }
}
</style>
