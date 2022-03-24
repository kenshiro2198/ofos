<template>
    <section>
        <g-toolbar @search="search = $event" :actions="buttons" />
        <v-container fluid grid-list-lg>
            <v-row>
                <v-col>
                    <v-btn-toggle v-model="status" mandatory>
                        <v-btn> All </v-btn>
                        <v-btn> For Confirmation </v-btn>

                        <v-btn> Confirmed </v-btn>

                        <v-btn> Preparation </v-btn>

                        <v-btn> Pickup </v-btn>
                        <v-btn> Delivered </v-btn>
                        <v-btn> Cancelled </v-btn>
                    </v-btn-toggle>
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
    watch: {
        async status(value) {
            let vm = this;
            if (value != 0) {
                const { data } = await axios.get("/orders?status=" + value);
                vm.data = data;
            } else {
                const { data } = await axios.get("/orders");
                vm.data = data;
            }

            /* vm.setItem(this.$store.state.order, data); */
        },
    },
    async created() {
        let vm = this;
        const { data } = await axios.get("/orders");
        vm.data = data;
    },
    methods: {
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
