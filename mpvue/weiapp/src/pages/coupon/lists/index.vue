<template>
  <div class="coupon">
    <van-tabs :active="tabActive" bind:change="onChange" swipeable border="false" v-if="couponList">
      <van-tab title="未使用">
        <div class="coupon-not" v-for="(item, index) in couponList[0]" :key="index">
          <div class="coupon-item">
            <!-- 金额 -->
            <div class="coupon-item__l" v-if="item.money">
              <span class="coupon-item__price">{{item.money}}</span>
              <span class="f-font-sm">元</span>
            </div>

            <!-- 满减 -->
            <div class="coupon-item__c">
              <p>{{item.title}}</p>
              <p class="coupon-item__time">{{item.start_time}}-{{item.end_time}}</p>
            </div>

            <!-- 按钮 -->
            <div class="coupon-item__r">
              <a href="../../shop/index/index" open-type="switchTab" class="coupon-item__btn">去使用</a>
            </div>
          </div>
        </div>
      </van-tab>
      <van-tab title="已使用">
        <div class="coupon-done" v-for="(item, index) in couponList[1]" :key="index">
          <div class="coupon-item">
            <!-- 金额 -->
            <div class="coupon-item__l">
              <span class="coupon-item__price">{{item.money}}</span>
              <span class="f-font-sm">元</span>
            </div>

            <!-- 满减 -->
            <div class="coupon-item__c">
              <p>{{item.title}}</p>
              <p class="coupon-item__time">{{item.start_time}}-{{item.end_time}}</p>
            </div>

            <!-- 按钮 -->
            <div class="coupon-item__r">
              <button class="coupon-item__btn">已使用</button>
            </div>
          </div>
        </div>
      </van-tab>
    </van-tabs>
    <div class="hint-page" v-else>
        <img lazy-load :src="imgRoot+'error.png'">
        <p class="hint-page__text">你还没有过优惠卷</p>
      </div>
  </div>
</template>

<script>
import { get } from "@/utils";
export default {
  data() {
    return {
			imgRoot: this.imgRoot,
      tabActive: 0,
      couponList: []
    };
  },
  computed: {},

  components: {
  },

  methods: {},

  onLoad() {
    get(
      "coupon/api/personal/PHPSESSID/" +
        wx.getStorageSync("PHPSESSID")
    ).then(res => {
      console.log(res);
      this.couponList = res.lists;
      this.couponList.forEach((item, index) => {
        item.forEach((ite, idx) => {
          ite.money = parseInt(ite.money);
        });
      });
    });
  }
};
</script>


<style lang="scss" scoped>
  .hint-page {
    img,image {width: 30%;height:auto;}
  }
</style>
