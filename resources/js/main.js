import Vue from "vue";
window._ = require("lodash");
import "@components";
import "@mixin";
import App from "@/App";
import store from "@js/store";
import vuetify from "@js/plugins/vuetify";

import VValidate from "vee-validate";
import PortalVue from "portal-vue";
import router from "@routes/main";
import _axios from "axios";
import VueCookie from "vue-cookie";
import ToastSnackBar from "@/components/toast-snackbar";
import ActionConfirm from "@/components/action-confirm";
import BreadCrumbs from "@/components/BreadCrumbs";
import ContextMenu from "@components/context-menu";
import DateInputPicker from "@components/date-input-picker";
import vvBtn from "@components/vvBtn";
import Storage from 'vue-ls';

Vue.use(VValidate);
Vue.use(PortalVue);
Vue.use(VueCookie);
Vue.use(ActionConfirm);
Vue.use(ToastSnackBar);
Vue.use(require("vue-moment"));
Vue.use(ContextMenu);

Vue.component("bread-crumbs", BreadCrumbs);
Vue.component("date-input-picker", DateInputPicker);
Vue.component("vv-btn", vvBtn);
let options = {
    namespace: 'vuejs__', // key prefix
    name: 'ls', // name variable Vue.[ls] or this.[$ls],
    storage: 'local' // storage name session, local, memory
  };

let token = document.head.querySelector('meta[name="csrf-token"]');
Vue.use(Storage, options);
Vue.config.productionTip = false;

window.axios = _axios


window.app = new Vue({
    router,
    store,
    vuetify,
    render: h => h(App)
}).$mount("#app");