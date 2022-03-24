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
                            <v-autocomplete
                                label="Category"
                                v-validate="'required'"
                                :items="categories"
                                class="required"
                                item-text="name"
                                item-value="id"
                                data-vv-name="category"
                                v-model="form.category"
                                :error-messages="errors.collect('category')"
                            ></v-autocomplete>
                            <v-text-field
                                v-model="form.name"
                                label="Name"
                                data-vv-name="Name"
                                v-validate="'required'"
                                class="required"
                                :error-messages="errors.collect('Name')"
                            ></v-text-field>
                            <v-textarea
                                v-model="form.description"
                                label="Description"
                                data-vv-name="Description"
                                v-validate="'required'"
                                class="required"
                                :error-messages="errors.collect('Description')"
                            ></v-textarea>

                            <v-text-field
                                v-model="form.quantity"
                                label="Quantity"
                                data-vv-name="Quantity"
                                v-validate="'required'"
                                class="required"
                                :error-messages="errors.collect('Quantity')"
                            ></v-text-field>
                            <g-number-input
                                v-model="form.price"
                                label="Price"
                                data-vv-name="price"
                                v-validate="'required'"
                                class="required"
                                :error-messages="errors.collect('price')"
                            ></g-number-input>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <vv-btn @click="$router.go(-1)">Close</vv-btn>
                            <vv-btn @click="submit" color="primary"
                                >Save</vv-btn
                            >
                        </v-card-actions>
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
import { mapActions, mapGetters, mapState } from "vuex";
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

    computed: {
        ...mapGetters("menu", ["find"]),
        id() {
            return this.$route.params.id;
        },
        ...mapState({
            categories: (state) => state.category.list,
        }),
    },
    mounted() {
        let vm = this;
        vm.initialize();
        vm.getCategories();
    },
    methods: {
        ...mapActions({
            getCategories: "category/fetch",
            save: "menu/save",
        }),
        async initialize() {
            let vm = this;
            try {
                const data = await vm.find(vm.$route.params.id);
                vm.form = data;
                vm.form.category = data.category_id;
            } catch (e) {
                vm.$toast(e, "#B71C1C");
            }
        },
        async submit() {
            let vm = this;

            const valid = await vm.$validator.validateAll();
            if (valid) {
                try {
                    const data = await vm.save(vm.form);
                    if (data == "error") {
                        vm.$toast("Image is required", "error");
                    } else {
                        vm.$toast(this.spiel.saved, "success");
                        vm.$router.go(-1);
                    }
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
