<template>
    <v-app-bar
        dense
        color="primary"
        height="70"
        elevation="4"
        style="position: fixed; z-index: 999"
    >
        <v-img
            @click="$router.push('/')"
            src="/img/logo_transparent.png"
            max-height="100"
            max-width="50"
        >
        </v-img>
        <v-text-field
            class="ml-7"
            hide-details
            solo
            v-model="search"
            placeholder="Search for your favorite food"
            prepend-inner-icon="mdi-magnify"
        ></v-text-field>
        <v-spacer></v-spacer>

        <div class="ml-8 secondary--text">
            <v-btn
                color="secondary"
                text
                plain
                class="overline"
                @click="$router.push('/menu')"
            >
                Menu
            </v-btn>
            <v-btn color="secondary" text plain class="overline">
                Orders
            </v-btn>
            <v-btn color="secondary" text plain class="overline"> LOGIN </v-btn>
            |
            <v-btn color="secondary" text plain class="overline">
                REGISTER
            </v-btn>
            <v-btn color="secondary" elevation="0" class="overline white--text">
                <v-badge
                    color="tertiary"
                    light
                    class="primary--text"
                    :content="cart"
                    v-if="cart > 0"
                >
                    cart
                </v-badge>
                <span v-else> cart </span>
            </v-btn>
        </div>
    </v-app-bar>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import _ from "lodash";
export default {
    data() {
        return {
            items: [],
            search: "",
        };
    },
    async mounted() {
        let vm = this;
        const { data } = await axios.get("/guest/categories");
        vm.items = data;
        if (vm.$ls.get("cart")) {
            let cart = vm.$ls.get("cart");
            vm.setCart(cart.length);
        }
    },
    computed: {
        ...mapState({
            cart: (state) => state.app.cart,
        }),
    },
    created() {},
    watch: {
        search: _.debounce(async function (value) {
            let vm = this;
            vm.setSearch(value);
            if (vm.$route.name !== "menu-product-search") {
                vm.$router.push("/menu/product-search");
            }
            if (value && vm.$route.name !== "menu-index") {
                vm.$router.push("/menu");
                setTimeout(() => {
                    vm.$router.push("/menu/product-search");
                }, 400);
            }
            if (value == "") {
                vm.$router.push("/menu");
            }
            vm.$forceUpdate();
        }, 500),
    },
    methods: {
        ...mapMutations({
            setCart: "app/setCart",
            setSearch: "app/setSearch",
        }),
    },
};
</script>
<style scoped>
.text {
    font-size: 18px;
    font-weight: 500;
    line-height: 1.1;
    color: inherit;
}
.v-badge__badge {
    color: #000 !important;
}
</style>
