import ContextMenu from "./ContextMenu";
import vuetify from "@js/plugins/vuetify";

export default {
    install(Vue, options) {
        let menu = undefined;
        let cmp = undefined;
        const clicked = (value, item) => {
            if (typeof value.enable == "undefined" || value.enable) {
                menu.show(item, cmp);
                document
                    .querySelector('[role="menu"]')
                    .addEventListener("mouseleave", menu.hide);
            }
        };
        Vue.directive("context-menu", {
            bind(el, binding, vnode) {
                let value = binding.value;
                cmp = vnode.componentInstance;
                if (typeof value == "string") {
                    cmp.$on("click:row", item => {
                        const toast = value.split(":");
                        app.$toast[toast[0]](toast[1]);
                    });
                    value = [];
                } else {
                    cmp.$on("click:row", item => clicked(value, item));
                }
                menu = new Vue(
                    Object.assign({
                            vuetify
                        },
                        ContextMenu, {
                            propsData: {
                                items: value.items || value
                            }
                        }
                    )
                );
                menu.$mount();
            },
            update(el, binding, vnode) {
                let value = binding.value;
                cmp.$off("click:row");
                if (typeof value == "string") {
                    cmp.$on("click:row", item => {
                        const toast = binding.value.split(":");
                        app.$toast[toast[0]](toast[1]);
                    });
                    value = [];
                } else {
                    menu.items = value.items || value;
                    cmp.$on("click:row", item => clicked(value, item));
                }
            }
        });
    }
};
