<script>
const common = require("@/utils/common");
import { host } from "@/utils";
export default {
  globalConfig: {
    usingComponents: {
      "van-stepper": "/static/vant-weapp/dist/stepper/index",
      'van-icon': '/static/vant-weapp/dist/icon/index',
      'van-popup': '/static/vant-weapp/dist/popup/index',
      'van-checkbox': '/static/vant-weapp/dist/checkbox/index',
      'van-checkbox-group': '/static/vant-weapp/dist/checkbox-group/index',
      'van-radio': '/static/vant-weapp/dist/radio/index',
      'van-radio-group': '/static/vant-weapp/dist/radio-group/index',
      'van-dialog': '/static/vant-weapp/dist/dialog/index',
      'van-loading': '/static/vant-weapp/dist/loading/index',
      'van-toast': '/static/vant-weapp/dist/toast/index',
      'van-tab': '/static/vant-weapp/dist/tab/index',
      'van-tabs': '/static/vant-weapp/dist/tabs/index',
			"van-cell": "/static/vant-weapp/dist/cell/index",
			"van-cell-group": "/static/vant-weapp/dist/cell-group/index"
    }
  },
  data() {
    return {
      PHPSESSID: "",
      common: common
    };
  },
  onLaunch(options) {
    var from_uid =
      options.query.from_uid == undefined ? "0" : options.query.from_uid;
    if (from_uid != 0) {
      wx.setStorageSync("from_uid", from_uid);
    }

    common.initApp(host + "weiapp/Api/", true);
  }
};
</script>

<style lang="scss">
@import "../static/styles/base.scss";

/* this rule will be remove */
* {
  transition: width 2s;
  -moz-transition: width 2s;
  -webkit-transition: width 2s;
  -o-transition: width 2s;
}
</style>
