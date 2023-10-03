<template>
    <Page title="Dashboard">
        <div v-if="loading" class="flex justify-center">Loading...</div>
        <div
            v-else
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2"
        >
            <div
                class="p-3 animate-fade-in-down text-center bg-white order-1 lg:order-2 flex flex-col shadow-md rounded"
                style="animation-delay: 0.1s"
            >
                <h3 class="font-medium text-2xl">Total Surveys</h3>
                <div
                    class="flex items-center justify-center text-8xl font-medium flex-grow"
                >
                    {{ data.totalSurveys }}
                </div>
            </div>
            <div
                class="p-3 animate-fade-in-down text-center order-2 lg:order-4 flex flex-col bg-white shadow-md"
                style="animation-delay: 0.2s"
            >
                <h3 class="font-medium text-2xl">Total Submissions</h3>
                <div
                    class="flex items-center justify-center text-8xl font-medium flex-grow"
                >
                    {{ data.totalSubmissions }}
                </div>
            </div>

            <div
                class="p-3 animate-fade-in-down row-span-2 order-3 lg:order-1 bg-white shadow-md"
            >
                <div
                    v-if="data.latestSurvey"
                    class="h-full flex justify-between flex-col"
                >
                    <h3 class="text-2xl font-medium mb-3">Latest Survey</h3>

                    <img
                        :src="
                            data.latestSurvey.image_url ||
                            'https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg'
                        "
                        class="w-full h-48 rounded mx-auto object-cover block mb-2"
                        alt=""
                    />
                    <h3 class="font-bold text-xl mb-3">
                        {{ data.latestSurvey.title }}
                    </h3>
                    <div>
                        <div class="flex justify-between text-sm">
                            <span class="block">Created Date : </span>
                            <span class="block">
                                {{ data.latestSurvey.created_at }}</span
                            >
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="block">Expire Date : </span>
                            <span class="block">
                                {{ data.latestSurvey.expire_date }}</span
                            >
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="block">Status : </span>
                            <span class="block">
                                {{
                                    data.latestSurvey.status
                                        ? "Active"
                                        : "Draft"
                                }}</span
                            >
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="block">Questions : </span>
                            <span class="block">
                                {{ data.latestSurvey.questions_count }}</span
                            >
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="block">Answers : </span>
                            <span class="block">
                                {{ data.latestSurvey.answers_count }}</span
                            >
                        </div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <router-link
                            :to="{
                                name: 'SurveyView',
                                params: { id: data.latestSurvey.id },
                            }"
                            class="flex gap-2 py-2 px-3 hover:bg-indigo-700 transition-colors text-sm rounded-md focus:ring-1 focus:ring-offset-2 focus:ring-indigo-500 hover:text-white text-indigo-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-5 h-5"
                            >
                                <path
                                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z"
                                />
                            </svg>
                            Edit Survey</router-link
                        >
                        <router-link
                            :to="{
                                name: 'SurveySubmissions',
                                params: { surveyId: data.latestSurvey.id },
                            }"
                            class="flex gap-2 py-2 px-3 hover:bg-indigo-700 transition-colors text-sm rounded-md focus:ring-1 focus:ring-offset-2 focus:ring-indigo-500 hover:text-white text-indigo-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                            </svg>

                            View Submissions</router-link
                        >
                    </div>
                </div>

                <div class="flex justify-center items-center h-full" v-else>
                    <h3 class="text-xl text-gray-600 font-medium">
                        No Surveys available
                    </h3>
                </div>
            </div>
            <div
                class="p-3 animate-fade-in-down row-span-2 order-4 lg:order-3 bg-white shadow-md"
                style="animation-delay: 0.3s"
            >
                <div
                    class="h-full flex flex-col gap-5"
                    v-if="data.latestSubmissions.length"
                >
                    <h3 class="text-2xl font-medium">Latest Submissions</h3>

                    <div class="flex flex-grow flex-col">
                        <div
                            href="#"
                            v-for="submission of data.latestSubmissions"
                            :key="submission.id"
                        >
                            <router-link
                                :to="{
                                    name: 'AnswerView',
                                    params: {
                                        surveyId: submission.survey.id,
                                        submissionId: submission.id,
                                    },
                                }"
                                class="block p-2 hover:bg-gray-100/90"
                            >
                                <div>{{ submission.survey.title }}</div>
                                <small class="font-medium">
                                    Submission Made at:
                                    <span class="font-medium">{{
                                        submission.end_date
                                    }}</span>
                                </small>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div v-else class="h-full flex items-center justify-center">
                    <h3 class="text-xl text-gray-600 font-medium">
                        No Submissions available
                    </h3>
                </div>
            </div>
        </div>
    </Page>
</template>

<script setup>
import Page from "../components/Page.vue";
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

const loading = computed(() => store.state.dashboard.loading);
const data = computed(() => store.state.dashboard.data);

// Retrieve all Dashboard data
store.dispatch("getDashboardData");

// Listen to new submitted surveys.
Echo.private("survey." + store.state.user.data.id).listen(
    ".SurveySubmitted",
    (event) => {
        store.dispatch("updateDashboardData", {
            event: "SurveySubmitted",
            data: event.submission,
        });
    }
);

// Listen to new created surveys.
Echo.private("survey." + store.state.user.data.id).listen(
    ".SurveyCreated",
    (event) => {
        store.dispatch("updateDashboardData", {
            event: "SurveyCreated",
            data: event.survey,
        });
    }
);
</script>
