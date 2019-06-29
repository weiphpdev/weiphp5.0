<template>
  <div class="instruction">
    <div v-html="eventinfo.intro"></div>
    <div v-show="eventinfo.intro == null || eventinfo.intro == ''" class="about_collage">
      <h3>什么是多人拼团？</h3>
      <p>多人拼团(以下简称：拼团)是指由多人拼单购买的团购活动， 通过拼团买家可以享受比一般网购更低的价格。
      </p>
      <h3>怎么算拼团成功？</h3>
      <p>每一个团的有效期为24小时，在有效期内找到满足人数的好 友参加拼团，即可算拼团成功
      </p>
      <h3>拼团失败，怎样退款？</h3>
      <p>若24小时内没有凑齐人数，即算拼团失败，系统自动会将所 支付的货款原路退回，具体到账时间已各银行为准。
      </p>
    </div >
  </div>
</template>

<script>
  import {post, host} from "@/utils"
  export default {
    data () {
      return {
        eventinfo: {}
      }
    },
    methods: {
    },
    onLoad () {
      var eventinfoid = this.$root.$mp.query.eventinfoid
      post(host+"/collage/Api/intro", {
        id: eventinfoid
      }).then((data) => {
        this.eventinfo = data.event_info
    })
    }
  }
</script>
<style>
 .about_collage{padding:10px;}
 h3{font-weight:bold;}
 p{font-size:14px;margin:10px;}
</style>
