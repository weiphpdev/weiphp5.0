<template>
  <div class="get-card">
    <navbar text="完善资料"></navbar>

    <scroller>
     <form action="" class="form">
					<div class="form-item">
						<label for="" class="form-item__label"><span class="form-item__required">*</span>姓名</label>
						<input v-model="formData.username" type="text" class="form-item__input" placeholder="请输入姓名">
					</div>
          <div class="form-item">
						<label for="" class="form-item__label"><span class="form-item__required">*</span>手机号</label>
						<input v-model="formData.phone" type="number" class="form-item__input" placeholder="请输入手机号">
					</div>
					<div class="form-item">
						<label for="" class="form-item__label"><span class="form-item__required">*</span>性别</label>
							<van-radio-group v-model="formData.sex">
								<van-radio :name="1" checked-color="#ff0204">男</van-radio>
								<van-radio :name="2" checked-color="#ff0204">女</van-radio>
							</van-radio-group>
						</van-radio-group>
					</div>
					
					<!--<div class="form-item" @click="openPopup('isDatePopup')">
						<label for="" class="form-item__label">生日</label>
						<input v-model="formData.birthday" disabled type="text" class="form-item__input" placeholder="请输入生日">
					</div>
          <div class="form-item" @click="openPopup('isMemoryPopup')">
						<label for="" class="form-item__label">结婚日</label>
						<input v-model="formData.marryday" disabled type="text" class="form-item__input" placeholder="请输入结婚纪念日">
					</div>-->
					<div class="form-item" >
						<label for="" class="form-item__label">出生日期</label>
						<input v-model="formData.year" type="number" class="form-item__input birthdayclass" placeholder="">年
						<input v-model="formData.month" type="number" class="form-item__input birthdayclass" placeholder="">月
						<input v-model="formData.days" type="number" class="form-item__input birthdayclass" placeholder="">日
					</div>

					<div class="form-item" @click="openPopup('isCityPopup')">
						<label for="" class="form-item__label"><span class="form-item__required">*</span>省市区</label>
						<input v-model="formData.area" disabled type="text" class="form-item__input" placeholder="请输入省市区">
					</div>
					<div class="form-item">
						<label for="" class="form-item__label"><span class="form-item__required">*</span>详细地址</label>
						<input v-model="formData.address" type="text" class="form-item__input" placeholder="请输入详细地址">
					</div>
       
				</form>
				<button @click="saveMemberInfo" class="u-button u-button--primary u-button--big">保存</button>
    </scroller>

    <van-popup v-model="isDatePopup" position="bottom">
			<van-datetime-picker
				v-model="currentDate"
				type="date"
				@change="setDate"
				@confirm="closePopup('isDatePopup')"
				:min-date="minDate"
			/>
    </van-popup>
      <van-popup v-model="isMemoryPopup" position="bottom">
        <van-datetime-picker
          v-model="currentDate"
          type="date"
          @change="setMarryday"
          @confirm="closePopup('isMemoryPopup')"
					:min-date="minDate"
        />
      </van-popup>
		<van-popup v-model="isCityPopup" position="bottom">
			<van-area :area-list="areaList" @confirm="setCity" @cancel="closePopup('isCityPopup')"/>
		</van-popup>


  </div>
</template>

<script>
import { api } from "@/utils/api";
import { post, host, data, timeChange } from "@/utils";
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
      areaList: data,
      date: '',
      isCityPopup: false,
      isDatePopup: false,
      isMemoryPopup: false,
      currentDate: new Date()
    };
  },
  components: {
    navbar
  },
  computed: {
    minDate () {
			return new Date('1900,01,01')
		}
  },

  methods: {
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
			this.formData.birthday = `${checkedDate[0]}-${checkedDate[1]}-${checkedDate[2]}`
		},
		// 设置日期
		setMarryday (e) {
			console.log(e)
			let checkedDate = e.getValues()
			this.formData.marryday = `${checkedDate[0]}-${checkedDate[1]}-${checkedDate[2]}`
		},
		setCity (e) {
			this.formData.area = `${e[0].name},${e[1].name},${e[2].name}`
			this.cityPopup = false
			this.closePopup('isCityPopup');
		},
		async getData () {
      this.isRecordPopup=true
			let data = await api.getMemberInfo()
			let info = data.info
      this.formData.username = info.username
      this.formData.phone = info.phone
      this.formData.sex = info.sex
			this.formData.birthday = info.birthday<=0 ? "" : timeChange(info.birthday,true).split('.').join('-')
      this.formData.marryday = info.marryday<=0 ? "" : timeChange(info.marryday,true).split('.').join('-')
      this.formData.area = info.area
      this.formData.address = info.address
			this.formData.job_num = info.job_num
			 this.formData.year = info.year
			 this.formData.month = info.month
			 this.formData.days = info.days
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
  },

  created() {
    this.getData()
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
