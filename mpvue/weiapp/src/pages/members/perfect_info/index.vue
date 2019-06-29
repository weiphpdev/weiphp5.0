<template>
  <div class="get-card">

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
							<van-radio-group :value="formData.sex">
								<van-radio :name="1" checked-color="#ff0204">男</van-radio>
								<van-radio :name="2" checked-color="#ff0204">女</van-radio>
							</van-radio-group>
						</van-radio-group>
					</div>
					
					<div class="form-item" @click="openPopup('isDatePopup')">
						<label for="" class="form-item__label">生日</label>
						<input v-model="formData.birthday" disabled type="text" class="form-item__input" placeholder="请输入生日">
					</div>
          <div class="form-item" @click="openPopup('isMemoryPopup')">
						<label for="" class="form-item__label">结婚日</label>
						<input v-model="formData.marryday" disabled type="text" class="form-item__input" placeholder="请输入结婚纪念日">
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

    <van-popup :show="isDatePopup" position="bottom">
			<van-datetime-picker
				:value="currentDate"
				type="date"
				@confirm="setBirthday"
			/>
    </van-popup>
      <van-popup :show="isMemoryPopup" position="bottom">
        <van-datetime-picker
          :value="currentDate"
          type="date"
          @confirm="setMarryday"
        />
      </van-popup>
		<van-popup :show="isCityPopup" position="bottom">
			<van-area :area-list="areaList" @confirm="setCity" @cancel="isCityPopup=false" />
		</van-popup>
		<van-toast id="van-toast" />
  </div>
</template>

<script>
import { api } from "@/utils/api";
import { post, host, cityData, timeChange } from "@/utils";
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
				job_num: ''	//工号
			},
      areaList: cityData,
      date: '',
      isCityPopup: false,
      isDatePopup: false,
      isMemoryPopup: false,
      currentDate: new Date().getTime(),
    };
  },
  components: {
  },
  computed: {
    
  },

  methods: {
    // 打开date
		openPopup(popup) {
			this[popup] = true
		},
		closePopup (popup) {
			this[popup] = false
    },
		setMarryday (e) {
			console.log(e)
			let time = timeChange(e.mp.detail/1000, true).split('.').join('-')
			this.formData.marryday = time
			this.isMemoryPopup = false
		},
		setBirthday (e) {
			console.log(e)
			let time = timeChange(e.mp.detail/1000, true).split('.').join('-')
			this.formData.birthday = time
			this.isDatePopup = false
		},
		setCity (e) {
			console.log('地址',e)
			let data = e.mp.detail.detail
			this.formData.area = `${data.city},${data.province},${data.county}`
			this.isCityPopup = false
		},
		async getData () {
      this.isRecordPopup=true
			let data = await api.getMemberInfo()
			let info = data.info
      this.formData.username = info.username
      this.formData.phone = info.phone
      this.formData.sex = info.sex
			this.formData.birthday = info.birthday<0 ? "" : timeChange(info.birthday,true).split('.').join('-')
      this.formData.marryday = info.marryday<0 ? "" : timeChange(info.marryday,true).split('.').join('-')
      this.formData.area = info.area
      this.formData.address = info.address
      this.formData.job_num = info.job_num
		},
		async saveMemberInfo () {
			let opt = this.formData
			// 判断字段是否填写
			if(!opt.username) {
				Toast('请输入名字')
				return false
			}
			if(!opt.birthday) {
				Toast('请输入出生年月')
				return false
			}
			if(!opt.area) {
				Toast('请输入省市区')
				return false
			}
			if(!opt.address) {
				Toast('请输入具体地址')
				return false
			}
			
			opt.PHPSESSID = wx.getStorageSync('PHPSESSID')
			let data = await api.saveMemberInfo(opt)
			if(data.code == 0) {
				Toast.fail(data.msg);
			} else {
				Toast.success(data.msg);
				wx.redirectTo({url: '../index/index'})
			}
		},
  },

  onLoad() {
    this.getData()
  }
};
</script>
<style lang="scss" scoped>
._van-radio-group {
	display: flex;
	/deep/ .van-radio__input {height: 1em}
	/deep/ .van-radio {margin-right: 30px;}
	/deep/ .van-radio__label {margin-left: 5px;}
}
</style>
