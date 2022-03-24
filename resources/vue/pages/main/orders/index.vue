<template>
    <section>
        <g-toolbar @search="search = $event" :actions="buttons" />
        <v-container fluid grid-list-lg>
            <v-row>
                <v-col>
                    <v-autocomplete
                        label="Status"
                        :items="status"
                        v-model="filter.status"
                        solo
                        clearable
                        hide-details
                        @click.clear="initialize()"
                        @change="initialize()"
                    ></v-autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-data-table
                        height="700"
                        fixed-header
                        :headers="headers"
                        :items="data"
                        :search="search"
                        :options.sync="options"
                        class="transparent"
                        v-context-menu="ctx"
                    >
                        <template v-slot:item.order_time="{ item }">
                            {{ formatDate(item.order_time) }}
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
        <router-view></router-view>
    </section>
</template>
<route-meta>
      {
      "breadcrumb": "Orders"
      }
</route-meta>
<script>
import { mapActions } from "vuex";
export default {
    data() {
        return {
            status: 0,
            options: {
                type: 1,
            },
            filter: {},
            ctx: [
                {
                    text: "View Details",
                    icon: "mdi-eye",
                    action: (item) => {
                        this.$router.push(`/orders/${item.order_number}`);
                    },
                },
            ],
            buttons: [
                {
                    icon: "plus",
                    name: "Create",
                    props: {
                        to: "orders/create",
                        color: "primary",
                    },
                },
            ],
            search: null,
            status: [
                {
                    text: "Not Confirmed Order",
                    value: "1",
                },
                {
                    text: "Order Confirmed",
                    value: "2",
                },
                {
                    text: "Food Being Prepared",
                    value: "3",
                },
                {
                    text: "Food Pickup",
                    value: "4",
                },
                {
                    text: "Food Delivered",
                    value: "5",
                },
                {
                    text: "Cancelled",
                    value: "6",
                },
            ],
            headers: [
                {
                    text: "S.No",
                    align: "left",
                    sortable: true,
                    value: "id",
                },
                {
                    text: "Order Number",
                    align: "left",
                    sortable: true,
                    value: "order_number",
                },
                {
                    text: "Order Date",
                    align: "left",
                    sortable: true,
                    value: "order_time",
                },
            ],
            items: [],
            data: [],
        };
    },
    async created() {
        let vm = this;
        vm.initialize();
    },
    methods: {
        async initialize() {
            let vm = this;
            const { data } = await axios.get("/orders", {
                params: {
                    status: vm.filter.status,
                },
            });
            vm.data = data;
        },
        async delete(item) {
            let vm = this;
            const confirmed = await vm.$confirm(this.spiel.confirm, {
                color: "red",
            });
            if (confirmed) {
                try {
                    let id = item.id;
                    await this.remove({
                        id,
                        callback: (res) => {
                            if (res < 1 && res != "") {
                                vm.$toast.error("Item can not be deleted!");
                            } else {
                                vm.$toast(this.spiel.deleted, "success");
                            }
                        },
                    });
                    vm.getItems();
                } catch (error) {
                    vm.$toast.error(error);
                }
            }
        },
    },
};
</script>
<style lang=""></style>
