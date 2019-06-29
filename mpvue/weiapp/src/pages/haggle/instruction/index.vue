<template>
  <div class="instruction">
    <div class="null_instruction" v-if="content == ''">
      <img lazy-load :src="imgRoot+'null.png'"><br>
      <span>暂无活动说明</span>
    </div>
    <div v-else v-html="content">
    </div>
  </div>
</template>

<script>
  import {post, host} from "@/utils"
  export default {
    data () {
      return {
				imgRoot: this.imgRoot,
        eventinfo: {},
        content: ''
      }
    },
    methods: {
    },
    onLoad () {
      var eventinfoid = this.$root.$mp.query.eventinfoid
      post(host+"/haggle/Api/intro", {
        id: eventinfoid
      }).then((data) => {
        this.eventinfo = data.event_info;
        this.content = data.event_info.content.replace(/\<img/gi, '<img lazy-load style="width:100% !important;height:auto" ');
    })
    }
  }
</script>

<style>

</style>
