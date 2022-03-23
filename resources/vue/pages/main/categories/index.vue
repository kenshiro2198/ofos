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
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
        <router-view></router-view>
    </section>
</template>
<route-meta>
      {
      "breadcrumb": "Categories"
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
                        this.$router.push(`/categories/${item.id}/update`);
                    },
                },
                {
                    text: "Delete",
                    icon: "mdi-delete",
                    action: (item) => {
                        this.delete(item);
                    },
                },
            ],
            buttons: [
                {
                    icon: "plus",
                    name: "Create",
                    props: {
                        to: "categories/create",
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
                    value: "name",
                },
            ],
            items: [],
        };
    },
    computed: {
        ...mapState({
            data: (state) => state.category.list,
        }),
    },
    async created() {
        let vm = this;
        vm.getItems();
    },
    methods: {
        ...mapActions({
            getItems: "category/fetch",
            remove: "category/delete",
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
