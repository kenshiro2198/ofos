<template>
    <v-breadcrumbs
        class="font-weight-bold pa-0 pr-2 dense"
        style="user-select: none"
        large
        :items="router"
    >
        <v-icon slot="divider">mdi mdi-menu-right</v-icon>
    </v-breadcrumbs>
</template>

<script>
export default {
    data() {
        return {
            matched: "",
            router: [],
        };
    },
    created() {
        this.breadCrumbs();
    },
    methods: {
        breadCrumbs() {
            let path = this.$route.path;
            let split = path.split("/");
            let string = "";
            this.router = [];
            for (var i = 0; i < split.length; i++) {
                if (split[i]) {
                    string += "/" + split[i];
                    this.matched = string;
                    if (this.$router.match(this.matched).name) {
                        this.router.push({
                            text: this.$router.match(this.matched).meta
                                .breadcrumb,
                            href: this.$router.match(this.matched).path,
                            disabled:
                                this.$router.match(this.matched).path ==
                                this.$route.path,
                        });
                    }
                }
            }
        },
    },
    watch: {
        $route(to, from) {
            this.breadCrumbs();
        },
    },
};
</script>
<style>
.v-breadcrumbs.dense .v-breadcrumbs__divider {
    padding: 0 !important;
}
</style>
