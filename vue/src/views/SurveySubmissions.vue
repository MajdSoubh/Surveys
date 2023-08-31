<template>
    <Page title="Survey Answers">
        <div v-if="loading" class="text-gray-600 text-center py-16">
            Loading...
        </div>
        <div
            v-else-if="submissions.length == 0"
            class="text-gray-600 text-center py-16"
        >
            Your don't have any submissions yet
        </div>
        <div v-else class="bg-white px-3 py-3 rounded-md shadow-md">
            <ul class="space-y-5">
                <li
                    v-for="(submission, ind) in submissions"
                    :key="ind"
                    class="hover:bg-indigo-500 hover:text-white py-2 rounded-md cursor-pointer font-medium text-center text-lg"
                >
                    <router-link
                        class="w-full block h-full"
                        :to="{
                            name: 'AnswerView',
                            params: {
                                surveyId: route.params.surveyId,
                                submissionId: submission.id,
                            },
                        }"
                    >
                        {{ submission.start_date }}
                    </router-link>
                </li>
            </ul>
        </div>
    </Page>
</template>
<script setup>
import Page from "../components/Page.vue";

import { useStore } from "vuex";
import { computed } from "vue";
import { useRoute } from "vue-router";

const store = useStore();
const route = useRoute();

store.dispatch("fetchSurveySubmissions", route.params.surveyId);

const loading = computed(() => store.state.submissions.loading);
const submissions = computed(() => store.state.submissions.data);
</script>
<style></style>
