<template>
    <div style="position: fixed; right: 0; top: 7%; z-index: 998">
        <v-card height="89vh" width="350" class="mx-auto">
            <!-- <v-card-title> -->
            <div class="pa-2 text-center">My Bag</div>
            <v-divider></v-divider>
            <!-- </v-card-title> -->
            <v-container>
                <v-row class="ma-3">
                    <v-col>
                        <v-data-iterator :items="items" hide-default-footer>
                            <v-row v-for="(item, index) in items" :key="index">
                                <v-btn
                                    color="secondary"
                                    x-small
                                    icon
                                    @click="decrease(index)"
                                >
                                    <v-icon>mdi-minus-circle-outline</v-icon>
                                </v-btn>
                                <div class="ml-3">
                                    {{ item.qty }}
                                </div>
                                <v-btn
                                    color="secondary"
                                    x-small
                                    icon
                                    class="ml-3"
                                    @click="increase(index)"
                                >
                                    <v-icon>mdi-plus-circle-outline</v-icon>
                                </v-btn>
                                <div class="ml-3">
                                    <v-row class="mt-0 ml-2 mr-2">
                                        {{ item.name }}
                                    </v-row>
                                    <v-row class="ml-2 mr-2">
                                        <div
                                            class="secondary--text"
                                            style="cursor: pointer"
                                            @click
                                        >
                                            Edit
                                        </div>
                                    </v-row>
                                </div>
                                <div class="ml-3">
                                    ₱ {{ item.qty * item.price }}.00
                                </div>
                            </v-row>
                        </v-data-iterator>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </div>
</template>
<script>
export default {
    data() {
        return {
            items: [
                { title: "Dashboard", icon: "mdi-view-dashboard" },
                { title: "Photos", icon: "mdi-image" },
                { title: "About", icon: "mdi-help-box" },
            ],
            right: null,
        };
    },
    created() {
        let vm = this;
        if (vm.$ls.get("cart")) {
            vm.items = vm.$ls.get("cart");
        }
    },
    methods: {
        decrease(index) {
            let vm = this;
            if (vm.items[index].qty != 0) {
                vm.items[index].qty -= 1;
            }
        },
        increase(index) {
            let vm = this;
            vm.items[index].qty += 1;
        },
    },
};
</script>
<style lang=""></style>
