<template>
    <section>
        <v-toolbar dense color="primary" height="70">
            <v-img
                @click="$router.push('/')"
                src="/img/logo_transparent.png"
                max-height="100"
                max-width="50"
            >
            </v-img>
            <v-text-field
                class="ml-7"
                hide-details
                solo
                placeholder="Search for your favorite food"
                prepend-inner-icon="mdi-magnify"
            ></v-text-field>
            <v-spacer></v-spacer>

            <div class="ml-8 secondary--text">
                <v-btn color="secondary" text plain class="overline">Menu</v-btn>
                <v-btn color="secondary" text plain class="overline">Orders</v-btn>
                <v-btn color="secondary" text plain class="overline">LOGIN</v-btn>
                |
                <v-btn color="secondary" text plain class="overline">REGISTER</v-btn>
            </div>
        </v-toolbar>
        <!-- <v-toolbar color="white" elevation="0">
            <v-btn
                text
                color="primary"
                class="ml-16"
                @click="$router.push('/')"
            >
                <div class="text">G-DISTRICT</div>
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
                color="primary"
                text
                class="ml-16"
                @click="$router.push('/')"
            >
                <div class="text font-weight-medium">Home</div>
            </v-btn>
            <v-divider vertical class="ml-8" inset></v-divider>
            <v-menu offset-y open-on-hover>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="primary"
                        text
                        class="ml-16"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <div class="text font-weight-medium">Food Menu</div>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item
                        v-for="(item, index) in items"
                        :key="index"
                        link
                    >
                        <v-list-item-title to="/">{{
                            item.name
                        }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-divider vertical class="ml-8" inset></v-divider>
            <v-btn
                color="primary"
                text
                class="ml-16"
                @click="$router.push('/track-order')"
            >
                <div class="text font-weight-medium">Track Order</div>
            </v-btn>
            <v-divider vertical class="ml-8" inset></v-divider>
            <v-btn
                color="primary"
                text
                class="ml-16"
                @click="$router.push('/contact-us')"
            >
                <div class="text font-weight-medium">Contact Us</div>
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn color="secondary" class="ml-16" depressed>
                <div class="text font-weight-medium primary--text">CART</div>
            </v-btn>
        </v-toolbar> -->
    </section>
</template>
<script>
export default {
    data() {
        return {
            items: [],
            cart: 0,
        };
    },
    async mounted() {
        let vm = this;
        const { data } = await axios.get("/categories");
        vm.items = data;
    },
    created() {},
    watch: {},
    methods: {},
};
</script>
<style scoped>
.text {
    font-size: 18px;
    font-weight: 500;
    line-height: 1.1;
    color: inherit;
}
</style>
