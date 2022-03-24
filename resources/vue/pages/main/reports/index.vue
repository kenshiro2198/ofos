<template>
    <section>
        <g-toolbar />
        <v-container fluid grid-list-lg>
            <v-row>
                <v-col>
                    <v-card>
                        <v-tabs v-model="tab">
                            <v-tab v-for="item in items" :key="item">
                                {{ item }}
                            </v-tab>
                        </v-tabs>
                        <v-tabs-items v-model="tab">
                            <v-tab-item v-for="item in items" :key="item">
                                <v-card>
                                    <v-card-text>
                                        <v-row>
                                            <v-col>
                                                <date-input-picker
                                                    solo
                                                    v-model="filter.from"
                                                    hide-details
                                                ></date-input-picker>
                                            </v-col>
                                            <v-col>
                                                <date-input-picker
                                                    solo
                                                    v-model="filter.to"
                                                    hide-details
                                                ></date-input-picker>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                class="mt-0 mb-0"
                                                v-if="tab == 0"
                                            >
                                                <v-autocomplete
                                                    label="Request Type"
                                                    :items="status"
                                                    v-model="filter.status"
                                                    solo
                                                    chips
                                                    deletable-chips
                                                    multiple
                                                    hide-details
                                                    clearable
                                                    @click.clear="
                                                        betweenDates()
                                                    "
                                                    @change="betweenDates()"
                                                ></v-autocomplete>
                                            </v-col>
                                            <v-col v-if="tab == 2">
                                                <v-btn-toggle
                                                    mandatory
                                                    v-model="filter.type"
                                                >
                                                    <v-btn> Month </v-btn>

                                                    <v-btn> YEAR </v-btn>
                                                </v-btn-toggle>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-title>
                                        <div
                                            class="text-center"
                                            v-if="tab == 0"
                                        >
                                            Report from
                                            {{
                                                formatDate(
                                                    filter.from,
                                                    "MM/DD/YYYY"
                                                )
                                            }}
                                            to
                                            {{
                                                formatDate(
                                                    filter.to,
                                                    "MM/DD/YYYY"
                                                )
                                            }}
                                        </div>
                                        <div
                                            class="text-center"
                                            v-if="tab == 1"
                                        >
                                            Order Count Report from
                                            {{
                                                formatDate(
                                                    filter.from,
                                                    "MM/DD/YYYY"
                                                )
                                            }}
                                            to
                                            {{
                                                formatDate(
                                                    filter.to,
                                                    "MM/DD/YYYY"
                                                )
                                            }}
                                        </div>
                                        <div
                                            class="text-center"
                                            v-if="tab == 2"
                                        >
                                            Sales Report from

                                            {{
                                                filter.type == 1
                                                    ? formatDate(
                                                          filter.from,
                                                          "YYYY"
                                                      )
                                                    : formatDate(
                                                          filter.from,
                                                          "MM/YYYY"
                                                      )
                                            }}
                                            to
                                            {{
                                                filter.type == 1
                                                    ? formatDate(
                                                          filter.to,
                                                          "YYYY"
                                                      )
                                                    : formatDate(
                                                          filter.to,
                                                          "MM/YYYY"
                                                      )
                                            }}
                                        </div>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-data-table
                                            v-if="tab == 0"
                                            height="700"
                                            fixed-header
                                            :headers="headers"
                                            :items="data"
                                            class="transparent"
                                            v-context-menu="ctx"
                                        >
                                            <template
                                                v-slot:item.order_time="{
                                                    item,
                                                }"
                                            >
                                                {{
                                                    formatDate(item.order_time)
                                                }}
                                            </template>
                                        </v-data-table>
                                        <v-simple-table v-if="tab == 1">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        Date
                                                    </th>
                                                    <th class="text-left">
                                                        Total Orders
                                                    </th>
                                                    <th class="text-left">
                                                        Total Orders Not
                                                        Confirmed
                                                    </th>
                                                    <th class="text-left">
                                                        Total Orders Confirmed
                                                    </th>
                                                    <th class="text-left">
                                                        Total Orders Cancelled
                                                    </th>
                                                    <th class="text-left">
                                                        Total Orders Being
                                                        Prepared
                                                    </th>
                                                    <th class="text-left">
                                                        Total Orders Pickup
                                                    </th>
                                                    <th class="text-left">
                                                        Total Orders Delivered
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(
                                                        item, index
                                                    ) in data"
                                                    :key="index"
                                                >
                                                    <td>
                                                        {{
                                                            formatDate(
                                                                item.lMonth +
                                                                    "/01/" +
                                                                    item.lYear,
                                                                "MMMM/YYYY"
                                                            )
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{ item.totalOrder }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            item.totalUnconfirmedOrder
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            item.totalConfirmedOrder
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            item.totalBeingPreparedOrder
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            item.totalPickupOrder
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            item.totalDeliveredOrder
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            item.totalCancelledOrder
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="
                                                            border-top: solid
                                                                black 1px;
                                                        "
                                                        class="font-weight-bold"
                                                    >
                                                        TOTAL
                                                    </td>
                                                    <td
                                                        style="
                                                            border-top: solid
                                                                black 1px;
                                                        "
                                                    >
                                                        {{
                                                            getTotal(
                                                                data,
                                                                "totalOrder"
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        style="
                                                            border-top: solid
                                                                black 1px;
                                                        "
                                                    >
                                                        {{
                                                            getTotal(
                                                                data,
                                                                "totalUnconfirmedOrder"
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        style="
                                                            border-top: solid
                                                                black 1px;
                                                        "
                                                    >
                                                        {{
                                                            getTotal(
                                                                data,
                                                                "totalConfirmedOrder"
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        style="
                                                            border-top: solid
                                                                black 1px;
                                                        "
                                                    >
                                                        {{
                                                            getTotal(
                                                                data,
                                                                "totalBeingPreparedOrder"
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        style="
                                                            border-top: solid
                                                                black 1px;
                                                        "
                                                    >
                                                        {{
                                                            getTotal(
                                                                data,
                                                                "totalPickupOrder"
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        style="
                                                            border-top: solid
                                                                black 1px;
                                                        "
                                                    >
                                                        {{
                                                            getTotal(
                                                                data,
                                                                "totalDeliveredOrder"
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        style="
                                                            border-top: solid
                                                                black 1px;
                                                        "
                                                    >
                                                        {{
                                                            getTotal(
                                                                data,
                                                                "totalCancelledOrder"
                                                            )
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </v-simple-table>
                                        <v-simple-table v-if="tab == 2">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        S.No
                                                    </th>
                                                    <th class="text-left">
                                                        {{
                                                            filter.type == 1
                                                                ? "Year"
                                                                : "Month \ Year"
                                                        }}
                                                    </th>
                                                    <th class="text-left">
                                                        Sales
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(
                                                        item, index
                                                    ) in data"
                                                    :key="index"
                                                >
                                                    <td>{{ index + 1 }}</td>
                                                    <td>
                                                        {{
                                                            filter.type == 1
                                                                ? item.lYear
                                                                : formatDate(
                                                                      item.lMonth +
                                                                          "/01/" +
                                                                          item.lYear,
                                                                      "MMMM/YYYY"
                                                                  )
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            currency(
                                                                item.totalItemPrice
                                                            )
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </v-simple-table>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                        </v-tabs-items>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <router-view></router-view>
    </section>
</template>
<route-meta>
      {
      "breadcrumb": "Reports"
      }
</route-meta>
<script>
import { mapActions } from "vuex";
export default {
    data() {
        var d = new Date();
        return {
            filter: {
                from:
                    d.getFullYear() +
                    "-" +
                    String(d.getMonth() + 1).padStart(2, "0") +
                    "-01",
                to:
                    d.getFullYear() +
                    "-" +
                    String(d.getMonth() + 1).padStart(2, "0") +
                    "-" +
                    String(d.getDate()).padStart(2, "0"),
                type: 0,
            },
            ctx: [
                {
                    text: "View Details",
                    icon: "mdi-eye",
                    action: (item) => {
                        this.$router.push(`/orders/${item.order_number}`);
                    },
                },
            ],
            data: [],
            tab: null,
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
            items: ["Between Dates", "Order Count", "Sales Report"],
        };
    },
    watch: {
        async tab(value) {
            let vm = this;
            if (value == 0) {
                vm.betweenDates();
            } else if (value == 1) {
                vm.orderCount();
            } else if (value == 2) {
                vm.orderSales();
            }

            /* vm.setItem(this.$store.state.order, data); */
        },
        "filter.type"(value) {
            let vm = this;
            if (vm.tab == 2) {
                vm.orderSales();
            }
        },
        "filter.from"(value) {
            if (vm.tab == 0) {
                vm.betweenDates();
            } else if (vm.tab == 1) {
                vm.orderCount();
            } else if (vm.tab == 2) {
                vm.orderSales();
            }
        },
        "filter.to"(value) {
            if (vm.tab == 0) {
                vm.betweenDates();
            } else if (vm.tab == 1) {
                vm.orderCount();
            } else if (vm.tab == 2) {
                vm.orderSales();
            }
        },
    },
    async created() {
        let vm = this;
        vm.betweenDates();
    },
    methods: {
        async betweenDates() {
            let vm = this;
            const { data } = await axios.get("/orders", {
                params: {
                    from: vm.filter.from,
                    to: vm.filter.to,
                    status: vm.filter.status,
                },
            });
            vm.data = data;
        },
        async orderCount() {
            let vm = this;
            const { data } = await axios.get("/orders/count", {
                params: {
                    from: vm.filter.from,
                    to: vm.filter.to,
                },
            });
            vm.data = data;
        },
        async orderSales() {
            let vm = this;
            const { data } = await axios.get("/orders/sales", {
                params: {
                    from: vm.filter.from,
                    to: vm.filter.to,
                    type: vm.filter.type,
                },
            });
            vm.data = data;
        },
        getTotal(items, index) {
            let value = 0;
            items.forEach((item) => {
                value = value + item[index];
            });
            return value;
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
