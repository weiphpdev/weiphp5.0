<template>
  <div class="haggle_top">
    <div class="inline" v-for="(list, index) in lists" :key="index">
      <div class="avatar">
        <img :src="list.headimgurl">
      </div>
      <div class="haggle_content">
        <span>{{list.content}}</span>
      </div>
    </div>
  </div>
</template>
<script>
  import {post, host} from "@/utils"
  export default {
    data() {
      return {
        eventinfo: {},
        lists: []
      }
    },
    created () {
      var orderid = this.$root.$mp.query.orderid
      var haggleid = this.$root.$mp.query.haggleid
      console.log(orderid)
      post(host + "/haggle/Api/haggle_top", {
        order_id: orderid,
        haggle_id: haggleid
      }).then((data) => {
        this.eventinfo = data.event_info
        this.lists = data.lists
    })
    }
  }
</script>
<style lang="scss" scoped>
  .haggle_top{margin:5px;}
  .inline{display:inline-flex;margin:3px 0;padding:5px 0 10px;border-bottom:1px solid #ddd;}
  .avatar{width:40px;height:40px;}
  .avatar>img{height:40px;border-radius:50%;}
  .haggle_content{height:40px;overflow:hidden;line-height: 20px;font-size:14px;}
</style>
