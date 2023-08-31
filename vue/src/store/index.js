import { createStore } from "vuex";
import http from "../axios";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },
        dashboard: {
            loading: false,
            data: {},
        },
        surveys: {
            loading: false,
            data: [],
            links: [],
        },
        submissions: {
            data: [],
            loading: false,
        },
        currentSurvey: {
            loading: false,
            data: null,
        },
        currentAnswer: {
            loading: false,
            data: null,
        },
        questionTypes: ["text", "select", "radio", "checkbox", "textarea"],
        notification: {
            show: false,
            type: null,
            message: null,
        },
    },
    getters: {},
    actions: {
        getDashboardData({ commit }) {
            commit("setDashboardLoading", true);
            http.get("/dashboard")
                .then((res) => {
                    commit("setDashboardLoading", false);
                    commit("setDashboardData", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setDashboardLoading", false);
                    throw err;
                });
        },
        fetchSurveys({ commit }, { url = null } = {}) {
            url = url || "/survey";
            commit("setSurveysLoading", true);
            return http.get(url).then((res) => {
                commit("setSurveys", res.data);
                commit("setSurveysLoading", false);
                return res;
            });
        },
        fetchSurvey({ commit }, survey) {
            commit("setCurrentSurveyLoading", true);
            return http
                .get(`/survey/${survey}`)
                .then((res) => {
                    commit("setCurrentSurvey", res.data);
                    commit("setCurrentSurveyLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSurveyLoading", false);
                    throw err;
                });
        },
        fetchSurveyBySlug({ commit }, surveySlug) {
            commit("setCurrentSurveyLoading", true);
            http.get(`/survey-by-slug/${surveySlug}`)
                .then((res) => {
                    commit("setCurrentSurvey", res.data);
                    commit("setCurrentSurveyLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSurveyLoading", false);
                    throw err;
                });
        },
        fetchSurveySubmissions({ commit }, survey) {
            commit("setSurveySubmissionsLoading", true);
            http.get(`/survey/${survey}/submissions`)
                .then((res) => {
                    commit("setSurveySubmissions", res.data);
                    commit("setSurveySubmissionsLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setSurveySubmissionsLoading", false);
                    throw err;
                });
        },
        fetchSurveyAnswer({ commit }, { survey, submission }) {
            commit("setSurveyAnswerLoading", true);
            http.get(`/survey/${survey}/submissions/${submission}`)
                .then((res) => {
                    commit("setSurveyAnswer", res.data);
                    commit("setSurveyAnswerLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setSurveyAnswerLoading", false);
                    throw err;
                });
        },

        saveSurveyAnswer({ commit }, { answers, survey }) {
            return http.post(`/survey/${survey}/answer`, { answers });
        },
        saveSurvey({ commit }, survey) {
            let response;
            delete survey.image_url;
            if (survey.id) {
                response = http
                    .put(`/survey/${survey.id}`, survey)
                    .then((res) => {
                        commit("setCurrentSurvey", res.data);
                        return res;
                    });
            } else {
                response = http.post("/survey", survey).then((res) => {
                    commit("setCurrentSurvey", res.data);
                    return res;
                });
            }
            return response;
        },
        deleteSurvey({ commit }, survey) {
            return http.delete(`/survey/${survey}`);
        },
        login({ commit }, user) {
            return http.post("/login", user).then(({ data }) => {
                commit("setUser", data);
                return data;
            });
        },
        register({ commit }, user) {
            return http.post("/register", user).then(({ data }) => {
                commit("setUser", data);
                return data;
            });
        },
        logout({ commit }) {
            return http
                .post("/logout")
                .then(({ data }) => {
                    commit("logout");
                    return data;
                })
                .catch((err) => {
                    commit("logout");

                    throw err;
                });
        },
    },

    mutations: {
        setSurveySubmissions(state, answers) {
            state.submissions.data = answers.data;
        },
        setSurveyAnswer(state, answer) {
            state.currentAnswer.data = answer.data;
        },
        setSurveySubmissionsLoading(state, value) {
            state.submissions.loading = value;
        },
        setSurveyAnswerLoading(state, value) {
            state.currentAnswer.loading = value;
        },
        setCurrentSurveyLoading(state, loading) {
            state.currentSurvey.loading = loading;
        },
        setSurveysLoading(state, loading) {
            state.surveys.loading = loading;
        },
        setCurrentSurvey(state, survey) {
            survey.data["expire_date"] = new Date(survey.data["expire_date"])
                .toISOString()
                .slice(0, 10);
            state.currentSurvey.data = survey.data;
        },
        setSurveys: (state, surveys) => {
            state.surveys.data = surveys.data;
            state.surveys.links = surveys.meta.links;
        },
        setDashboardLoading: (state, value) => {
            state.dashboard.loading = value;
        },
        setDashboardData: (state, data) => {
            state.dashboard.data = data;
        },
        logout: (state) => {
            state.user.data = {};
            state.user.token = null;
            sessionStorage.removeItem("TOKEN");
        },
        setUser: (state, data) => {
            state.user.data = data.user;
            state.user.token = data.token;
            sessionStorage.setItem("TOKEN", data.token);
        },

        notify: (state, { type, message }) => {
            state.notification.show = true;
            state.notification.type = type;
            state.notification.message = message;
            setTimeout(() => {
                state.notification.show = false;
            }, 3000);
        },
    },
    modules: {},
});

export default store;
