<template>
  <div class="lists">
    <scroller>
      <div class="g-flex">
      <div class="search">
        <input type="text" class="search-input" placeholder="输入关键字搜索商品" placeholder-style="color:#aaa" v-model="key" @keyup.13="startSearch">
      </div>

      <span class="icon-filter" @click="isPopup=true"></span>
    </div>
		
    <goodsList :goodsData='goods' v-if="goods.length>0"></goodsList>

    <!-- 没有商品 -->
    <div class="hint-page" v-else>
      <img src="~images/nothing.png" />
      <p class="hint-page__text">还没有任何商品</p>
    </div>
    
    </scroller>
    <van-popup v-model="isPopup" position="right" @close="isPopup=false" class="popup">
      <from>
        <div class="popup-item">
          <p class="popup-item__tt">价格区间(元)</p>
          <div class="popup-item__price">
            <input type="number" class="popup-item__search" v-model="minPrice" data-index="1"><div class="popup-item__line">—</div><input type="number" class="popup-item__search" v-model="maxPrice" data-index="2">
          </div>
        </div>
        <div class="popup-item" v-for="(value,key) in sortList.top_list" v-if="sortList.sub_list[key]">
          <p class="popup-item__tt">{{value.title}}</p>
          <div class="popup-item__sort">
            <span v-for="item in sortList.sub_list[key]">
              <input type="checkbox" :id="item.id" :value="item.id" v-model="checkSort">
              <label :for="item.id">{{item.title}}</label>
            </span>
          </div>
        </div>

        <div class="popup-button">
          <button @click="reset" class="popup-button__reset">重置</button>
          <button @click="filterData" class="popup-button__sure">确定</button>
        </div>
      </from>
    </van-popup>
    

    <tabbar :checkedIndex="2"></tabbar>
  </div>
</template>

<script>
import search from "@/components/shop/search";
import goodsList from "@/components/shop/goodsList";
import { post,get, host} from "@/utils";
import tabbar from "@/components/tabbar";

export default {
  components: {
    goodsList,
    search,
    tabbar
    
  },

  data() {
    return {
      datas: [],
      goods: [],
      isPopup: false,
      minPrice: null,
      maxPrice: null,
      key: null,
      id: null,
      pid: null,
      tab: null,
      sortList: [],
      checkSort: []
    }
  },
  computed: {
    // 返回处理的分类列表
    categoryList () {
      
    }
  },
  methods: {
    reset(e) {
      console.log(e)
      this.minPrice = null
      this.maxPrice = null
      this.checkSort = []
    },
    startSearch() {
      const _this = this
      this.getData({
        search_key: _this.key
      })
    },
    filterData(e) {
      console.log(e)
      const _this = this;
      let opt = {
        cate_id: _this.checkSort.join(',')
      }
      if(this.minPrice && this.maxPrice) {
        opt.min_price = this.minPrice
        opt.max_price = this.maxPrice
      }
      post("shop/api/lists", opt).then(data => {
        console.log(data);
        _this.goods = data.goods;
      })
    
      this.isPopup = false;
    },
    setValue(e) {
      console.log(e);
      let val = e.target.value;
      let index = e.target.dataset.index;
      console.log(e,val,index);
      if (index == 1) {
        this.minPrice = val || 0;
      } else {
        this.maxPrice = val || 0;
      }
    },
    // 发送请求
    getData(opt) {
      var _this = this;
      post("shop/api/lists", opt).then(data => {
        console.log(data);
        _this.goods = data.goods;
      })
    },
    
    getQueryString (name) {
      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
      var r = window.location.search.substr(1).match(reg); 
      if (r != null) return unescape(r[2]); 
      return null; 
    }
  },
  activated() {
    if (this.$route.meta.isBack) {
      Object.assign(this.$data, this.$options.data())
      // console.log('走这里')
      const _this = this
      if(this.getQueryString('id')) {
        this.id = this.getQueryString('id').replace('/','')
        this.pid = this.getQueryString('pid').replace('/','')
      }
      
      if(!this.id) this.id = this.$route.params.id
      if(!this.pid) this.id = this.$route.params.pid
      this.tab = this.$route.params.tab
      this.key = this.$route.params.key

      
      // 同款
      if(this.tab) {
        console.log('tab不为空')
        this.getData({
          tab_goods_id:_this.id,
          tab: _this.tab
        })
      }
      // 搜索
      else if(this.key) {
        console.log('key不为空')
        this.getData({
          search_key: _this.key
        })
      } 
      // 分类
      else if(this.pid || this.id){
        console.log('pid不为空')
        this.getData({
          cate_id: _this.id,
          pid: _this.pid
        })
      }
    }
    this.$route.meta.isBack = false;
  },
  beforeRouteEnter (to, from, next) {
    if(to.params.id) {
      to.meta.isBack = true
    }
    next()
  },
  mounted() {
		console.log('===mounted===')
		console.log(this.$route.params)
     post("shop/api/lists", this.$route.params).then(res => {
        this.goods = res.goods;
      });
			// 获取分类
			post('shop/api/category').then(res => {
			  this.sortList = res
			})
  }

}
</script>

