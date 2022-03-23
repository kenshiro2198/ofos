<template>
    <v-breadcrumbs
        class="text-uppercase font-weight-bold pa-0 pr-2 dense"
        style="letter-spacing: 0.5px !important; user-select: none"
        large
        :items="router"
    >
        <template v-slot:item="{ item }">
            <v-breadcrumbs-item
                class="pointer"
                @click="$router.push(item.to)"
                :disabled="item.disabled"
                >{{
                    item.text ? item.text.toUpperCase() : ""
                }}</v-breadcrumbs-item
            >
        </template>
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
                            to: this.$router.match(this.matched).path,
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
