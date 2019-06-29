<template>
  <div class="haggle_detail active_detail">
      <navbar :text="eventinfo.title"></navbar>
   <!--活动信息-->
    <!--<div class="active_name">-->
      <!--<span class="good_name"></span>-->
    <!--</div>-->
    <scroller >
  <!--活动商品图片-->
    <div class="active_img" >
       <activeSlide v-bind:imgsurl="imgsurl" ></activeSlide>
    </div>
    <div class="active_time" v-if="cd.endtime > cd.nowtime && cd.nowtime > cd.starttime">剩余时间:{{cd.day}}天{{cd.hour}}小时{{cd.min}}分钟{{cd.sec}}秒</div>
    <div class="active_time active_timeout" v-else-if="cd.nowtime > cd.endtime">活动已结束</div>
    <div class="active_time active_not_begin" v-else>活动未开始</div>
    <!--商品信息-->
    <div class="flex good_detail">
        <p class="red active_price">
          <span class="price-icon">¥{{saleprice}}</span>
        </p>
        <p class="cost_price">
          <small class="lowest_price" v-if="saleprice == eventinfo.min_price">已砍到最低价，请立即出手，手慢无</small>
          <small class="tag" v-else>已砍掉¥{{decprice}}</small><br>
          <del class="market_price" v-if="saleprice != eventinfo.market_price"><span class="prize-icon">¥</span>原价{{eventinfo.market_price}}</del>
        </p>
        <p class="good_name">{{goods.title}}</p>
        <router-link class="red" :to="'/haggle/instruction/' + eventinfo.id ">活动说明<i class="iconfont icon-warning1 f12 f-ml-base"></i></router-link>
    </div>
    <!--砍价排行榜-->
    <div  class="haggle_top">
      <h3 class="top_title">砍价排行榜 <router-link class="more_haggle_top" v-if="count >= 3" :to="'/haggle/top/' + order.id+ '/' + order.haggle_id">查看更多</router-link><i class="iconfont icon-more"></i></h3>
      <small class="top_text" v-if="lists.length == 0"  >木有排行榜，请先找人帮砍砍</small>
      <div class="top_imformation" v-else>
          <div class="inline" v-for="(list, index) in lists" :key="index">
            <div class="avatar">
              <img :src="list.headimgurl">
            </div>
            <div class="haggle_content">
              <span>{{list.content}}</span>
            </div>
          </div>
      </div>
    </div>
      <!--产品参数-->
      <div class="switch-card" v-if="goods.goods_param != ''">
        <div class="switch-card__hd" @click="toggleArrow">
          <p class="switch-card__tt">产品参数</p>
          <p class="switch-card__icon iconfont icon-fanhui" :class="arrowDir" ></p>
        </div>
        <div class="switch-card__bd" v-show="arrowDir == 'top'">
          <div
                  class="switch-card__item"
                  v-for="(param, paramIdx) in goods.goods_param"
                  :key="paramIdx"
          >
            <p class="switch-card__param overflow-dot_row">{{param.title}}</p>
            <p class="switch-card__attr overflow-dot_row">{{param.param_value}}</p>
          </div>
        </div>
      </div>
    <!--详情、评价-->
    <div class="detail_estimate">
      <van-tabs  swipeable>
        <van-tab class="van_tab detail" title="商品详情">
          <div class="detail">
            <div v-html="content"></div>
          </div>
        </van-tab>
        <van-tab class="van_tab estimate" title="评价">
          <div class="m-flex">
            <div class="m-flex-img">
              <img class="null_img" src="~images/null.png">
            </div>
            <small>暂无相关评价</small>
          </div>
        </van-tab>
      </van-tabs>
    </div>
    </scroller>
    <!--立即砍价-->
    <div class="bottom-btn" v-if="order_id>0 && order.order_id>0">
      <a class="view_my_order" @click="viewmyorder" >查看我的订单</a>
    </div>
    <div class="bottom-btn" v-else-if="order_id>0 && order.order_id<=0">
      <a class="collage_now"   @click="collagenow">立即出手</a>
      <button class="help_collage" @click="find_help" >找人帮砍</button>
    </div>
    <div class="bottom-btn" v-else>
       <a class="join_now" @click="join_now" >立即参与</a>
    </div>
    
    <van-toast id="van-toast" />
	<!--找人帮砍弹框-->
    <transition name="fade">
    <div class="dialog" v-if="show1" @click="show1 = false">
      <div class="share_tips">
        <img src="~images/share_tips.png">
      </div>
    </div>
    </transition>
  </div>
