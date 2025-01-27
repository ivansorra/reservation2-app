import { createRouter, createWebHistory } from "vue-router";
import Login from "./components/login/loginComponent.vue";
import Form from "./components/form/formComponent.vue";
import QrCodeScanner from "./components/scanner/QrScannerComponent.vue";
import QrResponseComponent from "./components/qr_page/QrResponseComponent.vue";

// ------------------- Admin Components --------------------------------------
import adminComponent from "./components/templates/adminComponent.vue";
import membershipForm from "./components/admin/membershipForm.vue";
import indexComponent from "./components/admin/members/indexComponent.vue";
import rolesComponent from "./components/admin/user_roles/rolesComponent.vue";
import activityComponent from "./components/admin/activities/activityComponent.vue";
import adminLoginComponent from "./components/admin/login/indexComponent.vue";
import reservationComponent from "./components/admin/reservations/indexComponent.vue";
import usersComponent from "./components/admin/users/indexComponent.vue";
import registerAdminComponent from "./components/admin/login/registerComponent.vue";
// ---------------------------------------------------------------------------

const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/reservation_form",
        name: "form",
        component: Form,
        meta: { requiresAuth: true },
    },
    {
        path: "/qr_response",
        name: "qr_response",
        component: QrResponseComponent,
        // meta: { requiresAuth: true }
    },
    {
        path: "/scanner",
        name: "scanner",
        component: QrCodeScanner,
        meta: { requiresAuth: true },
    },
    {
        path: "/login",
        name: "adminlogin",
        component: adminLoginComponent,
    },
    {
        path: "/register",
        name: "register",
        component: registerAdminComponent,
    },
    {
        path: "/admin",
        name: "admin",
        component: adminComponent,
        children: [
            {
                path: "",
                name: "index",
                component: membershipForm,
            },
            {
                path: "membership",
                name: "membership",
                component: indexComponent,
            },
            {
                path: "users",
                name: "users",
                component: usersComponent,
            },
            {
                path: "roles",
                name: "roles",
                component: rolesComponent,
            },
            {
                path: "reservations",
                name: "reservations",
                component: reservationComponent,
            },
            {
                path: "travel_logs",
                name: "travel_logs",
                component: activityComponent,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = sessionStorage.getItem("info"); // Example for auth status

    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: "login" });
    } else if (to.name === "login" && isAuthenticated) {
        next({ name: "form" });
    } else {
        // Allow navigation
        next();
    }
});

export default router;