<style lang="scss" scoped>
.lists {
  padding-bottom: 45px
}
.popup {
  &-button {
    position: fixed;
    right: 10px;
    display: flex;
    bottom: 20px;
    &__reset,&__sure {
      height: 35px;
      line-height: 35px;
      min-width: 90px;
      font-size: 16px;
      color: #fff;
    }
    &__reset {
      border-top-left-radius: 30px;
      border-bottom-left-radius: 30px;
      margin-right: 2px;
      background: linear-gradient(90deg, #fcc706, #fb9800);
    }
    &__sure {
      border-top-right-radius: 30px;
      border-bottom-right-radius: 30px;
      background: linear-gradient(90deg, #f97b14, #ff5008);
    }
  }

  // 行
  &-item {
    margin-top: 10px;
    &__tt{
      font-size: 14PX;
      margin-bottom: 15px;
    }
    &__line {
      color: #999;
      margin: 0 10px;
    }
    &__price {
      display: flex;
      margin: 10px 0;
      align-items: center;
    }
    &__search {
      background: #f9f9f9;
      border-radius: 30px;
      max-width: 100px;
      padding: 8PX 15PX;
      font-size: 14px;
    }
    // 分类
    &__sort {
      display: flex;
      font-size: 12PX;
    }
    &__sort span {
        display: inline-flex;
        margin-right: 5px;
        width: 25%;
        text-align: center;
        border-radius: 3px;
        box-sizing: border-box;
        text-align: center;
        display: block;
        position: relative;
        height: 30px;
    }
    &__sort input {display: none;}
    &__sort label {
      height: 30px;
      position: absolute;
      left: 0;
      background: #f9f9f9;
      width: 100%;
      height: 100%;
      top: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  }
  input[type="checkbox"]:checked + label {
    background: rgba(255, 2, 4, 0.1);
    color: #ff0204;
  }

  
}

.lists {
  /deep/ .van-popup--right {
    width: 80%;
    height: 100vh;
    overflow-y: scroll;
    padding: 10px;
  }

  .g-flex {
    margin-bottom: $box-size;
    align-items: center;
    padding: 15px;
  }

  /deep/ .g-flex,
  /deep/ .goods-list__ft {
    background: #fff;
  }
  /deep/ .goods-list {
    padding: 0 5px;
  }
  /deep/ .search {
    flex: 1;
  }
  /deep/ .goods-list__img {
    background: #eee;
  }
}

.icon-filter {
  margin-left: 20px;
  background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo0RkU3MDcyQUQxRDIxMUU4OUI1Q0QxRTY1QkY1NjMyMSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo0RkU3MDcyQkQxRDIxMUU4OUI1Q0QxRTY1QkY1NjMyMSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjRGRTcwNzI4RDFEMjExRTg5QjVDRDFFNjVCRjU2MzIxIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjRGRTcwNzI5RDFEMjExRTg5QjVDRDFFNjVCRjU2MzIxIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+V61PqgAAAIhJREFUeNrslssNgCAQRFnFirQ3bcHirMgYSMCD8YgJDuTNges+sp8ZCyE4ZQ1OXAB+lU/vOGnSXecNmKW2LdZQi7M2RUBLd1B4BjkzAAIIIIANWd0sxna8rU4vzbRgdc8WL6QZ0gyAAAIIYN9pZq1Ucy+1ulppxrqyOl/0s+pphi0G8D9FAQYA2m0h9C4C0qEAAAAASUVORK5CYII=)
    no-repeat;
  background-size: 20px 17px;
  width: 20px;
  height: 20px;
  display: inline-block;
}
.search {
    background: url('~images/search.png') no-repeat -10px -10px;
    background-size: 34px;
    background-position: 10px;
    height: 35px;
    border: 1px solid $red;
    border-radius: 30px;
    overflow: hidden;
    &-input {
      width: 100%;
      margin-left:50px;
      height:35px;
      font-size: 14px;
      border: 0;
      background: transparent;
    }
}



</style>
