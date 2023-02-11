import * as Vue from 'vue';
import App from "./App.vue";
import router from './router';
import store from './store';
import VueAxios from "vue-axios";
import axios from "axios";

const app=Vue.createApp(App);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

app.use(VueAxios, axios)
    .use(store)
    .use(router)
    .mount("#app");