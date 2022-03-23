import Vue from "vue";
import store from "@js/store";

import { mapState, mapMutations, mapActions } from "vuex";

Vue.mixin({
    data() {
        return {
            curr: null,
            spiel: {
                confirm: "Are you sure you want to delete this item?",
                added: "Item successfully added",
                saved: "Item successfully saved",
                deleted: "Item successfully deleted",
                error: "Something went wrong, sorry for the inconvenience.",
                confirmation: "Any unsaved changes will be lost",
            },
            defaultFooterProps: {
                footerProps: {
                    itemsPerPageOptions: [5, 15, 30, 50, 100],
                },
            },
        };
    },
    computed: {
        ...mapState({
            $me: (state) => state.app.user,
        }),
    },
    created() {
        this.curr = new Intl.NumberFormat("en-PH", {
            style: "currency",
            currency: "PHP",
        });
    },
    watch: {
        $route(e) {
            let name = e.meta.breadcrumb + " | G-District";
            document.title = e.meta.breadcrumb ? name : "G-District";
        },
    },
    methods: {
        ...mapActions({
            getUser: "app/getUser",
            fetchUser: "app/fetchUser",
        }),
        ...mapMutations({
            setUser: "app/setUser",
            toggleUser: "app/toggleUser",
        }),
        date(value, time) {
            let vm = this;
            let format = "MM/DD/YYYY";
            if (time) {
                format += " h:mm A";
            }
            if (value) {
                return vm.$moment(value).format(format);
            } else {
                return "-";
            }
        },
        currency(value) {
            return this.curr.format(value);
        },
        filterToggle() {
            store.state.app.filter = !store.state.app.filter;
        },
        dynamicSort(property) {
            var sortOrder = 1;
            if (property[0] === "-") {
                sortOrder = -1;
                property = property.substr(1);
            }
            return function (a, b) {
                var result =
                    a[property] < b[property]
                        ? -1
                        : a[property] > b[property]
                        ? 1
                        : 0;
                return result * sortOrder;
            };
        },
        async director(data, spiel = "added") {
            //***
            //put this after axios.post/put
            //Recommended on controller side: put a DB::beginTransaction(), and try catch wrapped on your methods.
            //On success, return 1 with DB::commit(). on catch, return -1 with DB::rollBack()
            //***

            let vm = this;
            if (data > 0) {
                vm.$toast(this.spiel[spiel], "success");
                vm.$router.go(-1);
            } else {
                vm.$toast(this.spiel.error, "error");
            }
        },
        push(route) {
            this.$router.push(route);
        },
    },
});