</template>

<script>
  import activeSlide from '@/components/active/activeSlide';
  import navbar from "@/components/navbar";
  import { ImagePreview, Toast, Popup, Tabs, tab} from "vant";
  import {post, host, login, wx, goShare} from "@/utils";
  export default {
    data () {
      return {
          cd: {day: 0, hour: 0, min: 0, sec: 0, starttime: 0, endtime: 0, nowtime: 0},
          userdata: [],
          decprice: 0.00,
          eventinfo: {},
          imgsurl: [],
          lists: [],
          content: '',
          goods: [],
          mid: 0,
          order: {},
          count: '',
          saleprice: 0.00,
          arrowDir: 'bottom',
          show: false,
          show1: false,
          order_id: 0
      }
    },
    components: {
        activeSlide,
        navbar
    },
    methods: {
      countdown: function () {
        var that = this;
        // const endtime = Date.parse(new Date('2019-12-01'))
        const endtime = this.cd.endtime;
        this.cd.nowtime = Date.parse(new Date()) / 1000;
        const msec = endtime - Date.parse(new Date()) / 1000;
        let d = parseInt(msec / 60 / 60 / 24);
        let h = parseInt(msec / 60 / 60 % 24);
        let m = parseInt(msec / 60 % 60);
        let s = parseInt(msec % 60);
        this.cd.day = d;
        this.cd.hour = h;
        this.cd.min = m;
        this.cd.sec = s;
        setTimeout(function () {
          that.countdown()
        }, 1000)
      },
      collagenow () {
          this.show = true;
        var goodsId = this.goods.goods_id;
        // 库存为0
        if(this.eventinfo.stock_active == 0) {
          Toast('该活动商品已经被抢光了')
          return false
        }
        post(host + "haggle/api/bug_now", {
          haggle_id: this.eventinfo.id,
          PHPSESSID: window.localStorage.getItem('PHPSESSID'),
        }).then((data) => {
          let reg = /goods_id\/(\d+)\/event_type\/(\d+)\/event_id\/(\d+)\/pbid\/(\d+)/.exec(data.url)
          let goods_id = reg[1];
          let event_type = reg[2];
          let event_id = reg[3];
          let pbid = reg[4];
          let activePrice = this.saleprice;
          let opt = {goods_id: goods_id, event_type: event_type, event_id: event_id, pbid: pbid, activePrice: activePrice, PHPSESSID: window.localStorage.getItem('PHPSESSID'),};
          this.$store.commit("saveData", {
            key: 'activeOrderParams',
            value: JSON.stringify(opt)
          });

          this.$router.push('/confirm_order/'+ this.goods.goods_id);
        });

      },
      join_now () {
          console.log(this.eventinfo.id);
        post(host + "haggle/Api/join_now", {
          haggle_id: this.eventinfo.id,
          PHPSESSID: window.localStorage.getItem('PHPSESSID'),
        }).then((data) => {
          if (data.code == 0) {
            Toast(data.msg);
          } else {
            this.order_id=data.order_id;
            this.order.order_id=0;
            //console.log('jnorderid:',this.order_id);
            this.show = true;
          }
        });
      },
        find_help() {
          this.show = true;
         this.show1 = !this.show1;
        },
        viewmyorder() {
            this.$router.push('/order_detail/'+ this.order.id);
        },
        toggleArrow() {
            this.arrowDir == "top"
                ? (this.arrowDir = "bottom")
                : (this.arrowDir = "top");
        }
    },
      created() {
          var that = this;
          var haggleid = this.$route.params.haggleid;
          post(host + "/haggle/Api/index", {
              haggle_id: haggleid,
              PHPSESSID: window.localStorage.getItem('PHPSESSID'),
          }).then((data) => {
              if (data.code == 0 && data.msg != '') {
                  Toast(data.msg);
              }else{
                  this.decprice = data.dec_price;
                  this.eventinfo = data.event_info;
                  this.content = data.goods.content.replace(/\<img/gi, '<img style="width:100% !important;height:auto" ');
                  this.goods = data.goods;
                  this.imgsurl = data.goods.imgs_url;
                  this.lists = data.lists;
                  this.mid = data.mid;
                  this.order = data.order;
                  this.count = data.count;
                  this.saleprice = data.sale_price;
                  this.cd.endtime = data.event_info.end_time;
                  this.cd.starttime = data.event_info.start_time;
                  this.order_id = data.order_id;


                  //分享接口
                  var share_url=data.share_url?data.share_url:'';
                  var nickname = data.nickname?data.nickname:'';
									console.log("wzh",share_url)
                  var shareData = {
                      title: this.eventinfo.title, // 分享标题
                      desc: nickname + '请您帮砍价', // 分享描述
                      link: share_url, //分享的链接地址
                      imgUrl: this.eventinfo.share_cover, // 分享图标
                      type: 'link', // 分享类型,music、video或link，不填默认为link
                  };
                  goShare(shareData);
              }
            // wx.onMenuShareAppMessage(shareData);
          });
          this.countdown();
      }
  }
