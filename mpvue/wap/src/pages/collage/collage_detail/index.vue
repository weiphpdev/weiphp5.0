<template>
  <div class="collage_detail active_detail" >
    <navbar :text="eventinfo.title"></navbar>
    <!--活动信息-->
    <!--<div class="active_name">-->
      <!--<span class="good_name">{{eventinfo.title}}</span>-->
    <!--</div>-->
    <!--活动商品图片-->
    <scroller>
    <div class="active_img">
      <activeSlide v-bind:imgsurl="imgsurl"></activeSlide>
    </div>
    <div class="active_time"  >
      <div >
        <span class="active_price">{{eventinfo.member_limit}}人拼团价--</span>
        <span class="active_price">{{goods.sale_price}}元</span>
        <span class="countdown" v-if="cd.endtime > cd.nowtime && cd.nowtime > cd.starttime">剩余时间:{{cd.day}}天{{cd.hour}}:{{cd.min}}:{{cd.sec}}</span>
        <span class="active_timeout" v-else-if="cd.nowtime > cd.endtime">活动已结束</span>
        <span class="active_not_begin" v-else>活动未开始</span>
      </div>
    </div>
    <!--商品信息-->
    <div class="flex good_detail" style="box-sizing: border-box;padding:0.4rem;">
      <p class="red active_price">
        <span class="price-icon">¥{{goods.sale_price}}</span>
      </p>
      <p class="cost_price">
        <small class="tag">拼团价</small><br>
        <del class="market_price"  style="color: #999;"><span class="prize-icon">¥</span>原价{{goods.market_price}}</del>
      </p>
      <p class="good_name">{{goods.title}}</p>
      <router-link class="red" :to="'/collage/instruction/' + eventinfo.id">活动说明<i class="iconfont icon-warning1 f12 f-ml-base"></i></router-link>
      <!--<a class="red" :href="'../instruction/main?eventinfoid=' + eventinfo.id">活动说明<i class="iconfont icon-warning1 f12 f-ml-base"></i></a>-->
    </div>
    <!--拼团记录-->
    <div class="group_record" v-if="groupid == 0 && eventinfo.is_open != 0 && collagegroup.lists != ''">
      <div class="gorup_record_header">
        <p class="group_num"><span>{{collagegroup.count}}</span>人在拼单，可直接参与</p>
        <p class="view_more"><router-link class="flex" :to="'/collage/group_more/' + goods.id + '/' + eventinfo.id" @click="view_more"><span class="gray">查看更多</span><i class="weui-cell__ft"></i></router-link></p>
      </div>
      <div class="group_record_content" v-for="(list ,index) in collagegroup.lists" :key="index">
        <div class="record_item">
          <div class="record_header">
            <img class="headimgurl" :src='list.headimgurl'>
            <div class="differ_num">
              <p class="nickname">{{list.nickname}}</p>
              <small class="differ_info">还差<strong class="red">{{list.need_count}}人</strong>拼成,剩余 <strong
                      class="group_time" rel="">{{list.time_str}}</strong> 结束
              </small>
            </div>
          </div>
          <div class="go_group">
            <router-link :to="'/collage/group_detail/' + list.id" class="">去拼团</router-link>
            <!--<a :href="'../group_detail/main?id=' + list.id" class="">去拼团</a>-->
          </div>
          <div style="clear:both"></div>
        </div>
      </div>
    </div>
    <!--产品参数-->
    <div class="switch-card" v-if="goodsparam != ''">
      <div class="switch-card__hd" @click="toggleArrow">
        <p class="switch-card__tt">产品参数</p>
        <p class="switch-card__icon iconfont icon-fanhui" :class="arrowDir" ></p>
      </div>
      <div class="switch-card__bd" v-show="arrowDir == 'top'">
        <div
                class="switch-card__item" style="height: 0.9rem;line-height: 0.9rem;"
                v-for="(param, paramIdx) in goodsparam"
                :key="paramIdx"
        >
          <p class="switch-card__param overflow-dot_row">{{param.title}}</p>
          <p class="switch-card__attr overflow-dot_row">{{param.param_value}}</p>
        </div>
      </div>
    </div>
    <!--详情、评价-->
    <div class="detail_estimate">
      <van-tabs swipeable>
        <van-tab class="van_tab detail" title="商品详情">
          <div class="detail">
            <div v-html="content"></div>
          </div>
        </van-tab>
        <van-tab class="van_tab estimate" title="评价">
          <div class="">
            <img class="null_img" src="~images/null.png">
          </div>
          <small>暂无相关评价</small>
        </van-tab>
      </van-tabs>
    </div>
    </scroller>
    <!--拼团按钮-->
    <div class="bottom-btn" v-if="needpayurl != ''">
      <a class="gopay" @click="gopay(outtradeno)">去支付</a>
    </div>

    <div class="bottom-btn" v-else-if="needpayurl == '' && groupid == 0">
      <a class="costprice" @click="original_cost">原价购买<span>¥{{goods.market_price}}</span></a>
      <a class="collage_num"  @click="joincollage">{{eventinfo.member_limit}}人团<span>¥{{goods.sale_price}}</span></a>
    </div>
    <div class="bottom-btn" v-else>
      <a class="invite" @click="invite_collage">邀请好友拼团</a>
    </div>
    <!--<div class="bottom-btn" v-else>-->
    <!--<a class="active_over">活动已结束</a>-->
    <!--</div>-->
    <transition name="fade">
      <div class="dialog" v-if="show" @click="show = false">
        <div class="share_tips">
          <img src="~images/share_tips.png">
        </div>
      </div>
    </transition>
    <van-toast id="van-toast"/>
  </div>
</template>

