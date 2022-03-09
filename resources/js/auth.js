import Vue from 'vue';
import App from "@/App";
import store from "@js/store";
import VueCookie from "vue-cookie";
import vuetify from "@js/plugins/vuetify";
import router from "@routes/auth";
import VeeValidate from "vee-validate";
import axios from "axios";
Vue.use(VeeValidate);
Vue.use(VueCookie);
Vue.config.productionTip = false;

window.axios = axios;
let token = document.head.querySelector('meta[name="csrf-token"]');
window.axios = _axios.create({
    baseURL: window.location.origin + "/guest",
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": token.content
    }
});

VeeValidate.Validator.extend("verify_password", {
    getMessage: field =>
        `The password must contain at least: 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character`,
    validate: value => {
        var strongRegex = new RegExp(
            "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*?+-.,:;_=])(?=.{8,})"
        );
        return strongRegex.test(value);
    }
});

window.app = new Vue({
    router,
    store,
    vuetify,
    render: h => h(App)
}).$mount("#app");