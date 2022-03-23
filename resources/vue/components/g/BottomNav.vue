<template>
    <v-bottom-navigation
        v-if="$me.theme_navigation_variant >= 0"
        grow
        v-bind="$attrs"
        :class="{ 'x-scrollable': bottomNavItems && bottomNavItems.length > 4 }"
        app
        shift
        v-model="bottomNav"
        active-class=" "
        height="52"
    >
        <template v-for="(item, index) in bottomNavItems">
            <v-btn :key="item.index" :to="item.to" v-if="!item.disabled">
                <span>{{ item.title }}</span>
                <v-icon size="20">{{ item.icon }}</v-icon>
            </v-btn>
        </template>
        <slot name="item"></slot>
    </v-bottom-navigation>
</template>

<script>
export default {
    props: {
        bottomNavItems: {
            type: Array,
            default: [],
        },
    },
    data() {
        return {
            bottomNav: 0,
        };
    },
    computed: {},
    methods: {},
    watch: {},
};
</script>

<style lang="scss" scope>
.x-scrollable {
    overflow-y: hidden;
    overflow-x: auto;
    justify-content: unset !important;
    &::-webkit-scrollbar {
        height: 5px;
        width: 5px;
    }
}
</style>
