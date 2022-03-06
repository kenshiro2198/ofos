<template>
    <v-card style="border-radius: 30px" height="50px">
        <div class="d-flex">
            <v-text-field
                placeholder="Search for your favorite food"
                rounded
                hide-details
                block
                class="mt-0"
            ></v-text-field>
            <v-btn
                color="secondary"
                dark
                x-large
                depressed
                class="primary--text"
                style="
                    border-radius: 30px;
                    width: 140px;
                    height: 50px;
                    font-size: 12px;
                "
                >search</v-btn
            >
        </div>
    </v-card>
</template>
<script>
export default {};
</script>
