import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from "../components/DefaultLayout.vue";
import SurveyView from "../views/SurveyView.vue";
import SurveyPublicView from "../views/SurveyPublicView.vue";
import Dashboard from "../views/Dashboard.vue";
import Signup from "../views/Signup.vue";
import Login from "../views/Login.vue";
import Surveys from "../views/Surveys.vue";
import SurveySubmissions from "../views/SurveySubmissions.vue";
import AnswerView from "../views/AnswerView.vue";
import store from "../store/index.js";
import AuthLayout from "../components/AuthLayout.vue";

const routes = [
    {
        path: "/",
        redirect: "/dashboard",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: "/dashboard",
                name: "Dashboard",
                component: Dashboard,
            },
            {
                path: "/surveys",
                name: "Surveys",
                component: Surveys,
            },
            {
                path: "/surveys/create",
                name: "SurveyCreate",
                component: SurveyView,
            },
            {
                path: "/surveys/:id",
                name: "SurveyView",
                component: SurveyView,
            },
            {
                path: "/survey/:surveyId/submissions",
                name: "SurveySubmissions",
                component: SurveySubmissions,
            },
            {
                path: "/survey/:surveyId/submissions/:submissionId",
                name: "AnswerView",
                component: AnswerView,
            },
            /*   {
                path: "/answers/:surveyId/",
                name: "SurveyAnswers",
                component: SurveyAnswers,
            }, */
        ],
    },
    {
        path: "/view/survey/:slug",
        name: "SuveyPublicView",
        component: SurveyPublicView,
    },
    {
        name: "Auth",
        path: "/auth",
        component: AuthLayout,
        meta: { isGuest: true },
        redirect: "/Login",
        children: [
            {
                path: "/signup",
                name: "Signup",
                component: Signup,
            },
            {
                path: "/login",
                name: "Login",
                component: Login,
            },
        ],
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "Login" });
    } else if (to.meta.isGuest && store.state.user.token) {
        next({ name: "Dashboard" });
    } else {
        next();
    }
});

export default router;
