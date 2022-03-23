<template>
    <v-app :dark="dark">
        <router-view></router-view>
    </v-app>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
    computed: {
        ...mapState({
            dark: (state) => state.app.dark,
        }),
    },
    mounted() {
        let vm = this;
        /* if (vm.$cookie.get("api_token") && typeof vm.$me !== "undefined") {
            vm.darkMode(this.$me.id);
        } */
        vm.$vuetify.theme.dark = vm.dark;
    },
    methods: {
        ...mapActions({
            darkMode: `app/darkMode`,
        }),
    },
};
</script>
<style lang="scss">
.pointer {
    cursor: pointer !important;
}

.cursor-default {
    cursor: default !important;
}

a:hover {
    text-decoration: none !important;
}

//table
.v-data-table.transparent {
    background: transparent !important;
    thead th {
        // background: var(--v-background-base) !important;
        background: transparent !important;
    }
}
//table

.helper {
    border: 1px solid red;
}

.required label:before {
    content: "* ";
    font-size: 1rem;
    color: var(--v-error-base);
}

.transparent .v-tabs .v-tabs-bar {
    background: transparent !important;
}

.rounded {
    border-radius: 8px !important;
}

@media screen and (max-width: 480px) {
    ul.v-breadcrumbs li:not(:last-child) {
        display: none !important;
    }
}

.v-data-table:not(.pointer-disabled) .v-data-table__wrapper table tbody {
    cursor: pointer !important;
}

.remove-prev-tab {
    .v-slide-group__prev.v-slide-group__prev--disabled {
        display: none !important;
    }
}

.tab-justify-left .v-tab {
    justify-content: left !important;
}

input:not([id]) {
    background: var(--v-glass-base) !important;
    border: 1px solid var(--v-border-base) !important;
    border-radius: 4px !important;
    height: 32px;
    width: 300px;
    padding: 8px;
}

textarea:not([id]) {
    background: var(--v-glass-base) !important;
    border: 1px solid var(--v-border-base) !important;
    border-radius: 4px !important;
    height: 96px;
    width: 300px;
    padding: 8px;
}

.card-outline {
    height: 250px;
    width: 250px;
    border: 2px solid grey;
}

// .v-data-footer {
//   margin: 0 !important;
//   background: var(--v-glass-base) !important;
//   position: absolute;
//   left: 0;
//   right: 0;
//   bottom: 0;
// }

//Skeleton Loader
.theme--light.v-skeleton-loader .v-skeleton-loader__actions,
.theme--light.v-skeleton-loader .v-skeleton-loader__article,
.theme--light.v-skeleton-loader .v-skeleton-loader__card-heading,
.theme--light.v-skeleton-loader .v-skeleton-loader__card-text,
.theme--light.v-skeleton-loader .v-skeleton-loader__date-picker,
.theme--light.v-skeleton-loader .v-skeleton-loader__list-item,
.theme--light.v-skeleton-loader .v-skeleton-loader__list-item-avatar,
.theme--light.v-skeleton-loader .v-skeleton-loader__list-item-avatar-three-line,
.theme--light.v-skeleton-loader .v-skeleton-loader__list-item-avatar-two-line,
.theme--light.v-skeleton-loader .v-skeleton-loader__list-item-text,
.theme--light.v-skeleton-loader .v-skeleton-loader__list-item-three-line,
.theme--light.v-skeleton-loader .v-skeleton-loader__list-item-two-line,
.theme--light.v-skeleton-loader .v-skeleton-loader__table-heading,
.theme--light.v-skeleton-loader .v-skeleton-loader__table-tbody,
.theme--light.v-skeleton-loader .v-skeleton-loader__table-tfoot,
.theme--light.v-skeleton-loader .v-skeleton-loader__table-thead {
    background: transparent !important;
}
//Skeleton Loader

//transitions
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
//transitions

.ellipsis {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.v-main {
    height: 100% !important;
}

.link:hover {
    cursor: pointer !important;
    text-decoration: underline !important;
}

// td {
// 	white-space: nowrap !important;
// }

.hidden {
    visibility: hidden !important;
}

.v-data-table.text-truncate-all {
    td {
        white-space: nowrap !important;
    }
}

//to remove arrows on input type
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type="number"] {
    -moz-appearance: textfield;
}

.line-through {
    text-decoration: line-through !important;
}
</style>
