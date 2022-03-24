<template>
    <section>
        <g-toolbar @search="search = $event" :actions="buttons" />
        <v-container fluid grid-list-lg>
            <v-row>
                <v-col cols="12">
                    <v-data-table
                        dense
                        height="700"
                        fixed-header
                        :headers="headers"
                        :items="data"
                        :search="search"
                        :options.sync="options"
                        class="transparent"
                        v-context-menu="ctx"
                    >
                        <template v-slot:item.fullname="{ item }">
                            <div
                                :style="
                                    $vuetify.breakpoint.xsOnly
                                        ? 'direction:rtl'
                                        : ''
                                "
                                class="d-flex align-center"
                            >
                                <v-avatar
                                    :class="[
                                        {
                                            'mr-3': !$vuetify.breakpoint.xsOnly,
                                        },
                                        {
                                            'ml-3': $vuetify.breakpoint.xsOnly,
                                        },
                                    ]"
                                    size="20"
                                >
                                    <v-img
                                        :src="
                                            item.image
                                                ? item.image
                                                : '/img/user-dummy.jpg'
                                        "
                                    ></v-img>
                                </v-avatar>
                                {{ item.fullname }}
                            </div>
                        </template>
                        <template v-slot:item.positions="{ item }">
                            <v-chip
                                x-small
                                v-for="(position, index) in item.positions"
                                :key="index"
                                >{{ position.name }}</v-chip
                            >
                        </template>
                        <template v-slot:item.created_at="{ item }">
                            {{ formatDate(item.created_at) }}
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
      "breadcrumb": "Customers"
      }
</route-meta>
<script>
import { mapActions, mapState } from "vuex";
export default {
    data() {
        return {
            options: {
                type: 1,
            },
            ctx: [
                {
                    text: "Edit",
                    icon: "mdi-pencil",
                    action: (item) => {
                        this.$router.push(`/customers/${item.id}/update`);
                    },
                },
                {
                    text: "Delete",
                    icon: "mdi-delete",
                    action: (item) => {
                        this.delete(item);
                    },
                    visible: (item) => {
                        return !(this.$store.state.app.user.id == item.id);
                    },
                },
            ],
            buttons: [
                {
                    icon: "plus",
                    name: "Create",
                    props: {
                        to: "customers/create",
                        color: "primary",
                    },
                },
            ],
            search: null,
            headers: [
                {
                    text: "Name",
                    align: "left",
                    sortable: true,
                    value: "fullname",
                },
                {
                    text: "Email",
                    align: "left",
                    sortable: true,
                    value: "email",
                },
                {
                    text: "Creation Date",
                    align: "left",
                    sortable: true,
                    value: "created_at",
                },
            ],
            items: [],
        };
    },
    computed: {
        ...mapState({
            data: (state) => state.customer.list,
        }),
    },
    async created() {
        let vm = this;
        vm.getItems();
    },
    methods: {
        ...mapActions({
            getItems: "customer/fetch",
            remove: "customer/delete",
        }),
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
