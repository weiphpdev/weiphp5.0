<template>
  <div class="gift">
    <navbar text="会员有礼"></navbar>

    <scroller>
      <van-collapse v-model="activeNames">
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
          <button v-if="item.is_send==0" class="u-button u-button--primary" @click="doGet(item.id,item.title)">领取</button>
          <button v-if="item.is_send==1" class="u-button u-button--primary disable">已领取</button>
        </van-collapse-item>
      </van-collapse>
    </scroller>
  </div>
</template>

<script>
import { post, host } from "@/utils";
import { api } from "@/utils/api";
import navbar from "@/components/navbar";
import { Collapse, CollapseItem } from "vant";
export default {
  data() {
    return {
      datas: [],
      activeNames: []
    };
  },
  components: {
    navbar
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
    // 签到
    async doGet(id, title) {
      console.log('===doGet==')
			console.log(id)
				post("card/api/get_privilege", {
					id: id,title:title
				}).then(data => {
					// 商品图
					if(data.code == 0) {
						Toast.fail(data.msg);
					} else {
						Toast.success(data.msg);
					}
				});			
    }		
  },

  created() {
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
