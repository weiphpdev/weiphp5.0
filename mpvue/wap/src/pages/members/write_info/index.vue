<template>
  <div class="write-info">
    <navbar text="填写资料" isShowNavbar="false"></navbar>

    <scroller>
			<template v-if="!next">
				<form action="" class="form">
					<div class="form-item">
						<input @input="verifyInput" v-model="formData.phone" type="number" class="form-item__input" placeholder="输入手机号">
					</div>
					<!-- <div class="form-item form-item_verify" v-if="isVerification">
						<input v-model="verifyCode" type="text" class="form-item__input" placeholder="输入验证码">
						<button class="form-item__btn" :class="{disable: isInputVerifyCode}" @click="getVerifyCode">{{verifyCodeBtnText}}</button>
						
					</div> -->
				</form>
				<button v-if="!isInputSuccess" class="u-button u-button--primary u-button--big disable">下一步</button>
				<button v-else @click="nextAtion" class="u-button u-button--primary u-button--big">下一步</button>
			</template>
			<template v-else>
				<form action="" class="form">
					<div class="form-item">
						<label for="" class="form-item__label">姓名</label>
						<input v-model="formData.username" type="text" class="form-item__input" placeholder="请输入姓名">
					</div>
					<div class="form-item">
						<label for="" class="form-item__label">性别</label>
							<van-radio-group v-model="formData.sex">
								<van-radio :name="1" checked-color="#ff0204">男</van-radio>
								<van-radio :name="2" checked-color="#ff0204">女</van-radio>
							</van-radio-group>
						</van-radio-group>
					</div>
					
					<!--<div class="form-item" @click="openPopup('datePopup')">
						<label for="" class="form-item__label">出生年月</label>
						<input v-model="formData.birthday" disabled type="text" class="form-item__input" placeholder="请输入出生年月">
					</div>-->
					<div class="form-item" >
						<label for="" class="form-item__label">出生日期</label>
						<input v-model="formData.year" type="number" class="form-item__input birthdayclass" placeholder="">年
						<input v-model="formData.month" type="number" class="form-item__input birthdayclass" placeholder="">月
						<input v-model="formData.days" type="number" class="form-item__input birthdayclass" placeholder="">日
					</div>

					<div class="form-item" @click="openPopup('cityPopup')">
						<label for="" class="form-item__label">省市区</label>
						<input v-model="formData.area" type="text" class="form-item__input" placeholder="请输入省市区">
					</div>
					<div class="form-item">
						<label for="" class="form-item__label">详细地址</label>
						<input v-model="formData.address" type="text" class="form-item__input" placeholder="请输入详细地址">
					</div>
				</form>
				<button @click="saveMemberInfo" class="u-button u-button--primary u-button--big">保存</button>
			</template>
    </scroller>
		<van-popup v-model="datePopup" position="bottom">
			<van-datetime-picker
				v-model="currentDate"
				type="date"
				@change="setDate"
				@confirm="closeDatePopup"
				@cancel="closePopup('datePopup')"
				:min-date="minDate"
			/>
		</van-popup>
		<van-popup v-model="cityPopup" position="bottom">
			<van-area :area-list="areaList" @confirm="setCity" @cancel="closePopup('cityPopup')"/>
		</van-popup>
  </div>
</template>

<script>
import { post, host, data } from "@/utils";
import { api } from "@/utils/api";
import navbar from "@/components/navbar";
import { Toast } from 'vant';
export default {
  data() {
    return {
		datas: [],
		formData: {
			username: '',
			phone: '',
			sex: 1,
			birthday: '',
			year:'',
			month:'',
			days:'',
			area: '',
			address: '',
			marryday: '',
			job_num: ''	//工号
		},
		next: false,
		currentDate: new Date(),
		datePopup: false,
		cityPopup: false,
		areaList: data,
		birthday: '',
		verifyCode: '',
		isInputVerifyCode: false,
		verifyCodeBtnText: '获取验证码',
		isInputSuccess: false
	}
  },
  components: {
    navbar
  },
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
		// 下一步
		async nextAtion() {
			this.next = true
			let data = await api.getNextAtion(this.formData.phone)
			console.log(data)
		},
		verifyInput(e) {
			// 输入正确的话
			if(this.formData.phone != ''){
				this.isInputSuccess=true;
			}
			//console.log(this.formData.phone);
		},
    // 打开date
		openPopup(popup) {
			this[popup] = true
		},
		closePopup (popup) {
			this[popup] = false
		},
		// 设置日期
		setDate (e) {
			console.log(e)
			let checkedDate = e.getValues()
			this.birthday = `${checkedDate[0]}-${checkedDate[1]}-${checkedDate[2]}`
		},
		closeDatePopup () {
			this.formData.birthday = this.birthday
			this.datePopup = false
		},
		setCity (e) {
			this.formData.area = `${e[0].name},${e[1].name},${e[2].name}`
			this.cityPopup = false
		},
		async saveMemberInfo () {
			let opt = this.formData
			// 判断字段是否填写
			if(!opt.username) {
				Toast('请输入名字')
				return false
			}
			
			if(!opt.year) {
				Toast('请输入年')
				return false
			}
			var date=new Date();
			var curYear=date.getFullYear();
			if(opt.year<1900 || opt.year>curYear) {
				Toast('请正确输入出生年份')
				return false
			}
			if(!opt.month) {
				Toast('请输入月')
				return false
			}
			if(opt.month<1 || opt.month>12) {
				Toast('请正确输入出生月份')
				return false
			}
			if(!opt.days) {
				Toast('请输入日')
				return false
			}
			if(opt.days<1 || opt.days>32) {
				Toast('请正确输入出生日期')
				return false
			}
			/*if(!opt.birthday) {
				Toast('请输入出生年月')
				return false
			}*/
			opt.birthday = opt.year+'-'+opt.month+'-'+opt.days;
			
			if(!opt.area) {
				Toast('请输入省市区')
				return false
			}
			if(!opt.address) {
				Toast('请输入具体地址')
				return false
			}
			
			opt.PHPSESSID = window.localStorage.getItem('PHPSESSID')
			let data = await api.saveMemberInfo(opt)
			if(data.code == 0) {
				Toast.fail(data.msg);
			} else {
				Toast.success(data.msg);
				this.$router.push('/members/index')
			}
		},
		// 获取验证码
		getVerifyCode () {
			const _this = this
			if(!this.iphone) {
				Toast('手机号有问题')
				return false;
			}
			if(this.verifyCodeBtnText.indexOf('获取') != -1) {
				let endTime = 60
				let timer = setInterval(() => {
					_this.verifyCodeBtnText = `重新发送(${endTime})`
					endTime--
					if(endTime == 0) {
						clearInterval(timer)
						_this.verifyCodeBtnText = `重新获取`
					}
				}, 1000);
				api.getVerifyCode(this.iphone)
			}
		}
		
		
  },

  created() {
    
  }
};
</script>
<style lang="scss" scoped>
.van-radio-group {
	display: flex;
	/deep/ .van-radio__input {height: auto}
	/deep/ .van-radio {margin-right: 30px;}
	/deep/ .van-radio__label {margin-left: 5px;vertical-align: text-bottom;}
}
.birthdayclass{
	width: 40%;
	border: 1px solid #eee;
	margin: 10px 4px;
	text-align: center;
	color: #777;
}
</style>
