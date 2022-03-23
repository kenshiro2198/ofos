const mix = require('laravel-mix');
const VueAutoRoutingPlugin = require("./vue.routing");
const webpack = require("webpack");

mix.webpackConfig({
   output: {
       filename: "[name].js",
       chunkFilename: "js/chunks/[name].js"
   },
   resolve: {
       alias: {
           "@": path.resolve(__dirname, "resources/vue"),
           "@js": path.resolve(__dirname, "resources/js"),
           "@mixin": path.resolve(__dirname, "resources/js/mixins"),
           "@plugins": path.resolve(__dirname, "resources/js/plugins"),
           "@routes": path.resolve(__dirname, "resources/js/routes"),
           "@pages": path.resolve(__dirname, "resources/vue/pages"),
           "@layouts": path.resolve(__dirname, "resources/vue/layouts"),
         //   "@admin": path.resolve(__dirname, "resources/vue/pages/admin"),
           "@main": path.resolve(__dirname, "resources/vue/pages/main"),
           "@auth": path.resolve(__dirname, "resources/vue/pages/auth"),
           "@components": path.resolve(__dirname, "resources/vue/components")
       }
   },
   plugins: [
       new VueAutoRoutingPlugin({
           pages: "resources/vue/pages/main/",
           importPrefix: "@main/",
           output: "resources/js/routes/main/routes.js"
       }),
       new VueAutoRoutingPlugin({
           pages: "resources/vue/pages/auth/",
           importPrefix: "@auth/",
           output: "resources/js/routes/auth/routes.js"
       }),
       /* new VueAutoRoutingPlugin({
         pages: "resources/vue/pages/admin/",
         importPrefix: "@admin/",
         output: "resources/js/routes/admin/routes.js"
     }), */
       new webpack.ProvidePlugin({
           _: "lodash"
       })
   ]
});
mix
// .js("resources/js/admin", "public/js/admin.js")
    .js("resources/js/main", "public/js/main.js")
    .js("resources/js/auth", "public/js/auth.js")
    .sass("resources/sass/app.scss", "public/css")
    .disableSuccessNotifications();

