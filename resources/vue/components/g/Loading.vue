<template>
    <v-overlay
        color="background"
        opacity="1"
        fixed
        left
        top
        right
        bottom
        z-index="999"
    >
        <v-row dense class="pa-0">
            <v-col class="d-flex justify-center pa-0" cols="12">
                <v-progress-circular
                    indeterminate
                    size="98"
                    width="2"
                    color="primary"
                >
                    <v-img
                        eager
                        width="64"
                        height="64"
                        contain
                        src="/img/logo_transparent.png"
                    />
                </v-progress-circular>
            </v-col>
            <transition name="fade">
                <v-col class="pa-0" cols="12">
                    <v-col
                        class="px-0 pb-3 pt-4 d-flex justify-center"
                        cols="12"
                    >
                        <p class="loader caption blue--text mb-0" />
                    </v-col>
                    <template v-if="showSuggestion">
                        <v-col cols="12" class="text-center pa-0">
                            <v-btn
                                @click="$router.back()"
                                x-small
                                color="success"
                                class="font-weight-bold"
                                >Go back</v-btn
                            >
                        </v-col>
                    </template>
                </v-col>
            </transition>
        </v-row>
    </v-overlay>
</template>
<script>
import Loadr from "randloadr";
export default {
    props: {
        value: Boolean,
    },
    data() {
        return {
            showSuggestion: false,
        };
    },
    mounted() {
        let vm = this;
        const instance = new Loadr(document.querySelector(".loader"));
        instance.start();
    },
    watch: {
        value(e) {
            let vm = this;
            if (e) {
                setTimeout(() => {
                    vm.showSuggestion = true;
                }, 5000);
            } else {
                vm.showSuggestion = false;
            }
        },
    },
};
</script>

<style>
@keyframes scale {
    0% {
        transform: scale(0.9, 0.9);
    }
    50% {
        transform: scale(1, 1);
    }
    100% {
        transform: scale(0.9, 0.9);
    }
}

.spin-parent {
    width: 160px;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* .logo-img {
  animation: scale 1s ease-in-out infinite;
} */
</style>
