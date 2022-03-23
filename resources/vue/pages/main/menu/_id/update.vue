<template>
    <v-dialog persistent max-width="500" :value="true">
        <v-card rounded>
            <v-card-title>Category</v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="form.firstname"
                    label="name"
                    data-vv-name="name"
                    v-validate="'required'"
                    class="required"
                    :error-messages="errors.collect('name')"
                ></v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <vv-btn @click="$router.go(-1)">Close</vv-btn>
                <vv-btn @click="submit" color="primary">Save</vv-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<route-meta>
      {
      "breadcrumb": "Update"
      }
</route-meta>
<script>
import { Validator } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
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
