<template>
    <div>
        <form transition="fade-transition" @submit.prevent="submit">
            <v-row>
                <v-col class="pt-0 pb-1 text-center" cols="12">
                    <span
                        class="overline font-weight-bold glass--text text--darken-4"
                        >G-District</span
                    >
                </v-col>
                <v-col
                    v-if="errorMsg ? errorMsg.length : false"
                    cols="12"
                    class="py-0"
                >
                    <div>
                        <v-alert class="mb-0" dismissible dense type="error">
                            <div v-for="(error, i) in errorMsg" :key="i">
                                • {{ error }}
                            </div>
                        </v-alert>
                        <v-alert
                            dismissible
                            dense
                            type="error"
                            v-if="value.length > 0"
                        >
                            <div v-for="(error, i) in value" :key="i">
                                • {{ error }}
                            </div>
                        </v-alert>
                    </div>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        rounded
                        autocomplete="new-password"
                        :disabled="loading"
                        hide-details
                        solo
                        autofocus="autofocus"
                        v-validate="'required'"
                        label="Email Address or Username"
                        prepend-inner-icon="mdi-email-outline"
                        v-model="form.identity"
                        data-vv-name="email or username"
                        :error-messages="errors.collect('email or username')"
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        rounded
                        autocomplete="new-password"
                        :disabled="loading"
                        @focus="focused = true"
                        @blur="focused = false"
                        hide-details
                        solo
                        label="Password"
                        v-validate="'required'"
                        v-model="form.password"
                        :prepend-inner-icon="
                            focused
                                ? 'mdi-lock-open-outline'
                                : 'mdi-lock-outline'
                        "
                        :type="show ? 'text' : 'password'"
                        name="password"
                        :error-messages="errors.collect('password')"
                        :append-icon="
                            !show ? 'mdi-eye-outline' : 'mdi-eye-off-outline'
                        "
                        @click:append="show = !show"
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" class="pb-0">
                    <v-row
                        :justify="`space-${
                            $vuetify.breakpoint.mdAndUp ? 'around' : 'between'
                        }`"
                        align="center"
                        dense
                    >
                        <v-col cols="4">
                            <v-checkbox
                                small
                                class="mt-0 pt-0"
                                hide-details
                                v-model="form.remember"
                            >
                                <template v-slot:label>
                                    <span class="text-truncate caption"
                                        >Keep me signed in</span
                                    >
                                </template>
                            </v-checkbox>
                        </v-col>
                        <v-col class="text-right pr-4 py-0" cols="4">
                            <a
                                style="
                                    text-decoration: none;
                                    white-space: nowrap;
                                "
                                class="caption blue--text pointer link"
                                @click="$router.push(`/forgot`)"
                                >Forgot password?</a
                            >
                        </v-col>
                    </v-row>
                </v-col>

                <v-col class="d-flex justify-center" cols="12">
                    <v-btn
                        rounded
                        :disabled="loading"
                        :loading="loading"
                        type="submit"
                        color="primary"
                        width="332"
                    >
                        <span
                            v-if="!loginSuccess"
                            class="font-weight-bold white--text"
                            >Login</span
                        >
                    </v-btn>
                </v-col>
            </v-row>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loginSuccess: false,
            loading: false,
            focused: false,
            show: false,
            form: {
                identity: "johnarbyarceo@gmail.com",
                password: "1234",
                type: 1,
            },
            login_error: [],
        };
    },
    computed: {
        errorMsg() {
            return this.errors.all();
        },
        value() {
            return this.login_error;
        },
    },
    methods: {
        async submit() {
            let vm = this;
            vm.login_error = [];
            const valid = await vm.$validator.validateAll();
            if (valid) {
                try {
                    vm.loading = true;
                    const { data } = await axios.post("/login", vm.form);
                    vm.$cookie.set("api_token", data.api_token);
                    location.href = "/";
                } catch (error) {
                    vm.loading = true;

                    if (error.response.status == "404") {
                        vm.login_error.push(
                            "User is not verified or inactive. Please check your email if it is not verified or contact the Kasipag Administrator"
                        );
                    } else if (error.response.status == "429") {
                        vm.errorMsg.push(
                            ((error.response || {}).data.errors || {})
                                .username[0]
                        );
                    } else {
                        vm.errorMsg.push(error.response.data);
                    }
                    vm.loading = false;
                    return;
                }
            }
        },
    },
};
</script>

<style>
.optional:before {
    content: "Optional";
    color: #909090;
    font-size: 0.8rem;
    position: absolute;
    top: 3px;
    right: 6px;
    font-weight: 300;
}
</style>
