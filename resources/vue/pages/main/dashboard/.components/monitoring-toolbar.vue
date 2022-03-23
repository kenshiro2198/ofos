<template>
    <v-toolbar rounded flat color="transparent">
        <v-autocomplete
            v-if="!hideBranch"
            v-model="form.branch"
            :items="branches"
            label="Branch"
            dense
            hide-details
            item-text="name"
            item-value="id"
            :style="min_width"
        />
        <v-autocomplete
            v-model="form.year"
            :items="years"
            label="Year"
            dense
            hide-details
            item-text="year"
            :style="min_width"
            class="mx-4"
        />
        <v-autocomplete
            v-model="form.month"
            :items="months"
            label="Month"
            dense
            hide-details
            item-text="name"
            item-value="id"
            :style="min_width"
        />
        <slot />
    </v-toolbar>
</template>
<script>
export default {
    props: {
        value: Object,
        hideBranch: Boolean,
    },
    data() {
        return {
            min_width: "max-width:300px!important;",
            form: {
                branch: null,
                year: null,
                month: null,
            },
            branches: [],
            months: [],
            years: [],
        };
    },
    computed: {},
    async mounted() {
        let vm = this;
        /* const [
            { data: branches },
            { data: current_branch },
            { data: years },
            { data: current_year },
            { data: current_month },
        ] = await Promise.all([
            axios.get("/branches"),
            axios.get(`/users/current-branch/${vm.$me.id}`),
            axios.get(`/monitoring/years-from-savings`),
            axios.get(`/server-year`),
            axios.get(`/server-month`),
        ]);
        vm.branches = branches;
        vm.form.branch = current_branch;

        vm.years = years;
        vm.form.year = current_year;

        vm.form.month = current_month;
 */
        vm.getMonths();
    },
    methods: {
        getMonths() {
            let mths = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];

            mths.forEach((e, i) => {
                this.months.push({
                    id: i + 1,
                    name: e,
                });
            });
        },
    },
    watch: {
        form: {
            deep: true,
            handler(e) {
                this.$emit("input", e);
            },
        },
    },
};
</script>
