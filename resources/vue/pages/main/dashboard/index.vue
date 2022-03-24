<template>
    <section>
        <g-toolbar :actions="buttons" />
        <v-container fluid grid-list-lg class="pt-0">
            <v-row dense>
                <v-col
                    v-for="(item, index) in items"
                    :key="index"
                    cols="12"
                    md="4"
                >
                    <v-card height="100%">
                        <v-card-title
                            class="py-2 font-weight-bold blue-grey--text"
                            >{{ item.title }}</v-card-title
                        >
                        <v-divider />
                        <v-card-text>
                            <v-simple-table>
                                <tr>
                                    <td
                                        class="font-weight-bold display-1 grey--text"
                                    >
                                        {{ item.value }}
                                    </td>
                                </tr>
                            </v-simple-table>
                        </v-card-text>
                    </v-card>
                </v-col>
                <!-- <v-col cols="12">
                    <template>
                        <v-card class="mx-auto text-center" color="green" dark>
                            <v-card-text>
                                <v-sheet color="rgba(0, 0, 0, .12)">
                                    <v-sparkline
                                        :value="value"
                                        color="rgba(255, 255, 255, .7)"
                                        height="100"
                                        line-width="2"
                                        padding="24"
                                        stroke-linecap="round"
                                        smooth
                                    >
                                        <template v-slot:label="item">
                                            {{ currency(item.value) }}
                                        </template>
                                    </v-sparkline>
                                </v-sheet>
                            </v-card-text>

                            <v-card-text>
                                <div class="text-h4 font-weight-thin">
                                    Sales
                                </div>
                            </v-card-text>

                            <v-divider></v-divider>
                        </v-card>
                    </template>
                </v-col> -->
            </v-row>
        </v-container>
    </section>
</template>
<route-meta>
      {
      "breadcrumb": "Dashboard"
      }
</route-meta>
<script>
import monitoringToolbar from "./.components/monitoring-toolbar";
export default {
    components: {
        monitoringToolbar,
    },
    data() {
        let vm = this;
        return {
            items: [],
            value: [],
            buttons: [
                {
                    icon: "refresh",
                    name: "Refresh",
                    props: {
                        color: "primary",
                        dark: true,
                    },
                    function: async () => {
                        vm.getItems();
                    },
                },
            ],
            formFilters: {},
        };
    },
    created() {
        let vm = this;
        vm.getItems();
        vm.orderSales();
    },
    methods: {
        async getItems() {
            let vm = this;
            vm.$busy(true);
            const { data } = await axios.get("/dashboard");
            vm.items = data.data || data;
            vm.totalItems = data.total || data.length;
            vm.$busy();
        },
        async orderSales() {
            let vm = this;
            var d = new Date();
            const { data } = await axios.get("/orders/sales", {
                params: {
                    from: d.getFullYear() + "-" + "01-01",
                    to: d.getFullYear() + "-12-31",
                    type: 0,
                },
            });
            vm.value = data;
        },
    },
    watch: {
        $route(e) {
            if (e.path == "/collectors" || e.path == "/collectors/") {
                this.getItems();
            }
        },
        options: {
            deep: true,
            handler: "getItems",
        },
    },
};
</script>
