<template>
    <div v-if="$me.theme_navigation_variant >= 0">
        <v-app-bar
            v-if="$me.theme_navigation_variant"
            src="/img/nav_bg_variant.jpeg"
            dark
            class="rotate180 text-truncate"
            :app="fixed_header"
        >
            <v-menu v-model="menu" offset-y nudge-bottom="10">
                <template #activator="{ on }">
                    <v-btn v-on="on" text large class="pl-0 text-capitalize">
                        <v-list-item-avatar tile class="mr-3" size="38">
                            <v-card color="white" outlined>
                                <v-img
                                    class="ma-auto"
                                    src="/img/logo.png"
                                    position="right"
                                />
                            </v-card>
                        </v-list-item-avatar>
                        <span
                            class="text-uppercase font-weight-bold subtitle-2 mr-2"
                            >Kasipag Microfinancing</span
                        >
                        <div class="hidden-md-and-down">
                            • &nbsp;
                            <span class="caption font-weight-bold">{{
                                branch_name
                            }}</span>
                        </div>
                    </v-btn>
                </template>
                <v-list dense>
                    <v-subheader>Switch Branch</v-subheader>
                    <v-list-item
                        v-for="branch in branches"
                        :key="branch.id"
                        @click="switchBranch(branch.id, branch.name)"
                        :class="{
                            'v-list-item--active primary--text':
                                branch.id == $me.active_branch_id,
                        }"
                    >
                        <v-list-item-title>
                            {{ branch.name }}
                        </v-list-item-title>
                        <v-list-item-action>
                            <v-icon
                                v-if="branch.id != $me.active_branch_id"
                                small
                                >mdi-chevron-right</v-icon
                            >
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-spacer />

            <div class="hidden-sm-and-down">
                <template v-for="(item, index) in nav_items">
                    <v-btn
                        v-if="index < 4"
                        :to="item.to"
                        :key="item.index"
                        text
                        class="text-capitalize mr-2"
                    >
                        <span class="caption">{{ item.title }}</span>
                    </v-btn>
                </template>

                <v-menu offset-y nudge-bottom="14">
                    <template #activator="{ on }">
                        <v-btn v-on="on" text class="text-capitalize mr-2">
                            <span class="caption"
                                ><v-icon size="20"
                                    >mdi-dots-horizontal</v-icon
                                ></span
                            >
                        </v-btn>
                    </template>
                    <v-list dense>
                        <template v-for="(item, index) in nav_items">
                            <v-list-item
                                v-if="index >= 4"
                                :disabled="
                                    !checkAc(item.access) || !!item.disabled
                                "
                                :key="item.name"
                                :to="item.to"
                            >
                                <v-list-item-content>
                                    <v-list-item-title
                                        class="font-weight-light"
                                        >{{ item.title }}</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                        <v-list-item
                            v-if="access.Settings.Index.List || $me.type == 1"
                            to="/settings"
                        >
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-light"
                                    >Settings</v-list-item-title
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </div>

            <v-spacer />

            <v-menu offset-y nudge-bottom="14">
                <template #activator="{ on }">
                    <v-btn v-on="on" text class="text-capitalize pr-1">
                        <span class="caption hidden-lg-and-down">
                            {{ $me.full_name }}
                        </span>
                        <v-avatar size="32" class="ml-2 mr-1">
                            <v-img :src="'/img/user-dummy.jpg'"></v-img>
                        </v-avatar>
                        <v-icon small>mdi-menu-down</v-icon>
                    </v-btn>
                </template>
                <v-list dense>
                    <v-list-item
                        :disabled="!access.Settings['User Management']['List']"
                        :to="`/settings/users/${$me.id}/update`"
                    >
                        <v-list-item-title> Edit Profile </v-list-item-title>
                    </v-list-item>
                    <v-list-item href="/logout">
                        <v-list-item-title> Logout </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-app-bar
            v-if="show"
            class="pt-1"
            :color="store.app.toolbar_color"
            :app="!$me.theme_navigation_variant"
            dense
            clipped-right
            elevate-on-scroll
        >
            <v-btn
                v-if="!$me.theme_navigation_variant"
                color="grey darken-2"
                rounded
                text
                small
                @click="store.app.drawer = !store.app.drawer"
                class="mr-2"
            >
                <v-icon>mdi-menu</v-icon>
            </v-btn>
            <v-btn
                color="grey darken-2"
                rounded
                text
                small
                @click="$router.go(-1)"
                class="mr-2 hidden-sm-and-down"
            >
                <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
            <portal-target style="width: 100%" name="toolbar"></portal-target>
            <template v-if="$vuetify.breakpoint.xsOnly" #extension>
                <portal-target
                    style="width: 100%"
                    name="toolbar-ext"
                ></portal-target>
            </template>
        </v-app-bar>
    </div>
</template>
<script>
export default {
    data() {
        return {
            branch_name: null,
            menu: false,
            branches: [],
            fixed_header: false,
        };
    },
    computed: {
        store() {
            return this.$store.state;
        },
        show() {
            return !this.$route.meta.hideAppBar;
        },
    },
    mounted() {
        let vm = this;

        if (vm.$me.theme_navigation_variant) {
            //show header if user scrolls enough to hide it
            document.addEventListener("scroll", function (e) {
                vm.fixed_header = window.scrollY > 115;
            });
        }
    },
    watch: {},
};
</script>

<style lang="scss">
.rotate180 //for app bar background
  .v-toolbar__image
  .v-image.v-responsive.theme--dark
  .v-image__image.v-image__image--cover {
    transform: rotate(180deg);
}
</style>
