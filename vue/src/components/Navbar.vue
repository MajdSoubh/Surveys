<template>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <h2 class="text-white text-lg tracking-widest font-bold">
                        Survey Time
                    </h2>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <router-link
                                v-for="item in navigation"
                                :key="item.name"
                                as="a"
                                :to="item.to"
                                active-class="bg-gray-900 text-white"
                                :class="[
                                    route.name === item.to.name
                                        ? ''
                                        : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                                    'block rounded-md px-3 py-2 text-base font-medium',
                                ]"
                                >{{ item.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="relative ml-3">
                            <div>
                                <button
                                    type="button"
                                    @click="profileOpen = !profileOpen"
                                    class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                >
                                    <span class="absolute -inset-1.5"></span
                                    ><span class="sr-only">Open user menu</span
                                    ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-8 h-8 text-white"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"
                                        ></path>
                                    </svg>
                                </button>
                            </div>
                            <div
                                v-if="profileOpen"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                                <button
                                    @click="logout"
                                    class="block w-full px-4 py-2 text-sm text-gray-700 cursor-pointer"
                                >
                                    Sign out
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button
                        @click="menuOpen = !menuOpen"
                        type="button"
                        class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                    >
                        <span class="absolute -inset-0.5"></span
                        ><span class="sr-only">Open main menu</span
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            aria-hidden="true"
                            class="block h-6 w-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                            ></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="menuOpen" class="md:hidden">
            <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                <router-link
                    v-for="item in navigation"
                    :key="item.name"
                    as="a"
                    :to="item.to"
                    active-class="bg-gray-900 text-white"
                    :class="[
                        route.name === item.to.name
                            ? ''
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                        'block rounded-md px-3 py-2 text-base font-medium',
                    ]"
                    >{{ item.name }}
                </router-link>
            </div>
            <div class="border-t border-gray-700 pb-3 pt-4">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-8 h-8 text-white"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"
                            ></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div
                            class="text-base font-medium leading-none text-white"
                        ></div>
                        <div
                            class="text-sm font-medium leading-none text-gray-400"
                        ></div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <button
                        type="button"
                        @click="logout"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white cursor-pointer"
                    >
                        Sign out
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>
<script setup>
import { useStore } from "vuex";
import { computed, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
const menuOpen = ref(false);
const profileOpen = ref(false);

const store = useStore();
const router = useRouter();
const route = useRoute();

const user = computed(() => store.state.user.data);

function logout() {
    store.dispatch("logout");
    router.push({ name: "Login" });
}

const navigation = [
    { name: "Dashboard", to: { name: "Dashboard" } },
    { name: "Surveys", to: { name: "Surveys" } },
];
</script>
<style></style>
