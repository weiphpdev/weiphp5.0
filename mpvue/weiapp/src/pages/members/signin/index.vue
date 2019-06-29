<template>
  <div class="signin" v-if="datas.score">

      <div class="signin-hd g-flex">
        <p class="g-flex__item">
          <span class="f-font-sm">可用积分：</span>{{datas.score}}
        </p>
        <p>
          <span class="f-font-sm">已签到：</span>{{datas.sign_count || 0}}
          <span class="f-font-sm">次</span>
        </p>
      </div>
      <Calendar :markDate="markDate"></Calendar>
      <div class="signin-btn--wrap">
        <div class="g-flex__item signin-btn__item signin-btn__item--record" @click="openSignRecord">
          <van-icon name="todo-list-o"/>
          <p>签到记录</p>
        </div>
        <div v-if="!isSignin" class="signin-btn" @click="goSignin">签到</div>
        <div v-else class="signin-btn signin-btn--used">已签到</div>
        <div class="g-flex__item signin-btn__item signin-btn__item--psp" @click="openRecordPsp">
          <van-icon name="points"/>
          <p>积分攻略</p>
        </div>
      </div>

    <popupRight :popupData="recordPspData" :isPopup="isPspPopup" @closePopup="isPspPopup=false" popupTitle="积分攻略"></popupRight>

    <popupRight :popupData="signHint" :isPopup="isSiginPopup" @closePopup="isSiginPopup=false"></popupRight>

    <van-popup v-model="isRecordPopup" position="right">
      <div class="navbar">
        <p class="navbar-icon_left iconfont icon-fanhui" @click="isRecordPopup=false"></p>
        <p class="navbar-title overflow-dot_row">签到记录</p>
      </div>
      <div class="integral-record">
        <div class="table">
          <div class="table-head">
            <p class="table-th">详情</p>
            <p class="table-th">日期</p>
            <p class="table-th">积分</p>
          </div>
          <div class="table-body">
            <div class="table-tr" v-for="(item,index) in signData" :key="index">
              <div class="table-td">签到得积分</div>
              <div class="table-td">{{item.sTime}}</div>
              <div class="table-td">{{item.score}}</div>
            </div>
          </div>
        </div>
        
      </div>
    </van-popup>
  
  </div>
</template>

<script>
import { api } from "@/utils/api";
import { post, host, timeChange } from "@/utils";
import popupRight from "@/components/popupRight";
import Calendar from "@/components/calendar";
export default {
  data() {
    return {
      datas: [],
      recordPspData: '',
      isPspPopup: false,
      isRecordPopup: false,
      isSiginPopup: false,
      signHint: '',
      signData: [],
      isSignin: false,
      markDate: []
    };
  },
  components: {
    Calendar,
    popupRight
  },
  computed: {},

  methods: {
    async openRecordPsp () {
      this.isPspPopup = true
      let data = await api.getScorePsp()
      this.recordPspData = data.content
    },
    async openSignRecord () {
      this.isRecordPopup=true
      let data = await api.getSignRecord()
      data.signin_log.map(item => {
        item.sTime = timeChange(item.sTime, true)
      })
      this.signData = data.signin_log
    },
    // 签到
    async goSignin() {
      this.isSignin = true
      this.isSiginPopup = true
      let data = await api.goSignin()
      if(data.code == 0) {
        Toast(data.msg)
        return false;
      }

      // 签到mark
      let selfTime = new Date()
      this.markDate.push(this.selfYmd())
      this.signHint = data.msg
    },
    selfYmd() {
      let time = new Date()
      let y = time.getFullYear()
      let m = time.getMonth() + 1
      let d = time.getDate()

      m = m < 10 ? "0" + m : m
      d = d < 10 ? "0" + d : d
      return `${y}/${m}/${d}`
    },
    async getData() {
      let data = await api.getSigninInfo()
      this.datas = data
      let list = JSON.parse(data.sign_dates)
      if(list) {
        let arr = []
        list.map(item => {
          let [y,m,d] = [item.slice(0,4),item.slice(4,6),item.slice(6,8)]
          arr.push(`${y}/${m}/${d}`)
        })
        
        this.markDate = arr
      }
      if(this.datas.has_msg) {
        this.isSignin = true
      }
    }
  },

  onLoad() {
    this.getData()
  }
};
</script>
<style lang="scss" scoped>
.van-popup--right {
  width: 100%;
        height: 100%;
        padding: 15px;
        box-sizing: border-box;
        background: #f9f9f9;
}
.signin-btn {
  border-radius: 50%;
  background: red;
  /* padding: 30px; */
  color: #fff;
  width: 80px;
  height: 80px;
  line-height: 80px;
  text-align: center;
  box-shadow: 0 0 0px 5px rgba(255, 0, 0, 0.2),
    0 0 0px 15px rgba(255, 0, 0, 0.05);
  font-size: 16px;
  &--used {
    background: #bbb;
    box-shadow: none;
    opacity: 0.6;
  }
  &--wrap {
    min-height: 20vh;
    @extend .g-flex-center;
    padding: 0 15px;
    font-size: 12px;
  }
  &__item {
    text-align: center;
    height: 100px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    .van-icon {font-size: 24px;margin-bottom: 2px;}

    &--record {margin-right: 50px;}
    &--psp {margin-left: 50px;}
  }
}
.signin-hd {
  padding: 15px 15px 0;
  font-size: 24px;
}


// 积分攻略/记录
.integral-psp,
.integral-record
 {
  margin-top: 45px;
}

// 积分记录表格
table {
  width: 100%;
  position: relative;
}

.navbar {
  left: 0;
  height: 45px;
  background: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
  border-bottom: 1px solid #f2f2f26b;
  position: fixed;
  top: 0;
  width: 100%;
}
.navbar-title {
  flex: 1;
  text-align: center;
  padding: 0 30px;
}
.navbar-icon_left {
  font-size: 20px;
  position: absolute;
  left: 10px;
}

// 表格
.table {
  &-head,
  &-body,
  &-tr {
    display: flex;
  }
  &-th,
  &-td {
    flex: 1;
  }

  &-head,
  &-tr {
    height: 45px;
    align-items: center;
    border-bottom: 1px solid #eee;
  }

  &-th {
    font-weight: bold;
  }
  &-tr {
    width: 100%;
    font-size: 14px;
  }

  &-body {
    flex-direction: column;
  }
}
</style>
