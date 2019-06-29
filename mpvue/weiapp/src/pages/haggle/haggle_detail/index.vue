<template>
  <div class="haggle_detail active_detail">
   <!--活动信息-->
    <div class="active_name">
      <span class="good_name">{{eventinfo.title}}</span>
    </div>
  <!--活动商品图片-->
    <div class="active_img">
       <activeSlide v-bind:imgsurl="imgsurl"></activeSlide>
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
          <small class="tag" v-else>已砍掉¥{{decprice}}</small>
          <del class="market_price" v-if="saleprice != eventinfo.market_price"><span class="prize-icon">¥</span>原价{{eventinfo.market_price}}</del>
        </p>
        <p class="good_name">{{goods.title}}</p>
        <a class="red" :href="'../instruction/index?eventinfoid=' + eventinfo.id ">活动说明<i class="iconfont icon-warning1 f12 f-ml-base"></i></a>
    </div>
    <!--砍价排行榜-->
    <div  class="haggle_top">
      <h3 class="top_title">砍价排行榜 <a class="more_haggle_top" v-if="count >= 3" :href="'../haggle_top/index?orderid=' + order.id+ '&haggleid=' + order.haggle_id">查看更多</a><i class="iconfont icon-more"></i></h3>
      <small class="top_text" v-if="lists.length == 0"  >木有排行榜，请先找人帮砍砍</small>
      <div class="top_imformation" v-else>
          <div class="inline" v-for="(list, index) in lists" :key="index">
            <div class="avatar">
              <img lazy-load :src="list.headimgurl">
            </div>
            <div class="haggle_content">
              <span>{{list.content}}</span>
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
    </div>
    <!--详情、评价-->
    <div class="detail_estimate">
      <van-tabs :active="tabActive" swipeable>
        <van-tab class="van_tab detail" title="商品详情">
          <div class="detail">
            <div v-html="content"></div>
          </div>
        </van-tab>
        <van-tab class="van_tab estimate" title="评价">
          <div class="m-flex">
            <div class="m-flex-img">
              <img lazy-load class="null_img" :src="imgRoot+'null.png'">
            </div>
            <small>暂无相关评价</small>
          </div>
        </van-tab>
      </van-tabs>
    </div>
    <!--立即砍价-->
    <div class="bottom-btn" v-if="order_id>0 && order.order_id>0">
      <a class="view_my_order" @click="viewmyorder" >查看我的订单</a>
    </div>
    <div class="bottom-btn" v-else-if="order_id>0 && order.order_id<=0">
      <a class="collage_now"   @click="collagenow">立即出手</a>
      <button class="help_collage" open-type="share" @click="find_help" >找人帮砍</button>
    </div>
    <div class="bottom-btn" v-else>
      <a class="join_now" @click="join_now" >立即参与</a>
    </div>
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
				imgRoot: this.imgRoot,
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
        arrowDir: "top",
        show: false,
        order_id: 0
      }
    },
    components: {
      activeSlide
    },
    methods: {
      countdown: function () {
        var that = this;
        // const endtime = Date.parse(new Date('2019-12-01'))
        const endtime = that.cd.endtime;
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
        var goodsId = this.goods.goods_id;
        // 库存为0
        if(this.eventinfo.stock_active == 0) {
          Toast('该活动商品已经被抢光了')
          return false
        }
        post(host + "haggle/api/bug_now", {
          haggle_id: this.eventinfo.id,
          PHPSESSID: wx.getStorageSync('PHPSESSID')
        }).then((data) => {
          if (data.code == 0) {
            Toast(data.msg);
          } else {
            let reg = /goods_id\/(\d+)\/event_type\/(\d+)\/event_id\/(\d+)\/pbid\/(\d+)/.exec(data.url)
            let goods_id = reg[1];
            let event_type = reg[2];
            let event_id = reg[3];
            let pbid = reg[4];
            let activePrice = this.saleprice;
            let opt = {goods_id: goods_id, event_type: event_type, event_id: event_id, pbid: pbid, activePrice: activePrice, PHPSESSID: wx.getStorageSync('PHPSESSID')};

            this.$store.commit("saveData", {
              key: 'activeOrderParams',
              value: JSON.stringify(opt)
            });

            wx.navigateTo({
              url: '../../shop/confirm_order/index?goodsId=' + this.goods.goods_id
            })
          }
        });

      },
      join_now () {
        post(host + "/haggle/Api/join_now", {
          haggle_id: this.eventinfo.id,
          PHPSESSID: wx.getStorageSync('PHPSESSID')
        }).then((data) => {
          if (data.code == 0) {
            Toast(data.msg);
          } else {
            this.order_id = data.order_id;
            this.order = {order_id:0};
            this.show = true;
          }
        });
      },
      viewmyorder () {
        wx.navigateTo({
          url: '../../shop/order_detail/index?order_id=' + this.order.id
        })
      },
      toggleArrow() {
        this.arrowDir == "top"
          ? (this.arrowDir = "bottom")
          : (this.arrowDir = "top");
      }
    },
    onLoad () {
      this.show = false;
      this.userdata = login();
      var haggleid = this.$root.$mp.query.id;
      post(host + "/haggle/Api/index", {
        haggle_id: haggleid,
        PHPSESSID: wx.getStorageSync('PHPSESSID')
      }).then((data) => {
        if (data.code == 0 && data.msg != ''){
          Toast(data.msg);
        }else{
          this.decprice = data.dec_price;
          this.eventinfo = data.event_info;
          this.content = data.goods.content.replace(/\<img/gi, '<img lazy-load style="width:100% !important;height:auto" ');
          this.goods = data.goods;
          this.imgsurl = data.goods.imgs_url;
          this.lists = data.lists;
          this.mid = data.mid;
          this.order = data.order;
          this.count = data.count;
          this.saleprice = data.sale_price;
          this.order_id = data.order_id;
          this.cd.endtime = data.event_info.end_time;
          this.cd.starttime = data.event_info.start_time;
        }
    });
      this.countdown();
    },
    onShareAppMessage: function (res) {
      var that = this;
      return {
        title: this.eventinfo.title,
        desc: that.userdata.nickName + '请您帮砍价', // 分享描述
        path: 'pages/haggle/haggle_help/index?inviteuid=' + that.mid + '&haggleid=' + this.eventinfo.id + '&orderid=' + this.order_id,
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
  /*活动信息*/
  .haggle_name{text-align: center;}
  .haggle_img{height:200px;padding:10px;}
  .haggle_time{background: #feedd6;text-align: center;width:94%;height: 30px;line-height: 30px;margin:5px auto;font-size:12px;}
  /*商品信息*/
  /*砍价排行榜*/
  .lowest_price{display:inline-flex;border-radius:12px;color:white;background:red;padding:0 5px;}
  .haggle_top{width:94% ; margin:10px 3%}
  .top_title{border-bottom:1px solid #aaa;padding:5px 0;font-size:16px;}
  .more_haggle_top{float:right;font-size:14px;color:#aaa;}
  .top_text{font-size:12px;color:#aaa;}
  .top_imformation{margin:3px 0 10px;background:white;}
  .inline{display:inline-flex;margin:3px 0; padding:5px;border-bottom:1px solid #ddd;}
  .avatar{width:40px;height:40px;}
  .avatar>img{height:40px;border-radius:50%;}
  .haggle_content{height:40px;overflow:hidden;}

  .switch-card{padding:0 10px !important;}
  /*详情、评价*/

  /*活动按钮*/
  .join_now,.view_my_order{width:100%;height:100%;padding:10px 0;color:white;background:#ff0204;}
  .collage_now{width:50%;padding:10px 0;color:white;background: black;}
  .help_collage{width:50%;padding:5px 0;color:white;background:#ff0204;border-radius:0;font-size:14px;}
</style>
