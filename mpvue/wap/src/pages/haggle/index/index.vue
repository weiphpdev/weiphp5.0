<template>
  <div class="active_index">
    <scroller>
    <!-- 活动图 -->
    <activeBanner :activeInfo="activeInfo"></activeBanner>
    <div class="active-goods" v-if="!msg">
			<div class="active-goods__item">
				<div class="active-goods__img">
					<img :src="activeData.cover" alt="">
					<div class="u-time-bar" v-if="activeTime">剩余时间{{activeTime}}</div>
					<div class="u-time-bar due" v-else>活动已到期</div>
				</div>

				<div class="active-goods__content">
					<div class="active-goods__left">
						<p class="active-goods__tt u-goods__tt overflow-dot">{{activeData.title}}</p>
						<p class="active-goods__price s-red"><span class="f-mr-xs">¥</span>{{activeData.sale_price}}
							<span class="u-badge u-badge--sm">砍价</span>
						</p>
						<p class="active-goods__price_cost"><span class="f-mr-xs">¥</span>{{activeData.market_price}}</p>
					</div>

					<router-link :to="'/haggle/detail/' + activeInfo.id" class="u-button u-button--primary" v-if="activeTime">砍价</router-link>
					<button class="u-button u-button--disable2" v-else>砍价</button>
				</div>

			</div>
		</div>

		<div class="hint-page" v-else>
		<img src="~images/nothing.png" alt="">
			<p class="hint-page__text">活动不存在或者已过期</p>
		</div>
	</scroller>

  </div>

</template>

<script>
import activeGoods from "@/components/activeGoods";
import activeBanner from "@/components/activeBanner";
import { post, host } from "@/utils";
import navbar from "@/components/navbar";
export default {
  data() {
    return {
      activeInfo: {},
      activeData: [],
      activeTime: "",
      msg: ""
    };
  },
  components: {
    activeGoods,
    activeBanner,
    navbar
  },
  methods: {
    // 发送请求
    getData(id) {
      post("/haggle/Api/index", {
        haggle_id: id
      }).then(data => {
        if (data.code == 0) {
          this.msg = data.msg;
        } else {
          this.activeData = data.goods;
          this.activeInfo = data.event_info;
        }
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
    }
  },
  created() {
    var id = this.$route.params.id;
    this.getData(id);
    this.countTime();
  }
};
</script>
<style lang="scss" scoped>
.hint-page {
  height: 60vh;
}
.active-goods {
		&__item {
			margin: 15px;
			margin-bottom: 0;
			background: #fff;
			border-radius: 5px;
		}

		.u-badge {
			display: inline;
		}

		// 商品图
		&__img {
			position: relative;
			min-height: 200px;
			overflow: hidden;

			img {
				position: absolute;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				margin: auto;
			}
		}

		// 内容
		&__content {
			padding: 15px;
			display: flex;
			align-items: center;
		}

		&__left {
			flex: 1
		}

		&__tt {
			margin-bottom: 10px;
		}

		&__price_cost {
			font-size: 12px;
			text-decoration: line-through;
			color: #aaa;
		}
	}
</style>
