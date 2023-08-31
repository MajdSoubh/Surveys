<template>
    <Page>
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ route.params.id ? model.title : "Create a Survey" }}
                </h1>
                <button
                    v-if="route.params.id"
                    @click="deleteSurvey"
                    class="py-2 px-3 flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Delete Survey
                </button>
            </div>
        </template>
        <div v-if="surveyLoading" class="text-center">Loading...</div>
        <form v-else @submit.prevent="saveSurvey" class="animate-fade-in-down">
            <div class="shadow sm:rounded-md sm:overflow-hidden bg-white">
                <div class="px-4 py-5 space-y-6 sm:p-6">
                    <!-- Image -->
                    <div>
                        <label
                            for=""
                            class="block text-sm font-medium text-gray-900"
                            >Image</label
                        >
                        <div class="mt-2 flex items-center">
                            <img
                                v-if="model.image_url"
                                :src="model.image_url"
                                :alt="model.title"
                                class="w-64 h-48 object-cover"
                            />
                            <span
                                v-else
                                class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="w-8 h-8"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                            <button
                                type="button"
                                class="ml-4 relative bg-white py-2 px-3 rounded-md shadow text-sm text-gray-600 hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 font-medium border border-gray-200"
                            >
                                <input
                                    type="file"
                                    @change="onImageChoose"
                                    class="cursor-pointer absolute left-0 right-0 top-0 bottom-0 opacity-0"
                                />
                                Change
                            </button>
                        </div>
                    </div>
                    <!-- Title -->

                    <Input
                        v-model="model.title"
                        id="title"
                        type="text"
                        :label="'Title'"
                        :errors="errors['title']"
                    />

                    <!-- Description -->
                    <Textarea
                        id="description"
                        name="description"
                        label="Description"
                        v-model="model.description"
                        placeholder="Describe your survey"
                    />
                    <!-- Expire date -->

                    <Input
                        v-model="model.expire_date"
                        id="expire_date"
                        type="date"
                        :label="'Expire Date'"
                        :errors="errors['expire_date']"
                    />

                    <!-- Status -->

                    <Input
                        v-model="model.status"
                        id="status"
                        type="checkbox"
                        :label="'Active'"
                        :errors="errors['status']"
                    />
                </div>
                <div class="px-4 py-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold">Questions</h3>
                        <button
                            @click.prevent="addQuestion(0)"
                            class="flex items-center gap-2 py-2 px-3 bg-emerald-500 hover:bg-emerald-600 focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 rounded-md text-white font-medium"
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
                            Add Question
                        </button>
                    </div>
                    <div
                        class="text-gray-600 text-center"
                        v-if="!model.questions.length"
                    >
                        You don't have any questions created
                    </div>
                    <div
                        v-for="(question, index) in model.questions"
                        :key="question.id"
                    >
                        <QuestionEditor
                            :question="question"
                            :index="index"
                            @change="changeQuestion"
                            @addQuestion="addQuestion"
                            @deleteQuestion="deleteQuestion"
                            :errors="errors"
                        />
                    </div>
                </div>
                <div class="py-3 px-4 text-right bg-gray-50">
                    <button
                        type="submit"
                        class="py-2 px-4 bg-emerald-500 hover:bg-emerald-600 focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 rounded-md text-white font-medium"
                    >
                        Save
                    </button>
                </div>
            </div>
        </form>
    </Page>
</template>
<script setup>
import { ref, watch, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { v4 as uuidv4 } from "uuid";
import Page from "../components/Page.vue";
import QuestionEditor from "../components/editor/QuestionEditor.vue";
import Input from "../components/Input.vue";
import Textarea from "../components/Textarea.vue";
import store from "../store";

const route = useRoute();
const router = useRouter();
const surveyLoading = computed(() => store.state.currentSurvey.loading);
const model = ref({
    title: null,
    description: null,
    status: false,
    image: null,
    expire_date: new Date().toISOString().slice(0, 10),
    questions: [],
});
const errors = ref({});

// Watch to current survey data change and when it's happens we update local model value
watch(
    () => store.state.currentSurvey.data,
    (newValue, oldValue) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newValue)),
        };
    }
);

// fetch the survey if the route is update survey
if (route.params.id) {
    store.dispatch("fetchSurvey", route.params.id);
}

function onImageChoose(ev) {
    const file = ev.target.files[0];

    const reader = new FileReader();

    reader.onload = () => {
        // The field to send on backend and apply validations
        model.value.image = reader.result;

        // The field to display here
        model.value.image_url = reader.result;
    };
    reader.readAsDataURL(file);
}

function deleteSurvey() {
    if (confirm("Are you sure you want to delete this survey ?")) {
        store.dispatch("deleteSurvey", route.params.id).then((res) => {
            router.push({ name: "Surveys" });
        });
    }
}

function addQuestion(index) {
    const newQuestion = {
        id: uuidv4(),
        type: "text",
        question: "",
        description: null,
        data: { options: [] },
    };

    model.value.questions.splice(index, 0, newQuestion);
}

function deleteQuestion(question) {
    model.value.questions = model.value.questions.filter((q) => q !== question);
}
function changeQuestion(question) {
    model.value.questions = model.value.questions.map((q) => {
        if (q.id === question.id) {
            return question;
        }
        return q;
    });
}
function saveSurvey() {
    let action = "created";
    if (model.value.id) {
        action = "updated";
    }
    store
        .dispatch("saveSurvey", model.value)
        .then(({ data }) => {
            store.commit("notify", {
                type: "success",
                message: "Survey was successfully " + action,
            });
            router.push({
                name: "SurveyView",
                params: { id: data.data.id },
            });
        })
        .catch((err) => (errors.value = err.response.data.errors));
}
</script>
<style></style>
