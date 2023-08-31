<template>
    <Page>
        <template v-slot:header>
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                    Surveys
                </h1>
                <router-link
                    :to="{ name: 'SurveyCreate' }"
                    class="flex items-center justify-center gap-1 py-2 px-3 bg-emerald-500 hover:bg-emerald-600 rounded-md text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M12 5.25a.75.75 0 01.75.75v5.25H18a.75.75 0 010 1.5h-5.25V18a.75.75 0 01-1.5 0v-5.25H6a.75.75 0 010-1.5h5.25V6a.75.75 0 01.75-.75z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Add new Survey</router-link
                >
            </div>
        </template>
        <div v-if="surveys.loading" class="text-gray-600 text-center py-16">
            Loading...
        </div>
        <div
            v-else-if="surveys.data.length == 0"
            class="text-gray-600 text-center py-16"
        >
            Your don't have any surveys yet
        </div>
        <div v-else>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                <SurveyListItem
                    v-for="(survey, ind) in surveys.data"
                    @delete="deleteSurvey(survey)"
                    class="animate-fade-in-down"
                    :style="{ animationDelay: `${ind * 0.1}s` }"
                    :key="survey.id"
                    :survey="survey"
                />
            </div>
            <div class="flex justify-center mt-5">
                <nav
                    class="inline-flex justify-center rounded-md shadow-sm -space-x-px"
                    aria-label="Pagination"
                >
                    <a
                        v-for="(link, i) in surveys.links"
                        :key="i"
                        :disabled="!link.url"
                        :href="link.url"
                        @click.prevent="getForPage(link)"
                        v-html="link.label"
                        class="px-4 py-2 font-medium text-sm whitespace-nowrap border"
                        :class="[
                            link.active
                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                            i == 0 ? 'rounded-l-md' : '',
                            i === surveys.links.length - 1
                                ? 'rounded-r-md'
                                : '',
                        ]"
                    >
                    </a>
                </nav>
            </div>
        </div>
    </Page>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";
import Page from "../components/Page.vue";
import SurveyListItem from "../components/SurveyListItem.vue";

const store = useStore();
const surveys = computed(() => store.state.surveys);
store.dispatch("fetchSurveys");

function getForPage(link) {
    if (link.active || !link.url) {
        return;
    }
    store.dispatch("fetchSurveys", { url: link.url });
}

function deleteSurvey(survey) {
    if (confirm(`Are you sure you want to remove this survey`)) {
        store.dispatch("deleteSurvey", survey.id).then(() => {
            store.dispatch("fetchSurveys");
        });
    }
}
</script>
