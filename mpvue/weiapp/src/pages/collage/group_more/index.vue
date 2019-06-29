<template>
  <div class="group_more" >
    <div class="group_record" v-for="(list ,index) in lists" :key="index">
      <div class="record_item">
        <div class="record_header">
          <img class="headimgurl" :src='list.headimgurl'>
          <div class="differ_num">
            <p>{{list.nickname}}</p>
            <small class="differ_info">还差<strong class="red">{{list.need_count}}人</strong>拼成,剩余 <strong
              class="group_time" rel=""></strong>{{list.time_str}} 结束
            </small>
          </div>
        </div>
        <div class="go_group">
          <a :href="'../group_detail/index?id=' + list.id" class="">去拼团</a>
          <!--<a href="{:U('group_detail',['id'=>$vo['id']])}" class="weui-btn weui-btn_primary m-md-btn">去拼团</a>-->
        </div>
        <div style="clear:both"></div>
      </div>
    </div>
    <van-toast id="van-toast"/>
  </div>
</template>
<script>
  import {post, host, login} from "@/utils"
  import Toast from "@/../static/vant/toast/toast";
  export default {
    mpType: 'page',
    data () {
      return {
        collagegroup: {},
        eventinfo: {},
        lists: []
      }
    },
    components: {

    },
    methods: {
      cdtime: function () {
        var that = this;
        var interval = setInterval(function () {
          for (var i = 0; i < that.collagegroup.count; i++) {
            var time = parseInt(that.lists[i].left_time--);
            let d = parseInt(time / 60 / 60 / 24);
            let h = parseInt(time / 60 / 60 % 24);
            let m = parseInt(time / 60 % 60);
            let s = parseInt(time % 60);
            that.lists[i].time_str = d + '天' + h + ':' + m + ':' + s ;
          }
        }, 1000);
        this.$store.commit("saveData", {
          key: 'groupmoreinterval',
          value: interval
        });
      },
    },
    onLoad () {
      var goodsid = this.$root.$mp.query.id;
      var eventinfoid = this.$root.$mp.query.collageid;
      if(this.$store.state.groupmoreinterval != 0){
        clearInterval(this.$store.state.groupmoreinterval)
      }
      post(host + "/collage/Api/group_more", {
        goods_id:goodsid,
        collage_id: eventinfoid,
        PHPSESSID: wx.getStorageSync('PHPSESSID')
      }).then((data) => {
        if(data.code == 0){
          Toast(data.res)
        }else{
          this.collagegroup = data.collage_group;
          this.eventinfo = data.eventinfo;
          this.lists = data.collage_group.lists;
        }
      });
      this.cdtime();

    }
  }

</script>

<style lang="scss" scoped>
  .group_more{padding:5px 0;}
  .group_record{width:94%;margin:0 3%;background:white;}
  .gorup_record_header{position:relative;display:inline-flex;width:100%;}
  .gorup_record_header>p{padding:5px;}
  .group_record_content{padding:5px;}
  .record_item{padding:5px;border-bottom:1px solid #ddd;}
  .headimgurl{width:40px;height:40px;border-radius: 50%;float:left;margin-top:5px;}
  .differ_num{float:left;margin-left:5px;}
  .differ_info{display:inline-flex;font-size:12px;color:#aaa;}
  .go_group{width:50px;text-align:center;line-height:25px;margin-top:10px;padding:0 4px;color:white;background:linear-gradient(90deg, #ff0204 60%, #ffb3b3);border-radius:12.5px;float:right;}
  .go_group>a{color:white;}
</style>
