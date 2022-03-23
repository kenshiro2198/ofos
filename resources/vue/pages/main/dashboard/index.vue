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
