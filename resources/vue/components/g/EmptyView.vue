<template>
    <v-row class="fill-height">
        <v-col class="d-flex justify-center align-end" cols="12">
            <v-icon size="64">
                {{ icon }}
            </v-icon>
        </v-col>
        <v-col cols="12">
            <v-row dense>
                <v-col
                    class="text-center title d-flex justify-center align-start"
                    cols="12"
                >
                    {{ title }}
                </v-col>
                <v-col
                    class="text-center subtitle-2 d-flex justify-center align-start"
                    cols="12"
                >
                    {{ subtitle }}
                </v-col>
                <v-col class="mt-3 d-flex justify-center align-start" cols="12">
                    <slot></slot>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>
<script>
export default {
    props: {
        icon: {
            type: String,
            default: "",
        },
        title: {
            type: String,
            default: "",
        },
        subtitle: {
            type: String,
            default: "",
        },
    },
    data() {
        return {};
    },
    computed: {},
    methods: {},
    watch: {},
};
</script>
