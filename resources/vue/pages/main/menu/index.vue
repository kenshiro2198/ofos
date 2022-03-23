<template>
    <section>
        <g-toolbar @search="search = $event" :actions="buttons" />
        <v-container fluid grid-list-lg>
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
                        <template v-slot:item.name="{ item }">
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
                                    size="50"
                                >
                                    <v-img :src="'/img/' + item.image"></v-img>
                                </v-avatar>
                                {{ item.name }}
                            </div>
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
      "breadcrumb": "Menu"
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
                        this.$router.push(`/menu/${item.id}/update`);
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
                        to: "menu/create",
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
                    text: "Name",
                    align: "left",
                    sortable: true,
                    value: "name",
                },
                {
                    text: "Category",
                    align: "left",
                    sortable: true,
                    value: "category.name",
                },
            ],
            items: [],
        };
    },
    computed: {
        ...mapState({
            data: (state) => state.menu.list,
        }),
    },
    async created() {
        let vm = this;
        vm.getItems();
    },
    methods: {
        ...mapActions({
            getItems: "menu/fetch",
            remove: "menu/delete",
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
