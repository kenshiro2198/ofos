<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="500" @click:outside="$emit('close')">
            <v-card :loading="loading">
                <template slot="progress">
                    <v-progress-linear
                        color="deep-purple"
                        height="10"
                        indeterminate
                    ></v-progress-linear>
                </template>

                <v-img height="250" :src="`/img/${value.image}`"></v-img>

                <v-card-title>{{ value.name }}</v-card-title>

                <v-card-text>
                    <div>
                        {{ value.description }}
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="secondary" x-small fab @click="decrease">
                        <v-icon>mdi-minus</v-icon>
                    </v-btn>
                    <div class="font-weight-bold ml-3">{{ qty }}</div>
                    <v-btn
                        color="secondary"
                        x-small
                        fab
                        class="ml-3"
                        @click="increase"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>

                    <v-btn
                        v-if="updateMode"
                        @click="updateToCart"
                        color="secondary"
                        style="font-size: 12px"
                        class="primary--text"
                    >
                        Update to Cart
                    </v-btn>
                    <v-btn
                        v-else
                        @click="addToCart"
                        color="secondary"
                        style="font-size: 12px"
                        class="primary--text"
                    >
                        Add to Cart
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    props: {
        value: Object,
        updateMode: Boolean,
    },
    data() {
        return {
            dialog: true,
            loading: false,
            form: {},
            qty: 1,
        };
    },
    created() {
        let vm = this;
        if (vm.updateMode) {
            let items = vm.$ls.get("cart");
            items.forEach((item) => {
                if (item.id == vm.value.id) {
                    vm.qty = item.qty;
                }
            });
        }
    },
    methods: {
        addToCart() {
            let vm = this;
            vm.form = {
                id: vm.value.id,
                name: vm.value.name,
                image: vm.value.image,
                price: vm.value.price,
                qty: vm.qty,
            };
            vm.$emit("add", vm.form);
        },
        updateToCart() {
            let vm = this;
            let items = vm.$ls.get("cart");
            items.forEach((item) => {
                if (item.id == vm.value.id) {
                    item.qty = vm.qty;
                }
            });
            vm.$ls.set("cart", items);
            vm.$emit("update");
        },
        decrease() {
            let vm = this;
            if (vm.qty != 0) {
                vm.qty -= 1;
            }
        },
        increase() {
            let vm = this;
            vm.qty += 1;
        },
    },
};
</script>
<style scoped>
tr.row-is-bordered td {
    border-right: thin solid #dbdbdb !important;
}
.v-dialog {
    box-shadow: 0px 0px 0px 0px rgb(0 0 0 / 0%), 0px 0px 0px 0px rgb(0 0 0 / 0%),
        0px 0px 0px 0px rgb(0 0 0 / 0%) !important;
}
</style>
