<template>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2
            class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
        >
            Log in to your account
        </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" @submit.prevent="login">
            <Alert
                v-if="errorMsg || Object.keys(errors).length"
                class="flex-col items-stretch text-sm"
            >
                <span v-if="errorMsg" class="block mb-2">
                    {{ errorMsg }}
                </span>
                <div v-for="(errorKey, ind) in Object.keys(errors)" :key="ind">
                    <div
                        class=""
                        v-for="(error, i) in errors[errorKey]"
                        :key="i"
                    >
                        {{ "*  " + error }}
                    </div>
                </div>
            </Alert>
            <div>
                <label
                    for="email"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Email address</label
                >
                <div class="mt-2">
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        v-model="user.email"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label
                        for="password"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Password</label
                    >
                </div>
                <div class="mt-2">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        v-model="user.password"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                </div>
            </div>
            <div class="flex gap-2 items-center">
                <input
                    class="rounded-md border-gray-400 focus:ring-indigo-500 h-4 w-4 text-indigo-600"
                    type="checkbox"
                    name="remember"
                    id="remember"
                    v-model="user.remember"
                />
                <label for="remember">Remember me</label>
            </div>
            <div>
                <button
                    :disabled="loading"
                    type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    :class="{
                        'cursor-not-allowed': loading,
                        'hover:bg-indigo-500': loading,
                    }"
                >
                    <svg
                        v-if="loading"
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    Sign in
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Not a member?
            {{ " " }}
            <router-link
                :to="{ name: 'Signup' }"
                class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                >Signup for free</router-link
            >
        </p>
    </div>
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import Alert from "../components/Alert.vue";

const errorMsg = ref("");
const errors = ref({});
const user = {
    email: "",
    password: "",
    remember: false,
};
const store = useStore();
const router = useRouter();
const loading = ref(false);

function login() {
    loading.value = true;
    store
        .dispatch("login", user)
        .then(() => {
            loading.value = false;
            router.push({ name: "Dashboard" });
        })
        .catch((err) => {
            loading.value = false;
            errorMsg.value = err.response.data.message;
            errors.value = err.response.data.errors || [];
        });
}
</script>
