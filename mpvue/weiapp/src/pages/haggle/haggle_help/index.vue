<template>
  <div class="haggle_help" >
    <div class="active_name">
      <span class="good_name">{{eventinfo.title}}</span>
    </div>

    <div class="active_img">
      <activeSlide v-bind:active="active" v-bind:imgsurl="imgsurl"></activeSlide>
    </div>

    <div class="invite_haggle">{{nickname}}邀请您帮他砍价</div>

    <div class="good_detail">
      <p class="red active_price">
        <span class="price-icon">¥<strong>{{saleprice}}</strong></span>
      </p>
      <p class="good_name">{{eventinfo.title}}</p>
      <!--<p class="good_name">xxx</p>-->
      <a class="red" :href="'../instruction/index?eventinfoid=' + eventinfo.id ">活动说明<i class="iconfont icon-warning1 f12 f-ml-base"></i></a>
    </div>
    <!--立即帮砍-->
    <div class="bottom-btn">
      <a class="haggle_now" @click="helphaggle" v-if="show1 == false">立即帮砍</a>
      <a class="join_now" :href="'../haggle_detail/index?id=' + eventinfo.id" v-else>我要参加</a>
    </div>
    <!--帮砍弹框-->
    <transition name="fade">
      <div class="dialog" v-if="show" @click="show = false">
        <!--<div class="dialog_title">标题</div>-->
        <div class="dialog_content">
          <div class="haggle_price">¥{{helpdecprice}}</div>
          <div class="haggle_tips">
            <span>恭喜你！</span><br>
            <span>成功帮好友砍掉了{{helpdecprice}}元</span>
          </div>
        </div>
        <div class="dialog_btn">
          <a class="want_to_join" :href="'../haggle_detail/index?id=' + eventinfo.id" >我要参加</a>
        </div>
      </div>
    </transition>
    <van-toast id="van-toast" />
  </div>
</template>
<script>
  import activeSlide from '@/components/active/activeSlide'
  import Toast from "@/../static/vant/toast/toast";
  import {post, host, login} from "@/utils"
  export default {
    mpType: 'page',
    data () {
      return {
        active: {name: '砍价', img: this.imgRoot + 'hagglebanner.jpg', url: '../haggle_detail/index?id='},
        userdata: [],
        nickname: '',
        decprice: 0.00,
        inviteuid: 0,
        orderid: 0,
        eventinfo: {},
        imgsurl: [],
        helpdecprice: 0.00,
        saleprice: 0.00,
        show: false,
        show1: false
      }
    },
    components: {
      activeSlide
    },
    methods: {
      helphaggle (){
        this.show1 = !this.show1;
        var inviteuid = this.$root.$mp.query.inviteuid;
        var haggleid = this.$root.$mp.query.haggleid;
        var orderid = this.$root.$mp.query.orderid;
        post(host + "/haggle/Api/do_help", {
          invite_uid: inviteuid,
          haggle_id: this.eventinfo.id,
          PHPSESSID: wx.getStorageSync('PHPSESSID'),
        }).then((data) => {

          if(data.code == 0){
            let msg=data.msg == ''?'请求出错':data.msg;
            Toast(msg);
          }else{
            this.helpdecprice = data.dec_price;
            this.show = !this.show;
          }
        })
      }
    },
    onLoad () {
      this.show1 = false;
      this.userdata = login();
      var inviteuid = this.$root.$mp.query.inviteuid;
      var haggleid = this.$root.$mp.query.haggleid;
      var orderid = this.$root.$mp.query.orderid;
      this.orderid = orderid;
      post(host + "/haggle/Api/help_haggle", {
        invite_uid: inviteuid,
        haggle_id: haggleid,
        order_id: orderid,
        PHPSESSID: wx.getStorageSync('PHPSESSID')
      }).then((data) => {
        this.decprice = data.dec_price;
        this.eventinfo = data.event_info;
        this.inviteuid = data.invite_uid;
        this.saleprice = data.sale_price;
        this.helpdecprice = data.help_dec_price;
        this.nickname = data.nickname;
        this.imgsurl = data.event_info.shop_goods.imgs_url;
      })
    },
    onShareAppMessage: function (res) {
      var that = this;
      return {
        title: this.eventinfo.title,
        desc: that.userdata.nickName + '请您帮砍价', // 分享描述
        path: 'pages/haggle/haggle_help/index?inviteuid=' + that.inviteuid + '&haggleid=' + this.eventinfo.id + '&orderid=' + that.order_id,
        imageUrl: this.eventinfo.share_cover,
        success: function(res) {
          console.log("转发成功");
        },
        fail: function(res) {
          console.log("转发失败");
        }
      }
    }

  }
</script>
<style lang="scss" scoped>
  .haggle_now, .join_now{width:100%;height:100%;padding:10px 0;color:white;background:#ff0204;font-size:14px;}
  .dialog{width:70%;margin:0 15%;background:url("http://ku.90sjimg.com/back_pic/05/42/02/605a65df773df12.jpg%21/fwfh/804x1206/quality/90/unsharp/true/compress/true");background-size:100% 100%;position:fixed;top:20%;z-index:10;text-align:center;border-radius:5px;overflow: hidden;transition: all .5s ease;box-shadow:0 0 40px #aaa;}
  .dialog_content{height:300px;}
  .haggle_price{width:100px;position:absolute;top:20%;left:calc(50% - 50px);border-radius:5px;}
  .haggle_tips{font-size:14px;position:absolute;width:100%;top:35%;}
  .dialog_btn{background:#ff0204;color:white;font-size:14px;line-height:30px;padding:5px 0;}
  .dialog_btn>a{color:white;}
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
</style>
