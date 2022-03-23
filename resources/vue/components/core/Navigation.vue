<template>
    <div>
        <!-- src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTLa30qKlwXhPNtSdcIrr6U2CV2YUKCWo3Lyy6nfWvU5zRpD8va" -->
        <!-- src="https://wallpaperaccess.com/full/754676.jpg" -->
        <!-- :mini-variant="$vuetify.breakpoint.smAndUp" -->
        <v-navigation-drawer
            :class="{ fog: $vuetify.theme.dark }"
            src="/img/nav_bg.jpg"
            v-model="drawer"
            width="292.3"
            app
            clipped-left
            dark
        >
            <v-list-item
                class="pr-0"
                :style="store.app.drawer ? 'padding-left:9px!important' : ''"
            >
                <v-list-item-avatar
                    tile
                    class="mr-3"
                    :size="store.app.drawer ? 38 : 52"
                >
                    <v-card color="transparent" outlined>
                        <v-img
                            class="ma-auto"
                            src="/img/logo_transparent.png"
                        ></v-img>
                    </v-card>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title
                        class="text-uppercase font-weight-bold subtitle-2"
                    >
                        G-District
                    </v-list-item-title>
                    <v-list-item-subtitle class="font-weight-bold caption">
                        {{ branch_name }}
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action></v-list-item-action>
            </v-list-item>
            <v-divider class="my-0"></v-divider>
            <v-list dense class="py-0">
                <v-list-item>
                    <v-list-item-avatar
                        size="28"
                        style="margin-right: 16px !important"
                    >
                        <v-img src="/img/user-dummy.jpg"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="subtitle-2">{{
                            $me.fullname
                        }}</v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-action>
                        <v-btn href="/logout" icon small>
                            <v-icon size="18">mdi-logout</v-icon>
                        </v-btn>
                    </v-list-item-action>
                </v-list-item>
            </v-list>
            <v-divider class="my-0"></v-divider>
            <v-list dense>
                <template v-for="item in items">
                    <v-list-group
                        v-model="item.isActive"
                        v-if="item.subitems"
                        :key="item.index"
                        :prepend-icon="item.icon"
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-title>{{
                                item.title
                            }}</v-list-item-title>
                        </template>
                        <v-list-item
                            class="ml-4"
                            v-for="subitems in item.subitems"
                            :key="subitems.title"
                            :to="subitems.to"
                        >
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-light">{{
                                    subitems.title
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                    <!-- :disabled="
              (store.app.drawer && $vuetify.breakpoint.smAndUp) == false
            " -->
                    <v-menu
                        transition="slide-x-transition"
                        disabled
                        :key="item.title"
                        offset-x
                        nudge-left="45"
                        open-on-hover
                        v-else-if="!item.subitems"
                    >
                        <template #activator="{ on }">
                            <v-list-item
                                v-on="on"
                                :to="item.to"
                                @click.stop
                                :append-icon="item.icon"
                                :disabled="!!item.disabled"
                            >
                                <v-list-item-icon>
                                    <v-icon
                                        size="20"
                                        :disabled="!!item.disabled"
                                        v-text="item.icon"
                                    />
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>{{
                                        item.title
                                    }}</v-list-item-title>
                                </v-list-item-content>
                                <v-list-item-action class="my-1">
                                    <v-chip
                                        outlined
                                        class="font-weight-bold ma-0"
                                        small
                                        color="secondary"
                                        v-if="item.notif"
                                    >
                                        {{
                                            $store.state.notifications[
                                                item.notif
                                            ] >= 99
                                                ? "99+"
                                                : $store.state.notifications[
                                                      item.notif
                                                  ]
                                        }}
                                    </v-chip>
                                </v-list-item-action>
                            </v-list-item>
                        </template>
                        <v-btn
                            :to="item.to"
                            height="40"
                            color="tertiary"
                            tile
                            dark
                            class="font-weight-bold overline text-left"
                        >
                            <v-icon left class="mr-5">{{ item.icon }}</v-icon>
                            {{ item.title }}
                        </v-btn>
                    </v-menu>
                </template>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>
<script>
import { mapState, mapActions, mapMutations } from "vuex";
export default {
    data() {
        return {
            drawer: false,
            mini: false,
            branch_name: null,
            editMode: false,
        };
    },
    computed: {
        ...mapState({
            me: (state) => state.app.user,
            items: (state) => state.app.navigation_items,
        }),
        store() {
            return this.$store.state;
        },
    },
    async mounted() {
        let vm = this;
        vm.store.app.drawer = true;
        vm.drawer = localStorage.getItem("drawer") == 1 ? true : false;
    },
    watch: {
        "store.app.drawer"(e) {
            this.drawer = e;
        },
        drawer(e) {
            let vm = this;
            localStorage.setItem("drawer", e ? 1 : 0);
            vm.store.app.drawer = e;
            vm.drawer = e;
        },
    },
    methods: {
        ...mapMutations({
            toggleNavItem: "app/toggleNavItem",
        }),
        ...mapActions({
            //
        }),
    },
};
</script>

<style lang="scss" scope>
@media only screen and (min-width: 768px) {
    .fog {
        box-shadow: -11px 0px 30px 7px rgb(51, 84, 115) !important;
    }
}
</style>
