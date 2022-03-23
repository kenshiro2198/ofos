<template>
    <v-row>
        <v-col :class="`d-flex justify-${justify || 'start'}`" cols="12">
            <v-hover class="my-3">
                <v-avatar
                    :size="size"
                    class="elevation-1"
                    slot-scope="{ hover }"
                >
                    <v-img :src="img_url">
                        <label
                            class="v-btn v-btn--text v-btn--icon theme--light fill-height fill-width ma-0 pointer"
                        >
                            <v-btn
                                @click="showCam = true"
                                icon
                                x-large
                                v-if="cam"
                            >
                                <v-icon color="white" v-show="hover"
                                    >mdi-camera</v-icon
                                >
                            </v-btn>
                            <template v-else>
                                <v-icon color="white" v-show="hover"
                                    >mdi-camera</v-icon
                                >
                                <input
                                    @change="fileChange"
                                    type="file"
                                    hidden
                                    accept="image/png, image/jpeg"
                                />
                            </template>
                        </label>
                    </v-img>
                </v-avatar>
            </v-hover>
        </v-col>
        <v-col v-if="validation.bool" cols="12">
            <span class="error--text">{{ validation.msg }}</span>
        </v-col>
        <v-dialog v-model="showCropper" persistent max-width="500">
            <v-card>
                <v-card-title class="pa-2">
                    Crop Image
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-card-text>
                    <v-row
                        v-if="loadingCropper"
                        align="center"
                        justify="center"
                        class="ma-0 pa-5"
                    >
                        <v-progress-circular
                            indeterminate
                            color="primary"
                        ></v-progress-circular>
                    </v-row>
                    <cropper
                        ref="cropper"
                        @ready="loadingCropper = false"
                        class="cropper"
                        :src="internalValue"
                        :stencilProps="{}"
                        :stencilComponent="$options.components.CircleStencil"
                    ></cropper>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        @click="showCropper = false"
                        :disabled="loadingCropper"
                        text
                        >Cancel</v-btn
                    >
                    <v-btn
                        @click="cropImage"
                        :disabled="loadingCropper"
                        :loading="cropping"
                        color="primary"
                        outlined
                        >Crop</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            :fullscreen="$vuetify.breakpoint.smAndDown"
            v-model="showCam"
            width="500"
        >
            <v-card>
                <v-card-title>
                    <v-btn @click="showCam = false" icon>
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    Capture Photo
                    <v-spacer></v-spacer>

                    <label class="v-btn pa-2">
                        <a class="caption blue--text font-weight-bold">
                            <v-icon>mdi-image</v-icon>
                            Browse</a
                        >
                        <input
                            @change="fileChange"
                            type="file"
                            hidden
                            accept="image/png, image/jpeg"
                        />
                    </label>
                </v-card-title>
                <v-card-text>
                    <WebCam ref="webcam" width="100%" height="100%" />
                    <div class="d-flex justify-center">
                        <v-btn
                            rounded
                            color="blue"
                            class="mt-3"
                            dark
                            @click="capture"
                        >
                            <v-icon left>mdi-camera</v-icon>
                            Capture
                        </v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
        <img style="visibility: hidden" id="coppedimage" src />
    </v-row>
</template>

<script>
import { Cropper, CircleStencil } from "vue-advanced-cropper";
import { WebCam } from "vue-cam-vision";
import "vue-advanced-cropper/dist/style.css";

export default {
    components: {
        Cropper,
        CircleStencil,
        WebCam,
    },
    props: {
        cam: {
            type: Boolean,
            default: false,
        },
        value: {
            type: String,
            default: "",
        },
        size: {
            type: String,
            default: 32,
        },
        justify: {
            type: String,
            default: "center",
        },
    },
    data() {
        return {
            showCam: false,
            validation: {
                bool: false,
                msg: "",
            },
            img_url:
                "https://deconova.eu/wp-content/uploads/2016/02/default-placeholder.png",
            showCropper: false,
            loadingCropper: true,
            cropping: false,
            internalValue: null,
        };
    },
    created() {
        if (this.value) {
            this.img_url = this.value;
        }
    },
    watch: {
        value(val) {
            if (val) {
                this.img_url = val;
            }
        },
        async showCam(e) {
            let vm = this;
            let camera = vm.$refs.webcam;
            if (!e) {
                await camera.stop();
            } else {
                await camera.start();
            }
        },
    },
    methods: {
        async capture(e) {
            let vm = this;
            let camera = vm.$refs.webcam;
            vm.value = await camera.capture();
            vm.showCam = false;

            //init cropper
            var reader = new FileReader();
            vm.internalValue = vm.value;
            this.showCropper = true;
        },
        fileChange(e) {
            let vm = this;
            let filetype = e.target.files[0].type.substr(0, 5);
            if (filetype && filetype != "image") {
                vm.validation.bool = true;
                vm.validation.msg = "Avatar must be an image";
                vm.props.value = null;
                return;
            } else {
                vm.validation.bool = false;
                var files = e.target.files;
                if (files.length) {
                    var reader = new FileReader();
                    reader.readAsDataURL(files[0]);
                    vm.internalValue = URL.createObjectURL(files[0]);
                    this.showCropper = true;
                }
            }
        },
        cropImage() {
            this.cropping = true;
            const result = this.$refs.cropper.getResult();
            this.img_url = result.canvas.toDataURL("image/jpeg");
            this.$emit("input", this.img_url);
            this.showCam = false;
            this.showCropper = false;
            this.cropping = false;
        },
    },
};
</script>

<style scope>
.fill-width {
    width: 100% !important;
}
</style>
