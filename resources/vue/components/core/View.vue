<template>
    <v-main class="background">
        <transition name="fade">
            <g-loading v-model="busy" v-show="busy" />
        </transition>
        <transition v-if="$vuetify.breakpoint.smAndUp" name="slide-fade">
            <router-view></router-view>
        </transition>
        <template v-else>
            <router-view></router-view>
        </template>
        <v-system-bar
            v-if="$route.meta.info"
            app
            style="z-index: 9999 !important"
        >
            <v-icon color="blue">mdi-information</v-icon>
            <span class="marquee1">{{ $route.meta.info }}</span>
            <span class="marquee2">{{ $route.meta.info }}</span>
        </v-system-bar>
        <!-- <g-bottom-nav
            active-class="teal--text"
            class="hidden-sm-and-up bg_image"
            background-color="glass"
            v-model="bottom_nav"
            :bottomNavItems="nav_items"
        >
            <template #item>
                <v-btn to="/settings">
                    <span>Settings</span>
                    <v-icon size="20">mdi-settings-outline</v-icon>
                </v-btn>
            </template>
        </g-bottom-nav> -->
        <v-navigation-drawer
            :width="$vuetify.breakpoint.xsOnly ? '100vw' : '332'"
            temporary
            touchless
            app
            right
            v-model="$store.state.app.filter"
        >
            <portal-target name="filters"></portal-target>
        </v-navigation-drawer>
        <v-dialog
            @click:outside="$store.state.app.view_photo = null"
            max-width="800"
            :value="$store.state.app.view_photo"
        >
            <v-card>
                <v-img
                    v-if="
                        $store.state.app.view_photo &&
                        ['jpeg', 'jpg', 'png', 'gif'].includes(
                            $store.state.app.view_photo.substring(
                                $store.state.app.view_photo.lastIndexOf('.') + 1
                            )
                        )
                    "
                    contain
                    :src="`/storage/${$store.state.app.view_photo}`"
                >
                    <v-btn
                        x-small
                        @click="$store.state.app.view_photo = null"
                        class="float-right mt-2 mr-3"
                        color="tertiary"
                        dark
                        fab
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-img>
                <v-container v-else-if="$store.state.app.view_photo">
                    <g-empty-view title="No preview available">
                        <vv-btn
                            @click="
                                download({
                                    path: $store.state.app.view_photo,
                                    file_name:
                                        $store.state.app.view_photo_file_name,
                                })
                            "
                            append
                            small
                            rounded
                            color="primary"
                        >
                            <v-icon left>mdi-download</v-icon>Download
                        </vv-btn>
                    </g-empty-view>
                </v-container>
            </v-card>
        </v-dialog>
    </v-main>
</template>
<script>
import { mapState } from "vuex";
export default {
    data() {
        let vm = this;
        return {
            bottom_nav: 0,
        };
    },
    computed: {
        ...mapState({
            busy: (state) => state.app.busy,
            nav_items: (state) => state.app.navigation_items,
        }),
    },
};
</script>

<style lang="scss">
.slide-fade-enter-active {
    transition: all 0.8s ease;
}
.slide-fade-leave-active {
    transition: all 0s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}

@keyframes marquee1 {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

@keyframes marquee2 {
    0% {
        transform: translateX(0%);
    }
    100% {
        transform: translateX(-200%);
    }
}

.marquee1 {
    white-space: nowrap;
}

@media only screen and (max-width: 963px) {
    .marquee1 {
        white-space: nowrap;
        animation: marquee1 10s linear infinite;
    }
}

.marquee2 {
    white-space: nowrap;
    display: none;
}

@media only screen and (max-width: 963px) {
    .marquee2 {
        display: block;
        white-space: nowrap;
        animation: marquee2 10s linear infinite;
        animation-delay: -20s;
    }
}

// .v-navigation-drawer__border {
//   border: 15px solid;
//   border-radius: 50px 0px 0px 50px;
//   border-color: var(--v-background-base);
// }

// .bg_image {
//   background-image: url(http://127.1:8000/img/nav_bg.jpg);
//   background-position: center center;
// }
</style>
