<template>
    <section>
        <g-toolbar />
        <v-container grid-list-xs>
            <v-row wrap>
                <v-col cols="12" sm="12" md="6">
                    <v-simple-table>
                        <template v-slot:default>
                            <tbody>
                                <tr>
                                    <td
                                        colspan="2"
                                        class="title text-center blue--text"
                                    >
                                        User Details
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Order Number
                                    </td>
                                    <td>{{ userDetails.orNumber }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        First Name
                                    </td>
                                    <td>{{ userDetails.firstname }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Last Name
                                    </td>
                                    <td>{{ userDetails.lastname }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Email
                                    </td>
                                    <td>{{ userDetails.email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Mobile Number
                                    </td>
                                    <td>{{ userDetails.number }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Flat no./buldng no.
                                    </td>
                                    <td>{{ userDetails.no }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Street
                                    </td>
                                    <td>{{ userDetails.street }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Area
                                    </td>
                                    <td>{{ userDetails.area }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Land Mark
                                    </td>
                                    <td>{{ userDetails.landmark }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        City
                                    </td>
                                    <td>{{ userDetails.city }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Order Date
                                    </td>
                                    <td>
                                        {{ formatDate(userDetails.orderDate) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        Order Final Status
                                    </td>
                                    <td>
                                        {{ getStatus(userDetails.status) }}
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                    <v-simple-table>
                        <template v-slot:default>
                            <tbody>
                                <tr>
                                    <td
                                        colspan="6"
                                        class="title text-center blue--text"
                                    >
                                        Order Details
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        #
                                    </td>
                                    <td class="font-weight-bold grey--text">
                                        Food
                                    </td>
                                    <td class="font-weight-bold grey--text">
                                        Name
                                    </td>
                                    <td class="font-weight-bold grey--text">
                                        Qty
                                    </td>
                                    <td class="font-weight-bold grey--text">
                                        Price/Unit
                                    </td>
                                    <td class="font-weight-bold grey--text">
                                        Total
                                    </td>
                                </tr>
                                <tr
                                    v-for="(item, index) in orderDetails"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <v-avatar
                                            :class="[
                                                {
                                                    'mr-3': !$vuetify.breakpoint
                                                        .xsOnly,
                                                },
                                                {
                                                    'ml-3': $vuetify.breakpoint
                                                        .xsOnly,
                                                },
                                            ]"
                                            size="30"
                                        >
                                            <v-img
                                                :src="item.item.image"
                                            ></v-img>
                                        </v-avatar>
                                    </td>
                                    <td>{{ item.item.name }}</td>
                                    <td>{{ item.quantity }}</td>
                                    <td>{{ currency(item.item.price) }}</td>
                                    <td class="font-weight-bold">
                                        {{
                                            currency(
                                                item.item.price * item.quantity
                                            )
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="font-weight-bold grey--text text-right"
                                        colspan="5"
                                    >
                                        Grand Total
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ currency(getTotal(orderDetails)) }}
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
            </v-row>
            <!-- -->
            <v-row
                v-if="
                    userDetails.status == 2 ||
                    userDetails.status == 3 ||
                    userDetails.status == 4 ||
                    userDetails.status == 1
                "
            >
                <v-col>
                    <v-card>
                        <v-card-text>
                            <v-simple-table>
                                <template v-slot:default>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="font-weight-bold grey--text"
                                            >
                                                Restaurant Remark:
                                            </td>
                                            <td>
                                                <v-textarea
                                                    data-vv-name="remark"
                                                    v-validate="'required'"
                                                    :error-messages="
                                                        errors.collect('remark')
                                                    "
                                                    class="required"
                                                    v-model="form.remark"
                                                >
                                                </v-textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="font-weight-bold grey--text"
                                            >
                                                Status
                                            </td>
                                            <td>
                                                <v-autocomplete
                                                    v-model="form.status"
                                                    :items="status"
                                                    item-text="text"
                                                    item-value="text"
                                                    data-vv-name="status"
                                                    v-validate="'required'"
                                                    :error-messages="
                                                        errors.collect('status')
                                                    "
                                                    class="required"
                                                ></v-autocomplete>
                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="success" @click="updateTracker"
                                >Update Order</v-btn
                            >
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-simple-table>
                        <template v-slot:default>
                            <tbody>
                                <tr>
                                    <td
                                        colspan="4"
                                        class="font-weight-bold text-center grey--text"
                                    >
                                        Food Tracking History
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold grey--text">
                                        #
                                    </td>
                                    <td class="font-weight-bold grey--text">
                                        status
                                    </td>
                                    <td class="font-weight-bold grey--text">
                                        Status
                                    </td>
                                    <td class="font-weight-bold grey--text">
                                        Time
                                    </td>
                                </tr>
                                <tr
                                    v-for="(item, index) in trackingHistory"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.remark }}</td>
                                    <td>{{ item.status }}</td>
                                    <td>
                                        {{ formatDate(item.status_timestamp) }}
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>
<route-meta>
      {
      "breadcrumb": "Details"
      }
</route-meta>
<script>
import { mapActions, mapState, mapGetters } from "vuex";
export default {
    data() {
        return {
            form: {},
            userDetails: {},
            orderDetails: [],
            trackingHistory: [],
            status: [
                {
                    text: "Not Confirmed Order",
                    value: 1,
                },
                {
                    text: "Order Confirmed",
                    value: 2,
                },
                {
                    text: "Food Being Prepared",
                    value: 3,
                },
                {
                    text: "Food Pickup",
                    value: 4,
                },
                {
                    text: "Food Delivered",
                    value: 5,
                },
                {
                    text: "Cancelled",
                    value: 6,
                },
            ],
        };
    },
    computed: {
        ...mapGetters("order", ["find"]),
        id() {
            return this.$route.params.id;
        },
    },
    created() {
        let vm = this;
        vm.initialize();
    },
    methods: {
        async updateTracker() {
            let vm = this;
            const valid = await vm.$validator.validateAll();
            if (valid) {
                try {
                    const { data } = await axios.post("/orders/track", vm.form);
                    vm.$toast("Order Successfully Updated", "success");
                } catch (error) {
                    vm.$toast("Error.", "error");
                }
            } else {
                vm.$toast("Please fill out required fields.", "error");
            }
        },
        async initialize() {
            let vm = this;
            try {
                const data = await vm.find(vm.id);
                vm.userDetails = data.user_details;
                vm.orderDetails = data.order_details;
                vm.trackingHistory = data.trackingHistory;

                vm.form.status = "Order Confirmed";
                vm.form.order_id = data.user_details.orNumber;
                vm.$forceUpdate();
            } catch (e) {
                vm.$toast(e, "#B71C1C");
            }
        },
        getTotal(value) {
            let total = 0.0;
            value.forEach((item) => {
                total = total + item.item.price * item.quantity;
            });
            return total;
        },
    },
};
</script>
<style lang=""></style>
