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
                                v-model="form.qty"
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
    created() {
        let vm = this;
        vm.getCategories();
    },
    computed: {
        ...mapState({
            categories: (state) => state.category.list,
        }),
    },
    methods: {
        ...mapActions({
            getCategories: "category/fetch",
            save: "menu/save",
        }),
        async submit() {
            let vm = this;

            const valid = await vm.$validator.validateAll();
            if (valid) {
                try {
                    const data = await vm.save(vm.form);
                    if (data == "error") {
                        vm.$toast("Image is required", "error");
                    } else {
                        vm.$toast(this.spiel.added, "success");
                        vm.form = {};
                    }
                } catch (error) {
                    vm.$toast(vm.spiel.error, "error");
                }
            } else {
                vm.$toast("Please fill out required fields.", "error");
            }
        },
    },
};
</script>
