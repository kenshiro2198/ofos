<template>
    <v-footer dark padless>
        <v-card flat tile class="primary white--text text-center" width="100%">
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="4">
                            <v-img
                                @click="$router.push('/')"
                                src="/img/logo_transparent.png"
                                width="100"
                            >
                            </v-img>
                        </v-col>
                        <v-col cols="4">
                            <v-list elevation="0" color="primary">
                                <v-list-item-group>
                                    <v-list-item
                                        @click="$router.push('/about-us')"
                                    >
                                        <v-list-item-content>
                                            About Us
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item
                                        @click="$router.push('/contact-us')"
                                    >
                                        <v-list-item-content>
                                            Contact Us
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-content>
                                            Admin Login
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-col>
                        <v-col cols="4">
                            <v-list elevation="0" color="primary">
                                <v-subheader>
                                    <h2 class="secondary--text">
                                        For news and updates, follow us
                                    </h2>
                                </v-subheader>
                                <v-list-item-group>
                                    <!-- <div> -->
                                    <v-btn
                                        icon
                                        small
                                        target="_blank"
                                        href="https://www.facebook.com/gdistrictofficial/"
                                    >
                                        <v-icon color="secondary">
                                            mdi-facebook
                                        </v-icon>
                                    </v-btn>
                                    <v-btn icon small>
                                        <v-icon color="secondary">
                                            mdi-twitter
                                        </v-icon>
                                    </v-btn>
                                    <v-btn icon small>
                                        <v-icon color="secondary">
                                            mdi-google-plus
                                        </v-icon>
                                    </v-btn>
                                    <!-- </div> -->
                                </v-list-item-group>
                            </v-list>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>

            <!-- <v-card-text class="white--text pt-0">
                Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit
                amet. Mauris cursus commodo interdum. Praesent ut risus eget
                metus luctus accumsan id ultrices nunc. Sed at orci sed massa
                consectetur dignissim a sit amet dui. Duis commodo vitae velit
                et faucibus. Morbi vehicula lacinia malesuada. Nulla placerat
                augue vel ipsum ultrices, cursus iaculis dui sollicitudin.
                Vestibulum eu ipsum vel diam elementum tempor vel ut orci. Orci
                varius natoque penatibus et magnis dis parturient montes,
                nascetur ridiculus mus.
            </v-card-text> -->

            <v-divider></v-divider>

            <v-card-text class="white--text"> G-District </v-card-text>
        </v-card>
    </v-footer>
</template>
<script>
export default {
    data: () => ({
        icons: ["mdi-facebook", "mdi-twitter", "mdi-linkedin", "mdi-instagram"],
    }),
};
</script>
