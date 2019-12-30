import Vue from "vue";
import VueRouter from "vue-router";
import LoginComponent from "./components/LoginComponent";
import AdminComponent from "./components/AdminComponent";
import RolesComponent from "./components/RolesComponent";
Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        redirect: "/login"
    },
    {
        path: "/login",
        component: LoginComponent,
        name: "Login"
    },
    {
        path: "/admin",
        component: AdminComponent,
        name: "Admin",
        children: [
            {
                path: "roles",
                component: RolesComponent,
                name: "Roles"
            }
        ],
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem("token")) {
                next();
            } else {
                next("/login");
            }
        }
    }
];

export default new VueRouter({ routes });
