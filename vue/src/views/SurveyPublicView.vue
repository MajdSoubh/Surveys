<template>
    <div class="mx-5 my-5">
        <div v-if="surveyLoading" class="flex justify-center">Loading...</div>
        <div v-else-if="!survey" class="flex justify-center">
            Sorry, Survey not available now.
        </div>
        <form @submit.prevent="submitSurvey" v-else>
            <div class="grid grid-cols-5 gap-6">
                <img
                    :src="
                        survey.image_url ||
                        'https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg'
                    "
                    class="w-full h-48 object-cover rounded col-span-5 md:col-span-2 lg:col-span-1"
                    :alt="survey.title"
                />
                <div
                    class="col-span-5 md:col-span-3 lg:col-span-4 text-center md:text-start"
                >
                    <h1 class="font-medium text-2xl">{{ survey.title }}</h1>
                    <div
                        v-html="survey.description"
                        class="mt-2 text-gray-500"
                    ></div>
                </div>
            </div>
            <hr class="my-3" />
            <div v-if="surveyFinished">
                <div class="text-xl font-semibold text-center mt-6">
                    Thank you for participating in this survey.
                </div>
                <button
                    @click="submitAnotherResponse"
                    class="mx-auto block shadow-sm text-sm mt-4 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white"
                >
                    Submit another response
                </button>
            </div>
            <div v-else>
                <div
                    v-for="(question, ind) in survey.questions"
                    :key="question.id"
                >
                    <QuestionViewer
                        :question="question"
                        :index="ind"
                        v-model="answers[question.id]"
                    />
                </div>
                <button
                    type="submit"
                    class="mx-auto block shadow-sm text-sm mt-4 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>
<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import { ref } from "vue";
import QuestionViewer from "../components/viewer/QuestionViewer.vue";

const route = useRoute();
const store = useStore();

const answers = ref({});

const survey = computed(() => store.state.currentSurvey.data);

const surveyLoading = computed(() => store.state.currentSurvey.loading);

const surveyFinished = ref(false);

store.dispatch("fetchSurveyBySlug", route.params.slug);

function submitSurvey() {
    store
        .dispatch("saveSurveyAnswer", {
            survey: survey.value.id,
            answers: answers.value,
        })
        .then((res) => {
            if (res.status === 201 || res.status === 200) {
                surveyFinished.value = true;
            }
        });
}

function submitAnotherResponse() {
    answers.value = {};
    surveyFinished.value = false;
}
</script>
<style></style>
