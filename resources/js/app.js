import './bootstrap.js';

import { createApp } from 'vue';
import router from './routes.js';
import App from './layouts/App.vue';
const app = createApp(App);
// const app = createApp({});

app.use(router);
app.mount('#app');
