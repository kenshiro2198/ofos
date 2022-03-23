<template>
    <v-dialog persistent max-width="500" :value="true">
        <v-card rounded>
            <v-card-title>Category</v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="form.firstname"
                    label="Name"
                    data-vv-name="Name"
                    v-validate="'required'"
                    class="required"
                    :error-messages="errors.collect('Name')"
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
      "breadcrumb": "Create"
      }
</route-meta>
<script>
import { Validator } from "vee-validate";
import { mapActions } from "vuex";
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
