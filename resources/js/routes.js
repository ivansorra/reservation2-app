import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/login/loginComponent.vue';
import Form from './components/form/formComponent.vue';
import QrCodeScanner from './components/scanner/QrScannerComponent.vue';
import adminComponent from './components/templates/adminComponent.vue';
import membershipForm from './components/admin/membershipForm.vue';
import indexComponent from './components/admin/members/indexComponent.vue';

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/reservation_form',
    name: 'form',
    component: Form,
    // meta: { requiresAuth: true }
  },
  {
    path: '/scanner',
    name:'scanner',
    component: QrCodeScanner,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin',
    name: 'admin',
    component: adminComponent,
    children: [
        {
            path: '',
            name: 'index',
            component: indexComponent
        },
        {
            path: 'membership',
            name: 'membership',
            component: membershipForm
        }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
