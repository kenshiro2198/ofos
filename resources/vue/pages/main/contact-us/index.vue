<template>
    <div class="background">
        <v-parallax height="300" src="/img/topbg.jpg">
            <v-container>
                <v-row no-gutters align="center" justify="center">
                    <v-col cols="4" align-self="center" class="text-center">
                        <h1>CONTACT US</h1>
                    </v-col>
                </v-row>
            </v-container>
        </v-parallax>
        <v-toolbar dense color="white" elevation="1">
            <bread-crumbs></bread-crumbs>
        </v-toolbar>
        <v-container>
            <v-row align="center" justify="center">
                <v-col align-self="center" cols="9">
                    <v-card
                        width="100%"
                        height="400"
                        elevation="0"
                        class="mt-1"
                    >
                        <v-row>
                            <v-col></v-col>
                        </v-row>
                        <v-row>
                            <v-col></v-col>
                        </v-row>
                        <v-row>
                            <v-col></v-col>
                        </v-row>
                        <v-row>
                            <v-col></v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="4">
                                <v-card-text class="text-center">
                                    <v-icon x-large> mdi-phone </v-icon>
                                </v-card-text>
                                <v-card-text
                                    class="text-center font-weight-bold primary--text"
                                >
                                    PHONE
                                </v-card-text>
                                <v-card-text class="text-center primary--text">
                                    Phone: 0905 251 0069
                                </v-card-text>
                            </v-col>
                            <v-divider vertical></v-divider>
                            <v-col cols="4">
                                <v-card-text class="text-center">
                                    <v-icon x-large> mdi-map-marker </v-icon>
                                </v-card-text>
                                <v-card-text
                                    class="text-center font-weight-bold primary--text"
                                >
                                    Address
                                </v-card-text>

                                <v-card-text class="text-center primary--text">
                                    #2 Corvette St. Corner Buick St., South
                                    Fairview, Quezon City, Philippines
                                </v-card-text>
                            </v-col>
                            <v-divider vertical></v-divider>
                            <v-col cols="4">
                                <v-card-text class="text-center">
                                    <v-icon x-large> mdi-email </v-icon>
                                </v-card-text>
                                <v-card-text
                                    class="text-center font-weight-bold primary--text"
                                >
                                    EMAIL
                                </v-card-text>
                                <v-card-text class="text-center primary--text">
                                    gdistrict@gmail.com
                                </v-card-text>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<route-meta>{ "breadcrumb": "Contact Us"}</route-meta>
<script>
export default {};
</script>
<style lang=""></style>
