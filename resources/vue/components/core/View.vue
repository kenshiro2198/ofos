<template>
    <v-main class="background pt-15">
        <router-view></router-view>
    </v-main>
</template>
<script>
import { mapState } from "vuex";
// import mixin from "./index.mixin";
export default {
    // mixins: [mixin],
    data() {
        let vm = this;
        return {
            bottom_nav: 0,
        };
    },
    computed: {
        ...mapState({
            busy: (state) => state.app.busy,
        }),
    },
};
</script>
