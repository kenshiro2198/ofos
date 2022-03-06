import '@mdi/font/css/materialdesignicons.css'
import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
Vue.use(Vuetify);
export default new Vuetify({
    icons: {
        iconfont: "mdi"
    },
    theme: {
        options: {
            customProperties: true
        },
        themes: {
            light: {
                primary: '#1b1b1b',
                secondary: '#f4d017',
                tertiary: '#ea1b25',
                tertiary2: '#0b183a',
                quarternary: '#252a40',
                background: '#f4f4f6',
            },
            dark: {
                primary: '#5bba45',
                tertiary: '#0b183a',
                tertiary2: '#a8b8e2',
                background: '#303030',
                quarternary: '#161925',
            }
        }
    }
});