</script>
<style lang="scss" scoped>
  /*活动信息*/
  .haggle_name{text-align: center;}
  .haggle_img{height:200px;padding:10px;}
  .haggle_time{background: #feedd6;text-align: center;width:90%;height: 30px;line-height: 30px;margin:5px auto;font-size:12px;}
  /*商品信息*/
  /*砍价排行榜*/
  .lowest_price{display:inline-flex;border-radius:12px;color:white;background:red;padding:0 5px;}

  .haggle_top{width:90% ; margin:10px 5% !important;}
  .top_title{border-bottom:1px solid #aaa;padding:5px 0;font-size:16px;}
  .more_haggle_top{float:right;font-size:14px;color:#aaa;}
  .top_text{font-size:12px;color:#aaa;}
  .top_imformation{margin:3px 0 10px;background:white;}
  .inline{display:inline-flex;margin:3px 0; padding:5px;border-bottom:1px solid #ddd;}
  .avatar{}
  .avatar>img{width:50px;border-radius:50%;}
  .haggle_content{height:50px;overflow:hidden;}

  /*产品参数*/
  .switch-card{width:90%; margin:10px 5%;padding:0 !important;}
  .switch-card__icon.iconfont{margin-right:5px;padding:0 !important;}
  .switch-card__tt, .switch-card__bd{padding:0 5px;}
  /*详情、评价*/

  /*活动按钮*/
  .join_now,.view_my_order{width:100%;height:100%;padding:10px 0;color:white;background:#ff0204;}
  .collage_now{width:50%;padding:10px 0;color:white;background: black;}
  .help_collage{width:50%;padding:5px 0;color:white;background:#ff0204;border-radius:0;font-size:14px;}
  /*弹框*/
  .dialog{width:50%;background: #505050;position:fixed;top:0;right:0;text-align:center;border-radius:5px;overflow: hidden;transition: all .5s ease;box-shadow:0 0 40px #aaa;z-index:1000;}

  .fade-enter-active{
    transition: all 0.5s ease-in-out;
  }
  .fade-leave-active{
    transition: all 1s linear;
  }
  .fade-enter, .fade-leave-to{
    opacity: 0;
    top: -100%;
    right: -100%;
  }
</style>
