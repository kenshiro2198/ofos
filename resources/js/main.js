import Vue from "vue";
window._ = require("lodash");

import "@components";
import "@mixin";
import "./validators";
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
import Storage from "vue-ls";

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
    namespace: "vuejs__", // key prefix
    name: "ls", // name variable Vue.[ls] or this.[$ls],
    storage: "local", // storage name session, local, memory
};

Vue.use(Storage, options);
let token = document.head.querySelector('meta[name="csrf-token"]');

window.axios = _axios.create({
    baseURL: window.location.origin + "/web",
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": token.content,
    },
});
(async function () {
    if (!VueCookie.get("api_token")) {
        window.location = "/logout";
    }
    await axios.interceptors.request.use((config) => {
        store.state.app.loading = true;

        if (VueCookie.get("api_token") == "undefined") {
            window.location = "/logout";
            return;
        }
        config.headers["Authorization"] =
            "Bearer " + VueCookie.get("api_token");

        return config;
    });
    await axios.interceptors.response.use(
        (response) => {
            store.state.app.loading = false;
            return response;
        },
        (error) => {
            if (error.response.status === 401) {
                VueCookie.delete("api_token");
                window.location = "/logout";
            }
        }
    );
    Vue.use({
        install(Vue) {
            Vue.prototype.$busy = (busy) => {
                store.state.app.busy = busy === true ? busy : false;
            };
            Vue.prototype.eventBus = new Vue();
            // Vue.prototype.$confirm = ActionConfirm;
        },
    });
    const action = store._actions["app/fetchUser"][0];
    await action();
    window.app = new Vue({
        router,
        store,
        vuetify,
        render: (h) => h(App),
    }).$mount("#app");
})();
