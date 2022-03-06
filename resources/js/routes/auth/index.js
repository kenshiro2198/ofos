import Vue from 'vue';
import VueRouter from 'vue-router';

import routes from "./routes";
import layout from "@layouts/auth/index.vue";

// const Error = ()=> import('@components/Error');

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            component: layout,
            children: [
                ...routes,
                // {
                //     name: "Error Page",
                //     path: "*",
                //     component: Error
                // }
            ]
        }
    ]
})