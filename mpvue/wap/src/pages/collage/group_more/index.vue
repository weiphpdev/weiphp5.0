<template>
  <div class="group_more" >
    <div class="group_record" v-for="(list ,index) in collagegroup.lists" :key="index">
      <div class="record_item">
        <div class="record_header">
          <img class="headimgurl" :src='list.headimgurl'>
          <div class="differ_num">
            <p>{{list.nickname}}</p>
            <small class="differ_info">还差<strong class="red">{{list.need_count}}人</strong>拼成,剩余 <strong
              class="group_time" rel=""></strong>{{list.left_time}} 结束
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
    <van-toast id="van-toast"/>
  </div>
</template>
<script>
  import {post, host, login} from "@/utils"
  import { ImagePreview, Toast, Popup, Tabs, tab} from "vant";
  export default {
    data () {
      return {
        collagegroup: {},
        eventinfo: {}
      }
    },
    components: {

    },
    methods: {

    },
    created () {
      var goodsid = this.$route.params.goodsid;
      var collageid = this.$route.params.collageid;
      post(host + "/collage/Api/group_more", {
        goods_id:goodsid,
        collage_id: collageid,
        PHPSESSID: window.localStorage.getItem('PHPSESSID')
      }).then((data) => {
        if(data.code == 0){
          Toast(data.res)
        }else{
          this.collagegroup = data.collage_group;
          this.eventinfo = data.eventinfo;
        }
      })

    }
  }

</script>

<style lang="scss" scoped>
  p{margin:0;}
  .group_record{width:90%;margin:5px 5%;background:white;}
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
