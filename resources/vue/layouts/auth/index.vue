<template>
    <v-app>
        <v-container
            v-if="isClientPaying == 'yes'"
            fluid
            grid-list-md
            class="py-0"
        >
            <v-row justify="center">
                <v-col class="pa-0" cols="12">
                    <v-card color="background" tile>
                        <v-img height="100vh">
                            <v-container
                                style="height: 100vh"
                                class="d-flex align-center"
                                :class="{
                                    'pa-2': $vuetify.breakpoint.smAndDown,
                                }"
                                grid-list-md
                            >
                                <v-row
                                    :class="{
                                        'px-4': $vuetify.breakpoint.xsOnly,
                                    }"
                                    justify="center"
                                >
                                    <v-col cols="12" align="center">
                                        <v-img
                                            eager
                                            contain
                                            width="138"
                                            src="/img/logo_transparent.png"
                                        ></v-img>
                                    </v-col>
                                    <v-col
                                        class="pt-0"
                                        :class="
                                            $vuetify.breakpoint.smAndUp
                                                ? 'px-5'
                                                : 'px-0'
                                        "
                                        cols="11"
                                        sm="8"
                                        md="6"
                                        lg="5"
                                        xl="4"
                                    >
                                        <v-container
                                            class="pt-0"
                                            :class="
                                                $vuetify.breakpoint.smAndDown
                                                    ? 'px-0'
                                                    : ''
                                            "
                                            grid-list-md
                                        >
                                            <div style="height: 400px">
                                                <transition name="slide-fade">
                                                    <router-view></router-view>
                                                </transition>
                                            </div>
                                        </v-container>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-img>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            isClientPaying: "yes",
        };
    },
};
</script>

<style>
.optional:before {
    content: "Optional";
    color: #909090;
    font-size: 0.8rem;
    position: absolute;
    top: 3px;
    right: 6px;
    font-weight: 300;
}

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
</style>
