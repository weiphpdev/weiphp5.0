<template>
  <div class="active_lists">
    <navbar text="所有秒杀活动"></navbar>
    <scroller>
    <van-tabs v-model="tabActive" border="false" sticky swipeable>
      <van-tab title="正在疯抢">
        <activeLists activeType="2" :activeData="datas.on_going"></activeLists>
      </van-tab>
      <van-tab title="即将开抢">
        <activeLists activeType="2" :isStart="false" :activeData="datas.not_start"></activeLists>
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
    get("shop/api/getEventLists/event_type/2").then(res => {
      this.datas = res;
    });
  }
};
</script>
<style lang="scss" scoped>

</style>
