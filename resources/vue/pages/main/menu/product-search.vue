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
                    <v-row align="center" justify="center">
                        <v-col align-self="center" cols="9">
                            <v-card
                                color="background"
                                elevation="0"
                                :height="
                                    (items.length >= 1 &&
                                        items.length <= 6 &&
                                        !loadingItems) ||
                                    items.length == 0
                                        ? '700'
                                        : ''
                                "
                            >
                                <v-card-title>
                                    <div class="font-weight-bold">
                                        Search results for “{{ search }}” ({{
                                            items.length
                                        }})
                                    </div>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
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
                                                    v-for="(
                                                        item, index
                                                    ) in items"
                                                    :key="index"
                                                    cols="12"
                                                    sm="6"
                                                    xl="4"
                                                >
                                                    <v-card
                                                        height="100%"
                                                        max-width="300"
                                                        @click="addToCart(item)"
                                                    >
                                                        <v-img
                                                            max-height="200"
                                                            :src="
                                                                '/img/' +
                                                                item.image
                                                            "
                                                            contain
                                                        ></v-img>
                                                        <div
                                                            class="d-flex flex-no-wrap justify-space-between"
                                                        >
                                                            <div>
                                                                <v-card-title
                                                                    v-text="
                                                                        item.name
                                                                    "
                                                                ></v-card-title>

                                                                <v-card-subtitle
                                                                    class="text-left font-weight-bold title"
                                                                    >PHP
                                                                    {{
                                                                        item.price
                                                                    }}</v-card-subtitle
                                                                >
                                                            </div>
                                                        </div>
                                                    </v-card>
                                                </v-col>
                                            </template>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </div>
        </v-lazy>
    </div>
</template>
<route-meta>{ "breadcrumb": "Home"}</route-meta>
<script>
import { mapState } from "vuex";
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
    computed: {
        ...mapState({
            search: (state) => state.app.search,
        }),
    },
    async created() {
        let vm = this;
        vm.refresh();
    },
    watch: {
        search(newValue, oldValue) {
            console.log(`Updating from ${oldValue} to ${newValue}`);

            // Do whatever makes sense now
            if (newValue === "success") {
                this.complex = {
                    deep: "some deep object",
                };
            }
        },
    },
    methods: {
        async refresh() {
            let vm = this;
            vm.loadingItems = true;
            setTimeout(async () => {
                let route = `/guest/items?search=${vm.search}`;
                if (vm.search == "") {
                    vm.$router.push("/menu");
                }
                const { data } = await axios.get(route);
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
