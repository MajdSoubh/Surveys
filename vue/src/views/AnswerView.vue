<template>
    <Page title="Answer View">
        <div v-if="loading" class="text-gray-600 text-center py-16">
            Loading...
        </div>
        <div
            v-else-if="answers.length == 0"
            class="text-gray-600 text-center py-16"
        >
            there is no question answerd yet
        </div>
        <div
            v-else
            class="shadow sm:rounded-md sm:overflow-hidden bg-white px-4 py-5"
        >
            <div class="space-y-8 ml-2 text-gray-800">
                <div v-for="(answer, ind) in answers">
                    <div class="flex flex-col">
                        <h3 class="font-medium text-xl block">
                            {{ ind + 1 }}. {{ answer.question.question }}
                        </h3>
                        <div class="ml-5 text-sm text-black">
                            Answer :

                            {{
                                Array.isArray(answer.answer)
                                    ? answer.answer.toString()
                                    : answer.answer
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Page>
</template>
<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import Page from "../components/Page.vue";

const store = useStore();
const route = useRoute();

const answers = computed(() => store.state.currentAnswer.data);
const loading = computed(() => store.state.currentAnswer.loading);

store.dispatch("fetchSurveyAnswer", {
    survey: route.params.surveyId,
    submission: route.params.submissionId,
});
</script>
<style></style>
