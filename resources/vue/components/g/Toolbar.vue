<template>
    <portal to="toolbar">
        <v-row align="center" justify="space-between" class="px-2">
            <v-col cols="auto" class="py-0 d-flex">
                <g-bread-crumbs class="mr-2"></g-bread-crumbs>
                <v-text-field
                    v-if="$listeners.search"
                    class="hidden-xs-only mt-0 pt-0"
                    hide-details
                    v-model="search"
                    filled
                    rounded
                    single-line
                    dense
                    @keyup.enter="$emit('search', search)"
                    placeholder="Search"
                >
                    <template v-slot:prepend-inner>
                        <v-tooltip bottom>
                            <template #activator="{ on }">
                                <v-icon
                                    v-if="info"
                                    v-on="on"
                                    style="
                                        margin-top: 2px;
                                        margin-left: -6px;
                                        z-index: 999;
                                    "
                                    small
                                    >mdi-information</v-icon
                                >
                            </template>
                            <span>{{ info }}</span>
                        </v-tooltip>
                    </template>
                    <template v-slot:append>
                        <vv-btn
                            style="position: absolute; top: 0px; right: 8px"
                            depressed
                            fab
                            text
                            small
                            @click="$emit('search', search)"
                            color="grey"
                        >
                            <v-icon
                                title="Hit enter to search"
                                size="21"
                                v-if="!!search"
                                >mdi-keyboard-return</v-icon
                            >
                            <v-icon size="21" v-else>mdi-magnify</v-icon>
                        </vv-btn>
                    </template>
                </v-text-field>
                <span id="searchbox-mount" v-if="$listeners.search">
                    <v-text-field
                        ref="search-box"
                        v-model="search"
                        class="search-box hidden-sm-and-up"
                        solo
                        id="id"
                        rounded
                        dense
                        hide-details
                        prepend-inner-icon="mdi-magnify"
                        @keyup.enter="$emit('search', search)"
                    ></v-text-field>
                    <!-- @blur="resetSearchBox" -->
                </span>
            </v-col>
            <v-col cols="auto" class="py-0">
                <v-row align="center">
                    <portal-target name="filter-toggle"></portal-target>
                    <v-row class="ma-0 px-2" align="center">
                        <slot name="addons"></slot>
                    </v-row>
                    <portal-target name="toolbar-lg"></portal-target>
                    <portal v-if="$vuetify.breakpoint.xsOnly" to="toolbar-ext">
                        <v-row class="px-4" justify="end">
                            <template v-for="action in actions">
                                <v-col
                                    :key="action.name"
                                    class="py-0 px-1"
                                    cols="auto"
                                >
                                    <vv-btn
                                        v-bind="
                                            defaultActionProp(action.props, 1)
                                        "
                                        @click="invokeAction(action)"
                                    >
                                        <v-icon
                                            :left="$vuetify.breakpoint.mdAndUp"
                                            small
                                            v-if="action.icon"
                                            >mdi-{{ action.icon }}</v-icon
                                        >
                                    </vv-btn>
                                </v-col>
                            </template>
                            <slot name="actions"></slot>
                        </v-row>
                    </portal>
                    <portal v-else to="toolbar-lg">
                        <v-row
                            class="px-2"
                            :class="{ 'px-4': $vuetify.breakpoint.xsOnly }"
                        >
                            <template v-for="action in actions">
                                <v-col :key="action.name" class="py-0 px-1">
                                    <vv-btn
                                        class="font-weight-bold"
                                        v-bind="
                                            defaultActionProp(action.props, 2)
                                        "
                                        @click="invokeAction(action)"
                                    >
                                        <v-icon
                                            :left="$vuetify.breakpoint.mdAndUp"
                                            small
                                            class="mr-2"
                                            v-if="action.icon"
                                            >mdi-{{ action.icon }}</v-icon
                                        >
                                        <span
                                            v-if="
                                                action.name &&
                                                $vuetify.breakpoint.lgAndUp
                                            "
                                        >
                                            {{ action.name }}
                                        </span>
                                    </vv-btn>
                                </v-col>
                            </template>
                            <slot name="actions"></slot>
                        </v-row>
                    </portal>
                </v-row>
            </v-col>
            <slot></slot>
        </v-row>
    </portal>
</template>
<script>
export default {
    props: {
        title: {
            type: String,
            default: "",
        },
        actions: {
            type: Array,
            default: null,
        },
        extended: {
            type: Boolean,
            default: false,
        },
        info: String,
    },
    data() {
        return {
            search: "",
        };
    },
    mounted() {
        this.$nextTick(() => {
            const comp = this.$refs["search-box"];
            if (comp) {
                comp.$el.addEventListener(
                    "transitionend",
                    _.debounce(() => {
                        const input = comp.$el.querySelector("input");
                        if (!comp.isFocused) {
                            comp.blur();
                        }
                    }, 100)
                );
            }
        });
    },
    methods: {
        resetSearchBox(e) {
            return;
            const el = this.$refs["search-box"].$el;
            el.style.left = "unset";
        },
        invokeAction(action) {
            if (action.function) action.function.call(this.$parent);
        },
        defaultActionProp(prop, e) {
            const $options = _.merge(
                {
                    depressed: true,
                    rounded: true,
                    small: true,
                    function: () => {},
                },
                prop
            );
            return $options;
        },
    },
    watch: {
        search(val) {
            if (!val) this.$emit("search", null);
        },
    },
};
</script>
<style lang="scss">
.search-box {
    min-width: 42px;
    max-width: 10px;
    transition: all 0.2s ease-in;
    position: absolute;
    top: 4px;

    .v-input__control {
        min-height: 36px !important;
    }
    .v-input__slot {
        padding: 0 10px !important;
    }
}

.search-box.v-input--is-focused {
    left: 10px;
    right: 10px;
    max-width: 100%;
    z-index: 1;
}

.v-input.search-box.hidden-sm-and-up.v-input--hide-details.v-input--dense.v-text-field.v-text-field--single-line.v-text-field--solo.v-text-field--is-booted.v-text-field--enclosed.v-text-field--rounded:not(.v-input--is-focused) {
    width: 50px !important;
}
.v-input.search-box.hidden-sm-and-up.v-input--hide-details.v-input--dense.v-text-field.v-text-field--single-line.v-text-field--solo.v-text-field--is-booted.v-text-field--enclosed.v-text-field--rounded {
    width: unset !important;
    i {
        margin-top: 0;
        margin-left: 7px;
    }
}
</style>
