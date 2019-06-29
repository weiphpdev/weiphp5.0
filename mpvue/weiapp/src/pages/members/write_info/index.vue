<template>
	<div class="write-info">
		<div class="form" v-show="!next">
			<div class="form-item">
				<input v-model="formData.phone" @input="verifyInput" type="number" class="form-item__input" placeholder="手机号">
			</div>
<!-- 			<div class="form-item form-item_verify" v-if="isVerification">
				<input v-model="verifyCode" type="text" class="form-item__input" placeholder="输入验证码">
				<button class="form-item__btn" :class="{disable: isInputVerifyCode}" @click="getVerifyCode">{{verifyCodeBtnText}}</button>
			</div> -->
			<button v-if="!isInputSuccess" class="u-button u-button--primary u-button--big disable">下一步</button>
			<button v-else @click="nextAtion" class="u-button u-button--primary u-button--big">下一步</button>
		</div>
			


		<form class="form" v-show="next">
			<div class="form-item">
				<label for="" class="form-item__label"><span class="form-item__required">*</span>姓名</label>
				<input v-model="formData.username" type="text" class="form-item__input" placeholder="请输入姓名">
			</div>
				<div class="form-item">
					<label for="" class="form-item__label"><span class="form-item__required">*</span>性别</label>
					<van-radio-group :value="formData.sex" @change="toggleSex">
						<van-radio :name="1" checked-color="#ff0204">男</van-radio>
						<van-radio :name="2" checked-color="#ff0204">女</van-radio>
					</van-radio-group>
					</van-radio-group>
				</div>

				<div class="form-item" @click="openPopup('isDatePopup')">
					<label for="" class="form-item__label"><span class="form-item__required">*</span>出生年月</label>
					<input v-model="formData.birthday" disabled type="text" class="form-item__input" placeholder="请输入出生年月">
				</div>
				<div class="form-item" @click="openPopup('isCityPopup')">
					<label for="" class="form-item__label"><span class="form-item__required">*</span>省市区</label>
					<input v-model="formData.area" disabled type="text" class="form-item__input" placeholder="请输入省市区">
				</div>
				<div class="form-item">
					<label for="" class="form-item__label"><span class="form-item__required">*</span>详细地址</label>
					<input v-model="formData.address" type="text" class="form-item__input" placeholder="请输入详细地址">
				</div>
				<button @click="saveMemberInfo" class="u-button u-button--primary u-button--big">保存</button>

		</form>


		<van-popup :show="isDatePopup" position="bottom">
			<van-datetime-picker :value="currentDate" type="date" @confirm="setBirthday" @cancel="isDatePopup=false" :min-date="minDate" />
		</van-popup>
		<van-popup :show="isCityPopup" position="bottom">
			<van-area :area-list="areaList" @confirm="setCity" @cancel="isCityPopup=false" />
		</van-popup>
		<van-toast id="van-toast" />
	</div>
</template>

<script>
	import {
		api
	} from "@/utils/api";
	import {
		post,
		host,
		cityData,
		timeChange,
	} from "@/utils";
	import Toast from "@/../static/vant/toast/toast";
	export default {
		data() {
			return {
				datas: [],
				formData: {
					username: '',
					phone: '',
					sex: 1,
					birthday: '',
					area: '',
					address: '',
					marryday: '',
					job_num: '' //工号
				},
				sex:1,
				areaList: cityData,
				date: '',
				isCityPopup: false,
				isDatePopup: false,
				currentDate: new Date().getTime(),

				birthday: '',
				iphone: null,
				verifyCode: '',
				isInputVerifyCode: false,
				verifyCodeBtnText: '获取验证码',
				next: false,
				isInputSuccess: false
			};
		},
		components: {},
		computed: {
			// 是否需要验证码
			isVerification() {
				return Number(this.$store.state.isVerification)
			},
			minDate () {
				return new Date('1900,01,01')
			}
		},

		methods: {
			verifyInput(e) {
				// 输入正确的话
			},
			// 下一步
			async nextAtion() {
				this.next = true
				let data = await api.getNextAtion(this.formData.phone)
				console.log(data)
			},
			toggleSex(e) {
				this.formData.sex = e.mp.detail
			},
			// 打开date
			openPopup(popup) {
				this[popup] = true
			},
			closePopup(popup) {
				this[popup] = false
			},
			setBirthday(e) {
				console.log(e)
				let time = timeChange(e.mp.detail / 1000, true).split('.').join('-')
				this.formData.birthday = time
				this.isDatePopup = false
			},
			setCity(e) {
				console.log('地址', e)
				let data = e.mp.detail.detail
				this.formData.area = `${data.city},${data.province},${data.county}`
				this.isCityPopup = false
			},
			async saveMemberInfo() {
				let opt = this.formData
				// 判断字段是否填写
				if (!opt.username) {
					Toast('请输入名字')
					return false
				}
				if (!opt.birthday) {
					Toast('请输入出生年月')
					return false
				}
				if (!opt.area) {
					Toast('请输入省市区')
					return false
				}
				if (!opt.address) {
					Toast('请输入具体地址')
					return false
				}

				opt.PHPSESSID = wx.getStorageSync('PHPSESSID')
				let data = await api.saveMemberInfo(opt)
				if (data.code == 0) {
					Toast.fail(data.msg);
				} else {
					Toast.success(data.msg);
					wx.redirectTo({
						url: '../index/index'
					})
				}
			},
			// 获取验证码
			getVerifyCode() {
				const _this = this
				
				if (this.verifyCodeBtnText.indexOf('获取') != -1) {
					let endTime = 60
					let timer = setInterval(() => {
						_this.verifyCodeBtnText = `重新发送(${endTime})`
						endTime--
						if (endTime == 0) {
							clearInterval(timer)
							_this.verifyCodeBtnText = `重新获取`
						}
					}, 1000);
					api.getVerifyCode(this.form.phone)
				}
			}
		},

		onLoad() {}
	};
</script>
<style lang="scss" scoped>
	._van-radio-group {
		display: flex;

		/deep/ .van-radio__input {
			height: 1em
		}

		/deep/ .van-radio {
			margin-right: 30px;
		}

		/deep/ .van-radio__label {
			margin-left: 5px;
		}
	}
</style>
