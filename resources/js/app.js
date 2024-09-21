import './bootstrap';

import { createApp } from 'vue';
import AdminDashboard from './components/AdminDashboard.vue';

const app = createApp(AdminDashboard);

app.mount('#app');