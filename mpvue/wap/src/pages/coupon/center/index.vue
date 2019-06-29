<template>
  <div class="seckill_lists">
    <navbar text="领劵中心"></navbar>
    <scroller>
    <van-tabs v-model="tabActive" border="false" sticky swipeable>
      <van-tab title="正在疯抢">
        <activeLists activeType="4" :activeData="datas.on_going"></activeLists>
      </van-tab>
      <van-tab title="即将开抢">
        <activeLists activeType="4" :isStart="false" :activeData="datas.not_start"></activeLists>
      </van-tab>
    </van-tabs>
    </scroller>
  </div>
</template>

<script>
import { post, get, host } from "@/utils";
import navbar from "@/components/navbar";
import activeLists from "@/components/activeLists";
export default {
  data() {
    return {
      datas: [],
      going: [],
      end: [],
      notStart: [],
      tabActive: 0

    };
  },
  components: {
    navbar,
    activeLists
  },
  methods: {},
  created() {
    get("shop/api/getEventLists/event_type/4").then(res => {
      this.datas = res;
      this.going = res.on_going
      this.end = res.end
      this.not_start = res.not_start
    });
  }
};
</script>
<style lang="scss" scoped>
.seckill_lists {
  padding-top: 45px;
}


</style>
