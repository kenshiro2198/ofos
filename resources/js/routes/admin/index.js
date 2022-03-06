import Vue from "vue";
import VueRouter from "vue-router";

import routes from "./routes";
import { createRouterLayout } from "vue-router-layout";
// import layout from "@layouts/main/index.vue";
const Error = () => import("@pages/error/404");

Vue.use(VueRouter);
const RouterLayout = createRouterLayout(layout => {
    // Resolves a layout component with layout type string.
    return import("@layouts/main/" + layout + ".vue");
});

export default new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            component: RouterLayout,
            children: [
                ...routes,
                {
                    name: "Error Page",
                    path: "*",
                    component: Error,
                    meta: {
                        ac: true
                    }
                }
            ]
        },
        {
            name: "Name",
            path: "*",
            component: Error,
            meta: {
                ac: true
            }
        }
    ]
});
