<template>
  <div class="my_collage">
    <div class="collage_banner">
      <activeBanner v-bind:active="active"></activeBanner>
    </div>

    <div class="goods"  v-for="(goodslist ,index) in goodslists" :key="index">
      <span class="collage_tag">{{goodslist.event.member_limit}}人团</span>
      <div class="active_img">
        <img class="good_img" v-bind:src='goodslist.goods.cover'/>
      </div>
      <!-- 时间 -->
      <!--<i-count-down class="active_time hide" target="eventinfo.end_time" format="myformat" clear-timer="false">-->
      <!--</i-count-down>-->
      <div class="active_time">
        <span v-if="goodslist.group.status == 1">
          <span class="">赞！开团成功！</span>
        </span>
        <span v-else-if="goodslist.group.status != 1 && goodslist.event.end_time<cd.nowtime">
          <span class="">活动已结束</span>
        </span>
        <span v-else-if="goodslist.group.status != 1 && goodslist.event.end_time>cd.nowtime && goodslist.group.left_time>0">
          <span class="">剩余时间:{{goodslist.group.time_str}}</span>
        </span>
        <span v-else>
           <span class="" >超时，拼团失败</span>
        </span>
      </div>
      <!--商品信息-->
      <div class="active_good_detail">
        <div class="good_detail">
          <p class="title">{{goodslist.goods.title}}</p>
          <p class="red active_price">
            <span class="price-icon">¥</span><strong>{{goodslist.goods.sale_price}}</strong>
          </p>
          <p class="market_price">
            <del><span class="prize-icon">¥</span>{{goodslist.goods.market_price}}</del>
          </p>
        </div>
        <!--按钮-->
        <a class="active-btn" :href="'../group_detail/index?id=' + goodslist.group.id">查看详情</a>
      </div>
    </div>
    <div class="active_null" v-show="goodslists == ''">
      <span>还未参与拼团</span>
    </div>
  </div>
</template>
<script>
  import activeBanner from '@/components/active/activeBanner';
  import activeContent from '@/components/active/activeContent';
  import {post, host, login} from "@/utils";
  import Toast from "@/../static/vant/toast/toast";
  export default {
    mpType: 'page',
    data () {
      return {
				imgRoot: this.imgRoot,
        cd: {day: 0, hour: 0, min: 0, sec: 0, satrttime: 0, endtime: 0, nowtime: 0},
        envetinfo: {},
        str:'',
        goodslists: [],
        active: {name: '拼团', img: this.imgRoot+'collagebanner.jpg', url: '../collage_detail/index'}
      }
    },
    components: {
      activeBanner,
      activeContent
    },
    methods: {
      getData (id) {
        post(host + "/collage/Api/my_collage", {
          event_id: id,
          PHPSESSID: wx.getStorageSync('PHPSESSID')
        }).then((data) => {
          if(data.code == 0){
            Toast(data.res)
          }else{
            this.goodslists = data.goods_lists;
          }
        })
      },
      cdtime: function () {
        var that = this;
        setInterval(function () {
          for (var i = 0; i < that.goodslists.length; i++) {
            var time = that.goodslists[i].group.left_time--;
            let d = parseInt(time / 60 / 60 / 24);
            let h = parseInt(time / 60 / 60 % 24);
            let m = parseInt(time / 60 % 60);
            let s = parseInt(time % 60);
            this.str = d + '天' + h + ':' + m + ':' + s ;
            that.goodslists[i].group.time_str = d + '天' + h + ':' + m + ':' + s ;
          }
        }, 1000);
        //   if(!time){
        //     that.str = '0天00:00:00';
        //   }else {
        // }
      }
  },
    onLoad () {
        var id = this.$root.$mp.query.id;
        this.cd.nowtime = Date.parse(new Date()) / 1000;
        this.getData(id);
        this.cdtime();
    }
  }
</script>
<style lang="scss" scoped>
  .my_collage{width:100%;padding-bottom:50px;
    .goods{margin: .4rem;box-shadow:0 5px 18px #ddd;background: #fff;border-radius: 10px;position: relative;
      .collage_tag{margin-left:20px;padding:3px;color:white;background: $theme_color;border-radius:0 0 8px 8px;box-shadow:0 3px 5px #ddd;}
      .active_img{height:200px;
        .good_img{width:94%;height:100%;margin:0 3%;}
      }
      .active_time {background: #feedd6;text-align: center;height: 30px;line-height: 30px;font-size:14px;}
      .active_good_detail{display:flex;margin:10px;padding-bottom:10px;
        .good_detail{width:70%;
          .title{margin:5px 0;}
          .red{display:flex;color:#ff0204;animation: twinkle 1.5s infinite;}
          .tag{background:#ff0204;color:white;margin:3px 5px;padding:0 5px;font-size:10px;line-height:16px;animation: twinkle1 1.5s infinite;border-radius:10px;}
          .market_price{text-decoration:line-through;}
        }
        .active-btn{width:auto;text-align:center;line-height:34px;margin:auto;padding:0 10px;color:white;background:linear-gradient(90deg, #ff0204 60%, #ffb3b3);border-radius:17px;}
      }
    }
    .active_null{text-align:center;margin:10px;}
  }
</style>