<script>
    import activeSlide from '@/components/active/activeSlide'
    import {post, host, login, wx, goShare, goPay} from "@/utils";
    import Toast from "vant";
    import navbar from "@/components/navbar";
    export default {
        data () {
            return {
                cd: {day: 0, hour: 0, min: 0, sec: 0, starttime: 0, endtime: 0, nowtime: 0},
                userdata: [],
                collagegroup: {},
                eventinfo: {},
                content: '',
                goods: {},
                groupid: 0,
                needpayurl: '',
                outtradeno: '',
                goodsparam: [],
                imgsurl: [],
                arrowDir: 'top',
                show:false
            }
        },
        components: {
            activeSlide,
            navbar
        },
        computed: {
        },
        methods: {
            view_more () {
            },
            gopay(id, price){
                goPay(id)
            },
            original_cost () {
                let goods_id = this.goods.id;
                let event_type = 1;
                let is_original = 1;
                let activePrice = this.goods.market_price;
                let opt = {goods_id: goods_id, event_type: event_type, is_original: is_original,activePrice: activePrice, PHPSESSID: window.localStorage.getItem('PHPSESSID')};
                this.$store.commit("saveData", {
                    key: 'activeOrderParams',
                    value: JSON.stringify(opt)
                });
                    this.$router.push('/confirm_order/' + this.goods.goods_id)
            },
            joincollage () {
                post(host + "/collage/Api/buy_now", {
                    goods_id: this.goods.id,
                    PHPSESSID: window.localStorage.getItem('PHPSESSID')
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
                            activePrice: activePrice,
                            PHPSESSID: window.localStorage.getItem('PHPSESSID')
                        };

                        this.$store.commit("saveData", {
                            key: 'activeOrderParams',
                            value: JSON.stringify(opt)
                        });
                        this.$router.push('/confirm_order/' + this.goods.goods_id)
                    }
                });
            },
            invite_collage (){
                this.show = !this.show
            },
            toggleArrow() {
                this.arrowDir == "top" ? (this.arrowDir = "bottom") : (this.arrowDir = "top");
            },
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
            cdtime: function () {
                var that = this;
                setInterval(function () {
                    for (var i = 0; i < that.collagegroup.count; i++) {
                        var time = that.collagegroup.lists[i].left_time--;
                        let d = parseInt(time / 60 / 60 / 24);
                        let h = parseInt(time / 60 / 60 % 24);
                        let m = parseInt(time / 60 % 60);
                        let s = parseInt(time % 60);
                        that.collagegroup.lists[i].time_str = d + '天' + h + ':' + m + ':' + s ;
                    }
                }, 1000);
                //   if(!time){
                //     that.str = '0天00:00:00';
                //   }else {
                // }
            }
        },
        created () {
            var id = this.$route.params.id;
            post(host + "/collage/Api/goods_detail", {
                id: id,
                PHPSESSID: window.localStorage.getItem('PHPSESSID')
            }).then((data) => {
                this.collagegroup = data.collage_group;
                // this.lists = JSON.parse(JSON.stringify(data.collage_group.lists));
                this.eventinfo = data.event_info;
                this.content = data.goods.goods.content.replace(/\<img/gi, '<img style="width:100% !important;height:auto" ');
                this.goods = data.goods;
                this.groupid = data.group_id;
                this.needpayurl = data.need_pay_url;
                this.outtradeno = data.out_trade_no;
                this.imgsurl = data.goods.goods.imgs_url;
                this.goodsparam = data.goods.shop_goods.goods_param;
                this.cd.endtime = data.event_info.end_time;
                this.cd.starttime = data.event_info.start_time;
                // 分享接口
                var shareData = {
                    title: data.share_data.title, // 分享标题
                    desc:  data.share_data.desc, // 分享描述
                    link: data.share_data.link, //分享的链接地址
                    imgUrl: data.share_data.imgUrl, // 分享图标
                    type: 'link', // 分享类型,music、video或link，不填默认为link
                };
                goShare(shareData);
            });
            this.countdown();
            this.cdtime();
        }
    }
</script>
<style lang="scss" scoped>
  /*活动信息*/
  p{margin:0;}
  /*商品信息*/
  .tag{width:60px;margin:8px auto;color:white;background-color: #ff0204;font-size:12px;border-radius: 3px;animation: twinkle1 1.5s infinite }
  /*拼团记录*/
  .group_record{width:90%;margin:5px 5%;background:white;}
  .gorup_record_header{position:relative;display:inline-flex;width:100%;}
  .gorup_record_header>p{padding:5px;}
  .view_more{position:absolute;right:0;}
  .group_record_content{padding:5px;}
  .record_item{padding-top:5px;border-top:1px solid #ddd;}
  .headimgurl{width:40px;height:40px;border-radius: 50%;float:left;}
  .differ_num{float:left;margin-left:5px;}
  .differ_info{display:inline-flex;font-size:12px;color:#aaa;}
  .go_group{width:50px;text-align:center;line-height:25px;margin-top:10px;padding:0 4px;color:white;background:linear-gradient(90deg, #ff0204 60%, #ffb3b3);border-radius:12.5px;float:right;}
  .go_group>a{color:white;}
  /*产品参数*/
  .switch-card{width:90%; margin:10px 5%; box-sizing: border-box}
  .switch-card__icon.iconfont{margin-right:5px;padding:0 !important;}
  .switch-card__tt, .switch-card__bd{padding:0 5px;}
  /*详情、评价*/

  /*活动按钮*/
  .costprice{width:50%;height:100%;padding:10px 0;color:white;background: black;}
  .collage_num{width:50%;height:100%;padding:10px 0;color:white;background:#ff0204;}
  .gopay,.invite{width:100%;height:100%;padding:10px 0;color:white;background:#ff0204;}

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
