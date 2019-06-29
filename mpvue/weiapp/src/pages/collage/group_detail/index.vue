<template>
  <div class="group_detail">
    <!--活动商品图片-->
    <div class="detail_card">
    <div class="active_img">
      <div class="active_tag">{{eventinfo.member_limit}}人团</div>
      <img class="good_img" v-bind:src='goods.cover'/>
    </div>
    <div class="active_time" >
      <div>
        <span v-if="group.status == 2">
        <span class="active_price">拼团失败</span>
        <span class="countdown">该团已给微信提交退款申请</span>
        </span>
        <span v-else-if="group.status !=2 && group.need_count != 0">
          <span class="active_price">已开团，还差{{group.need_count}}人成团--</span>
          <span class="countdown" >剩余时间:{{str}}</span>
        </span>
        <span v-else-if="group.status !=2 && group.need_count == 0">
          <span class="active_price">赞！开团成功！</span>
          <span class="countdown">商家会尽快为你发货</span>
        </span>
        <!--<span>-->
        <!--<span class="countdown" v-if="cd.endtime > cd.nowtime && cd.nowtime > cd.starttime">剩余时间:{{cd.day}}天{{cd.hour}}小时{{cd.min}}分钟{{cd.sec}}秒</span>-->
        <!--<span class="active_timeout" v-else-if="cd.nowtime > cd.endtime">活动已结束</span>-->
        <!--<span class="active_not_begin" v-else>活动未开始</span>-->
        <!--</span>-->
      </div>
    </div>
    <!--商品信息-->
    <div class="good_detail">
      <p class="red active_price">
        <span class="price-icon">¥{{goods.sale_price}}</span>
      </p>
      <p class="cost_price">
        <small class="tag">拼团价</small>
        <del class="market_price"><span class="prize-icon">¥</span>原价{{goods.market_price}}</del>
      </p>
      <p class="good_name">{{goods.title}}</p>
      <a class="red" :href="'../instruction/index?eventinfoid=' + eventinfo.id">活动说明<i class="iconfont icon-warning1 f12 f-ml-base"></i></a>
    </div>
    </div>
    <!--参团记录-->
    <div class="attendance_record" v-if="memberlists != null">
      <h4 class="attendance_record_title">参团记录</h4>
      <div class="attendance_record_content" v-if="member.is_pay == 1" v-for="(member, index) in memberlists " :key="index">
          <div class="record_header">
            <img class="headimgurl"  :src="member.headimgurl">
          </div>
          <div class="record_content" v-if="member.uid == group.uid">
            <p>{{member.nickname}}
              <span class="tag" >团长</span>
            </p>
            <p class="record_time" >
              <small>{{member.create_time_str}}开团</small>
            </p>
          </div>
          <div class="record_content" v-else>
            <p>{{member.nickname}}
              <span class="tag-b" >团员</span>
            </p>
            <p class="record_time">
              <small>{{member.create_time_str}}参团</small>
            </p>
          </div>
          <!-- 码 -->
          <!--<div class="f-text-c">
            <p><i class="iconfont icon-qrcode"></i></p>
            <p><small>邀请码</small></p>
          </div>-->
        <div class="clear"></div>
      </div>
    </div>
    <!--拼团按钮-->
    <div class="bottom-btn" v-if="group.need_count == 0">
      <a class="go_collage" @click="gocollage" >我要开团</a>
    </div>
    <div class="bottom-btn" v-else-if="group.need_count != 0 && orderid == 0">
      <a class="join_collage" @click="joincollage" >我要参团</a>
    </div>
    <div class="bottom-btn" v-else-if="orderid != 0">
      <a class="view_order" @click="vieworder" >查看订单详情</a>
      <button class="invite_friends" open-type="share" >邀请好友参团</button>
    </div>
  </div>

