<template>
  <div class="coupon_center">
    <van-tabs v-model="tabActive" border="false" sticky swipeable>
      <van-tab title="正在疯抢">
        <activeLists activeType="4" :activeData="datas.on_going"></activeLists>
      </van-tab>
      <van-tab title="即将开抢">
        <activeLists activeType="4" :activeData="datas.not_start" :isStart="false"></activeLists>
      </van-tab>
    </van-tabs>
  </div>
</template>

<script>
import { post, get, host } from "@/utils";
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
    activeLists
  },
  methods: {},
  onLoad() {
    get("shop/api/getEventLists/event_type/4").then(res => {
      this.datas = res;
    });
  }
};
</script>
<style lang="scss" scoped>


</style>
