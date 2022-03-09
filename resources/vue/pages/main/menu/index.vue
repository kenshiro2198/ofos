<template>
    <div>
        <g-quantity
            v-if="addToCartDialog"
            :dialog="addToCartDialog"
            v-model="selectedItem"
            @close="closeDialog"
            @add="add"
            @update="closeDialog"
            :update-mode="update"
        ></g-quantity>
        <v-lazy
            v-model="isActive"
            :options="{
                threshold: 0.5,
            }"
            min-height="200"
            transition="fade-transition"
        >
            <div>
                <v-container>
                    <v-row>
                        <v-col cols="9">
                            <!-- <v-card elevation="0"> -->
                            <v-data-iterator hide-default-footer :items="items">
                                <v-row>
                                    <template v-if="loadingItems">
                                        <v-col
                                            cols="12"
                                            sm="6"
                                            xl="4"
                                            v-for="index in 6"
                                            :key="index"
                                        >
                                            <v-skeleton-loader
                                                class="mx-auto"
                                                max-width="300"
                                                type="card"
                                            ></v-skeleton-loader>
                                        </v-col>
                                    </template>
                                    <template v-else>
                                        <v-col
                                            v-for="(item, index) in items"
                                            :key="index"
                                            cols="12"
                                        >
                                            <v-card-text
                                                class="font-weight-bold"
                                            >
                                                {{ item.name }}
                                            </v-card-text>
                                            <v-data-iterator
                                                hide-default-footer
                                                :items="item.items"
                                            >
                                                <v-row>
                                                    <v-col
                                                        :cols="2"
                                                        v-for="(
                                                            product,
                                                            productIndex
                                                        ) in item.items"
                                                        :key="productIndex"
                                                    >
                                                        <v-card
                                                            height="100%"
                                                            width="200"
                                                            @click="
                                                                addToCart(
                                                                    product
                                                                )
                                                            "
                                                        >
                                                            <v-card-text>
                                                                <v-img
                                                                    max-height="100"
                                                                    :src="
                                                                        '/img/' +
                                                                        product.image
                                                                    "
                                                                ></v-img>
                                                            </v-card-text>
                                                            <v-card-text>
                                                                <div
                                                                    class="text-left"
                                                                >
                                                                    {{
                                                                        product.name
                                                                    }}
                                                                </div>
                                                            </v-card-text>
                                                            <v-divider></v-divider>
                                                            <v-card-text>
                                                                <div
                                                                    class="text-left font-weight-bold title"
                                                                >
                                                                    PHP
                                                                    {{
                                                                        product.price
                                                                    }}
                                                                </div>
                                                            </v-card-text>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                            </v-data-iterator>
                                        </v-col>
                                    </template>
                                </v-row>
                            </v-data-iterator>
                        </v-col>
                    </v-row>
                </v-container>
            </div>
        </v-lazy>
    </div>
</template>
<route-meta>{ "breadcrumb": "Home"}</route-meta>
<script>
import { mapState, mapMutations } from "vuex";
export default {
    data() {
        return {
            page: 1,
            isActive: false,
            items: [],
            length: 0,
            loadingItems: true,
            addToCartDialog: false,
            update: false,
            selectedItem: {},
            images: ["/img/topbg.jpg", "/img/sckss.jpg", "/img/gmash.jpg"],
        };
    },
    async created() {
        let vm = this;
        vm.refresh();
    },
    computed: {
        ...mapState({
            cart: (state) => state.app.cart,
        }),
    },
    methods: {
        ...mapMutations({
            setCart: "app/setCart",
        }),
        async refresh() {
            let vm = this;
            vm.loadingItems = true;
            setTimeout(async () => {
                const { data } = await axios.get(`/guest/category/items`);
                vm.items = data;
                vm.loadingItems = false;
            }, 400);
        },
        addToCart(value) {
            let vm = this;
            if (this.$ls.get("cart")) {
                vm.$ls.get("cart").forEach((item) => {
                    if (item.id == value.id) {
                        vm.update = true;
                    }
                });
            }
            vm.addToCartDialog = true;
            vm.selectedItem = value;
        },
        closeDialog() {
            let vm = this;
            vm.addToCartDialog = false;
            vm.update = false;
            vm.selectedItem = {};
        },
        add(value) {
            let vm = this;
            let cart;
            if (vm.$ls.get("cart")) {
                cart = vm.$ls.get("cart");
            } else {
                cart = [];
            }
            cart.push(value);
            vm.$ls.set("cart", cart);
            if (vm.$ls.get("cart")) {
                cart = vm.$ls.get("cart");
                vm.setCart(cart.length);
            }
            vm.update = false;
            vm.addToCartDialog = false;
            vm.selectedItem = {};
        },
    },
};
</script>
<style lang=""></style>
