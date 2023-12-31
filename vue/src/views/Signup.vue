<template>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2
            class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
        >
            Sign in to your account
        </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <Alert
            v-if="Object.keys(errors).length"
            class="flex-col items-stretch text-sm"
        >
            <div v-for="(errorKey, ind) in Object.keys(errors)" :key="ind">
                <div class="" v-for="(error, i) in errors[errorKey]" :key="i">
                    {{ "*  " + error }}
                </div>
            </div>
        </Alert>
        <form class="space-y-6" @submit.prevent="register">
            <div>
                <label
                    for="fullname"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Full name</label
                >
                <div class="mt-2">
                    <input
                        id="fullname"
                        name="name"
                        type="text"
                        v-model="user.name"
                        autocomplete="name"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                </div>
            </div>
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
                        type="text"
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
            <div>
                <label
                    for="password_confirmation"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Password Confirmation</label
                >
                <div class="mt-2">
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="current-password"
                        v-model="user.password_confirmation"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                </div>
            </div>
            <div>
                <button
                    :disabled="loading"
                    type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
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
                    Sign up
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Not a member?
            {{ " " }}
            <router-link
                :to="{ name: 'Login' }"
                class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                >Login to your account</router-link
            >
        </p>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import { ref } from "vue";
import Alert from "../components/Alert.vue";

const router = useRouter();
const store = useStore();
const errors = ref({});
const loading = ref(false);
const user = { name: "", email: "", password: "", password_confirmation: "" };
function register() {
    loading.value = true;
    store
        .dispatch("register", user)
        .then(() => {
            loading.value = false;
            router.push({ name: "Dashboard" });
        })
        .catch((err) => {
            loading.value = false;
            errors.value = err.response.data.errors;
        });
}
</script>
