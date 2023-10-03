<script setup>
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

const token = computed(() => store.state.user.token);

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_APP_WEBSOCKETS_KEY,
    wsHost: import.meta.env.VITE_APP_WEBSOCKETS_SERVER,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    authEndpoint: "http://127.0.0.1:8000/api/broadcasting/auth",
    auth: {
        headers: {
            authorization: "Bearer " + token.value,
        },
    },
});
</script>

<template>
    <router-view :key="$route.path"></router-view>
</template>