</template>
<script>
  import {post, host, login} from "@/utils"
  import Toast from "@/../static/vant/toast/toast";
  export default {
    mpType: 'page',
    data () {
      return {
        cd: {day: 0, hour: 0, min: 0, sec: 0, starttime: 0, endtime: 0, nowtime: 0},
        createtime: '',
        str: '',
        userdata: [],
        eventinfo: {},
        goods: {},
        group: {},
        groupid: 0,
        memberlists: [{}],
        orderid: 0
      }
    },
    components: {
      Toast
    },
    methods: {
      gocollage () {
        post(host + "/collage/Api/buy_now", {
          goods_id: this.goods.id,
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
            let activePrice = this.goods.sale_price;
            let opt = {
              goods_id: goods_id,
              event_type: event_type,
              event_id: event_id,
              pbid: pbid,
              activePrice: activePrice, PHPSESSID: wx.getStorageSync('PHPSESSID')
            };
            this.$store.commit("saveData", {
              key: 'activeOrderParams',
              value: JSON.stringify(opt)
            });
            wx.navigateTo({
              url: '../../shop/confirm_order/index?goodsId=' + this.goods.goods_id
            })
          }
        })
      },
      joincollage() {
        post(host + "/collage/Api/buy_now", {
          goods_id: this.goods.id,
          group_id: this.groupid,
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
            let activePrice = this.goods.sale_price;
            let opt = {
              goods_id: goods_id,
              event_type: event_type,
              event_id: event_id,
              pbid: pbid,
              activePrice: activePrice, PHPSESSID: wx.getStorageSync('PHPSESSID')
            };

            this.$store.commit("saveData", {
              key: 'activeOrderParams',
              value: JSON.stringify(opt)
            });
            wx.navigateTo({
              url: '../../shop/confirm_order/index?goodsId=' + this.goods.goods_id
            })
          }
        })
      },
      vieworder() {
        wx.navigateTo({
          url: '../../shop/order_detail/index?order_id=' + this.orderid
        })
      },
      cdtime(){
        var that = this;
        clearInterval(interval);
        var interval = setInterval(function () {
          var time = that.group.left_time--;
          var d = parseInt(time / 60 / 60 / 24);
          var h = parseInt(time / 60 / 60 % 24);
          var m = parseInt(time / 60 % 60);
          var s = parseInt(time % 60);
          that.str = d + '天' + h + ':' + m + ':' + s;
        }, 1000)
        this.$store.commit("saveData", {
          key: 'Interval',
          value: interval
        });
      },
      getData(id){
        post(host + "/collage/Api/group_detail", {
          id: id,
          PHPSESSID: wx.getStorageSync('PHPSESSID')
        }).then((data) => {
          var that = this;
          if (data.code == 0) {
            Toast(data.msg);
          } else {
            this.eventinfo = data.event_info;
            this.goods = data.goods;
            this.group = data.group;
            this.groupid = data.group_id;
            this.memberlists = data.member_lists;
            this.orderid = data.order_id;
          }
        })
      },
      formatDate(){
        var that = this;
        // var time = that.memberlists[0].create_at;
        // console.log("time",time,that.memberlists[0].create_at)
        // this.createtime = new Date(parseInt(1545016568) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
        // console.log("fotmat",this.createtime);
      }
    },
    computed: {
      memberlistsData () {
        this.createtime = new Date(parseInt(this.memberlists[0].create_at) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
        return this.memberlists
      },
      // strData (){
      //   console.log(this.str)
      //   return this.str
      // }
    },
    onLoad () {
      // Object.assign(this.$data, this.$options.data());
      var id = this.$root.$mp.query.id;
      if(this.$store.state.Interval != 0){
        clearInterval(this.$store.state.Interval)
      }
      this.userdata = login();
      this.getData(id);
      this.cdtime();
      this.formatDate();
    },
    onShow() {
    },
    updated (){
    },
    onShareAppMessage: function (res) {
      var that = this;
      return {
        title: this.goods.title,
        desc: that.userdata.nickName + '邀请您参加拼团', // 分享描述
        // path: 'pages/collage/group_detail/index?inviteuid=' + that.mid + '&id=' + this.groupid,
        path: 'pages/collage/group_detail/index?id=' + this.groupid,
        imageUrl: this.goods.cover,
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
  .detail_card{width:94%;margin:10px 3%; background:white;box-shadow:0 0 5px #ddd;border-radius: 10px;}
  .active_tag{position:absolute;padding:3px;color:white;background: $theme_color;border-radius:0 0 8px 8px;}
  .active_img{width:94%;height:auto !important;margin:0 3%; text-align: center;}
  .active_img .good_img{width:100%;}
  .active_time,.good_detail{margin:0!important;width:100% !important;}
  /*参团记录*/
  .attendance_record{width:94%;margin:5px 3% 60px;background:white;border-radius:10px;box-shadow:0 0 5px #ddd;}
  .attendance_record_title{padding:5px;}
  .attendance_record_content{padding:5px;border-top:1px solid #ddd;}
  .record_header{float:left;padding:5px;}
  .headimgurl{width:40px;height:40px;border-radius: 50%;float:left;}
  .record_content{float:left;padding:5px;}
  .record_time{font-size:12px;color:#aaa;}
  .tag{background: $theme_color;color:white;padding: 2px 4px; border-radius:5px;font-size:12px;}
  .tag-b{background:transparent;color:$theme_color;padding: 2px 4px; border-radius:5px;font-size:12px;border: 1px solid $theme_color;}
  .clear{clear:both;}
  /*活动按钮*/
  .view_order{width:50%;height:100%;padding:10px 0;color:white;background: black;}
  .invite_friends{width:50%;padding:2px 0;color:white;background:#ff0204;border-radius:0;font-size:16px;}
  .go_collage,.join_collage{width:100%;height:100%;padding:10px 0;color:white;background:#ff0204;}
</style>
