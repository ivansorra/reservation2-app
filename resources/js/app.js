import './bootstrap.js';

import { createApp } from 'vue';
import router from './routes.js';
import App from './layouts/App.vue';
import VueTailwindDatepicker from "vue-tailwind-datepicker";

const app = createApp(App);
// const app = createApp({});

app.use(VueTailwindDatepicker);
app.use(router);
app.mount('#app');
