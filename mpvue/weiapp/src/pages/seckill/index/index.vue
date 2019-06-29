<template>
	<div class="active_index">
		<!-- 活动图 -->
		<activeBanner :activeInfo="activeInfo"></activeBanner>

		<activeGoods :activeData="activeData" activeType="秒杀" :activeInfo="activeInfo" :activeTime="activeTime" v-if="activeData"></activeGoods>

		<div class="hint-page" v-else>
			<img lazy-load :src="imgRoot+'nothing.png'" alt="">
			<p class="hint-page__text">活动已到期</p>
		</div>
	</div>
</template>

<script>
	import activeGoods from '@/components/activeGoods'
	import activeBanner from '@/components/activeBanner'
	import {
		post,
		host
	} from "@/utils"
	export default {
		data() {
			return {
				activeInfo: {},
				activeData: [],
				activeTime: '',
				imgRoot: this.imgRoot
			}
		},
		components: {
			activeGoods,
			activeBanner
		},
		methods: {
			// 发送请求
			getData(id) {
				post(host + "/seckill/Api/index", {
					seckill_id: id
				}).then((data) => {
					this.activeData = data.goods_lists
					this.activeInfo = data.event_info;
				})
			},
			countTime: function() {
				var _this = this;
				// const endtime = Date.parse(new Date('2019-12-01'))
				const endtime = _this.activeInfo.end_time
				const msec = endtime - Date.parse(new Date()) / 1000;
				let d = parseInt(msec / 60 / 60 / 24);
				let h = parseInt(msec / 60 / 60 % 24);
				let m = parseInt(msec / 60 % 60);
				let s = parseInt(msec % 60);

				_this.activeTime = `${d}天${h}时${m}分${s}秒`
				setTimeout(function() {
					_this.countTime()
				}, 1000)
			}
		},
		onLoad() {
			const id = this.$mp.query.id;
			this.getData(id);
			this.countTime();
		}
	}
</script>
<style lang="scss" scoped>
	.hint-page {
		height: 60vh;
	}
</style>
