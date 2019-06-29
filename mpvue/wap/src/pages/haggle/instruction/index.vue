<template>
  <div class="instruction">
    <navbar :text="eventinfo.title"></navbar>
    <scroller>
    <div class="null_instruction" v-if="content == null">
      <img src="~images/null.png"><br>
      <span>暂无活动说明</span>
    </div>
    <div class="instruction_content" v-else v-html="content"></div>
    </scroller>
  </div>
</template>

<script>
  import {post, host} from "@/utils";
  import navbar from "@/components/navbar";

  export default {
      data() {
          return {
              eventinfo: {},
              content: ''
          }
      },
      components: {
          navbar
      },
      methods: {},
      created() {
          var eventinfoid = this.$route.params.eventinfoid
          post(host + "/haggle/Api/intro", {
              id: eventinfoid
          }).then((data) => {
              this.eventinfo = data.event_info;
              this.content = data.event_info.content.replace(/\<img/gi, '<img style="width:100% !important;height:auto" ')
          })
      }
  }
</script>

<style>
.null_instruction, .instruction_content{padding:0 10px;}
</style>
