<template>
    <div class="background">
        <v-parallax height="300" src="/img/topbg.jpg">
            <v-container>
                <v-row no-gutters align="center" justify="center">
                    <v-col cols="4" align-self="center" class="text-center">
                        <h1>TRACK ORDER</h1>
                    </v-col>
                </v-row>
            </v-container>
        </v-parallax>
        <v-toolbar dense color="white" elevation="1">
            <bread-crumbs></bread-crumbs>
        </v-toolbar>
        <v-container>
            <v-row align="center" justify="center">
                <v-col align-self="align" cols="10">
                    <v-card
                        width="100%"
                        height="300"
                        elevation="0"
                        class="mt-1"
                    >
                        <v-card-text
                            class="display-1 text-center black--text pt-14"
                        >
                            Track your order by order number
                        </v-card-text>
                        <v-card-actions>
                            <v-row align="center" justify="center">
                                <v-col align-self="align" cols="9">
                                    <v-text-field
                                        filled
                                        placeholder="Order Number"
                                    ></v-text-field>
                                    <v-btn
                                        color="secondary"
                                        class="primary--text"
                                        block
                                    >
                                        Track
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<route-meta>{ "breadcrumb": "Track Order"}</route-meta>
<script>
export default {};
</script>
<style lang=""></style>
