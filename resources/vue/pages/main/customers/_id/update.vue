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
                        <v-card-title>Account</v-card-title>
                        <v-card-text>
                            <v-text-field
                                v-model="form.firstname"
                                label="First name"
                                data-vv-name="first name"
                                v-validate="'required|verify_name'"
                                class="required"
                                :error-messages="errors.collect('first name')"
                            ></v-text-field>
                            <v-text-field
                                v-model="form.lastname"
                                label="Last name"
                                data-vv-name="last name"
                                v-validate="'required|verify_name'"
                                class="required"
                                :error-messages="errors.collect('last name')"
                            ></v-text-field>
                            <v-text-field
                                v-model="form.email"
                                label="Email"
                                data-vv-name="email"
                                v-validate="'required|email|unique_email'"
                                class="required"
                                :error-messages="errors.collect('email')"
                            ></v-text-field>
                            <v-text-field
                                v-model="form.username"
                                label="Username"
                                data-vv-name="username"
                                v-validate="'required|unique_username'"
                                :error-messages="errors.collect('username')"
                                class="required"
                            ></v-text-field>
                            <v-text-field
                                autocomplete="new-password"
                                v-model="form.password"
                                label="Password"
                                placeholder="Change password or leave it blank"
                                type="password"
                                data-vv-name="password"
                                v-validate="'verify_password'"
                                :error-messages="errors.collect('password')"
                            ></v-text-field>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<route-meta>
      {
      "breadcrumb": "Update"
      }
</route-meta>
<script>
import { Validator } from "vee-validate";
import { mapActions, mapState, mapGetters } from "vuex";
export default {
    data() {
        return {
            form: {},
            oldEmail: "",
            buttons: [
                {
                    icon: "cancel",
                    name: "Cancel",
                    function: (item) => {
                        this.$router.go(-1);
                    },
                },
                {
                    icon: "check",
                    name: "Save",
                    props: {
                        color: "primary",
                    },
                    function: (item) => {
                        this.submit();
                    },
                },
            ],
            verification: true,
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
        "form.email"(val) {
            let vm = this;
            if (vm.oldEmail != val) {
                vm.verification = true;
            }
        },
    },

    computed: {
        ...mapGetters("customer", ["find"]),
        id() {
            return this.$route.params.id;
        },
    },
    mounted() {
        let vm = this;
        vm.initialize();
        Validator.extend("unique_email", {
            validate: vm.checkEmail,
            getMessage: (field, params, data) => "Email is already existing",
        });

        Validator.extend("unique_username", {
            validate: vm.checkUsername,
            getMessage: (field, params, data) => "Username is already existing",
        });
    },
    methods: {
        ...mapActions({
            save: "user/save",
        }),
        async initialize() {
            let vm = this;
            try {
                const data = await vm.find(vm.$route.params.id);
                vm.form = data;
                vm.form.position = data.positions;
                vm.oldEmail = data.email;
            } catch (e) {
                vm.$toast(e, "#B71C1C");
            }
        },
        async checkEmail(value) {
            var unique = (
                await axios.get("/is-unique", {
                    params: {
                        model: "User",
                        value: this.form.email,
                        field: "email",
                        id: this.form.id,
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
                        id: this.form.id,
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
                    const user = await vm.getUser();
                    vm.setUser(user);
                    vm.$toast(this.spiel.saved, "#2dce89");
                    vm.$router.go(-1);
                } catch (error) {
                    vm.$toast(vm.spiel.error, "#B71C1C");
                }
            } else {
                vm.$toast("Please fill out required fields.", "#B71C1C");
            }
        },
    },
};
</script>
