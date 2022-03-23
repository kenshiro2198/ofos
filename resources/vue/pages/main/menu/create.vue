<template>
    <div>
        <g-toolbar :actions="buttons" />
        <v-container grid-list-xs>
            <v-row wrap justify="center">
                <v-col cols="12" sm="11" md="7">
                    <g-error-msg :errorMsg="errors.all()"></g-error-msg>
                </v-col>
                <v-col cols="12" sm="11" md="6">
                    <v-card color="transparent" elevation="0">
                        <v-card-title>Menu</v-card-title>
                        <v-card-text>
                            <div class="text-center">
                                <g-avatar-picker
                                    size="100"
                                    v-model="form.image"
                                ></g-avatar-picker>
                            </div>
                            <v-text-field
                                v-model="form.firstname"
                                label="Name"
                                data-vv-name="Name"
                                v-validate="'required'"
                                class="required"
                                :error-messages="errors.collect('Name')"
                            ></v-text-field>
                            <v-autocomplete
                                label="Category"
                                v-validate="'required'"
                                :items="categories"
                                class="required"
                                multiple
                                item-text="name"
                                item-value="id"
                                chips
                                small-chips
                                clearable
                                deletable-chips
                                data-vv-name="category"
                                v-model="form.category"
                                :error-messages="errors.collect('category')"
                            ></v-autocomplete>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<route-meta>
      {
      "breadcrumb": "Create"
      }
</route-meta>
<script>
import { Validator } from "vee-validate";
import { mapActions, mapState } from "vuex";
export default {
    data() {
        return {
            form: {},
            buttons: [
                {
                    icon: "cancel",
                    name: "Cancel",
                    function: (item) => {
                        this.$router.go(-1);
                    },
                },
                {
                    icon: "plus",
                    name: "Save",
                    props: {
                        color: "primary",
                    },
                    function: (item) => {
                        this.submit();
                    },
                },
            ],
        };
    },
    watch: {
        "form.firstname"(val) {
            if (val) {
                this.form.firstname =
                    val.charAt(0).toUpperCase() + val.slice(1);
            }
        },
        "form.lastname"(val) {
            if (val) {
                this.form.lastname = val.charAt(0).toUpperCase() + val.slice(1);
            }
        },
    },
    created() {
        let vm = this;
        vm.getCategories();
        Validator.extend("unique_email", {
            validate: vm.checkEmail,
            getMessage: (field, params, data) => "Email is already existing",
        });

        Validator.extend("unique_username", {
            validate: vm.checkUsername,
            getMessage: (field, params, data) => "Username is already existing",
        });
    },
    computed: {
        ...mapState({
            categories: (state) => state.category.list,
        }),
    },
    methods: {
        ...mapActions({
            getCategories: "category/fetch",
            save: "user/save",
        }),
        async checkEmail(value) {
            var unique = (
                await axios.get("/is-unique", {
                    params: {
                        model: "User",
                        value: this.form.email,
                        field: "email",
                        type: 2,
                    },
                })
            ).data;
            return unique;
        },
        async checkUsername(value) {
            var unique = (
                await axios.get("/is-unique", {
                    params: {
                        model: "User",
                        value: this.form.username,
                        field: "username",
                        type: 2,
                    },
                })
            ).data;
            return unique;
        },
        async submit() {
            let vm = this;

            const valid = await vm.$validator.validateAll();
            if (valid) {
                try {
                    await vm.save(vm.form);
                    vm.$toast(this.spiel.added, "success");
                    vm.form = {};
                } catch (error) {
                    vm.$toast("Error.", "error");
                }
            } else {
                vm.$toast("Please fill out required fields.", "error");
            }
        },
    },
};
</script>
