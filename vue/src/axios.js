import axios from "axios";
import store from "./store/index";

const host = import.meta.env.VITE_API_BASE_URL;

const http = axios.create({
    baseURL: `${host}/api`,
});

http.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;
    return config;
});

export default http;
