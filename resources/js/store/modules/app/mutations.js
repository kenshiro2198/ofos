import { set, toggle } from "@js/utils/vuex";

export default {
    setUser: set("user"),
    toggleUser: toggle("user"),
    setCart: set("cart"),
    toggleCart: toggle("cart"),
    setSearch: set("search"),
    toggleSearch: toggle("search"),
};
