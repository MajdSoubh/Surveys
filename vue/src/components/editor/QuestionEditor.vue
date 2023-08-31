<template>
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold">
            {{ index + 1 }}. {{ question.question }}
        </h3>
        <div class="flex items-center gap-2">
            <!-- Add new Question -->
            <button
                type="button"
                @click="addQuestion()"
                class="flex items-center text-xs py-1 px-2 rounded-md text-green-600 border border-transparent hover:border-green-600"
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
            </button>
            <!-- Delete Question -->
            <button
                type="button"
                @click="deleteQuestion()"
                class="rounded-md py-1 px-2 text-red-500 border border-transparent hover:border-red-500"
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
            </button>
        </div>
    </div>
    <!-- Question text -->
    <div class="grid gap-3 mt-2 grid-cols-9 md:grid-cols-12">
        <div class="col-span-9">
            <Input
                v-model="model.question"
                :id="'question_text' + model.id"
                type="text"
                label="Question Text"
                @change="dataChange"
                :errors="errors[`questions.${index}.question`]"
            />
        </div>
        <!-- Question type -->
        <div class="col-span-6 md:col-span-3">
            <Select
                label="Question Type"
                v-model="model.type"
                :options="questionTypes"
                id="select-type"
                :errors="errors[`questions.${index}.type`]"
            />
        </div>
    </div>
    <!-- Question description -->
    <div class="grid mt-2 grid-cols-9">
        <div class="col-span-9">
            <Textarea
                v-model="model.description"
                :id="'description_text' + model.id"
                label="Description"
                @change="dataChange"
                :errors="errors[`questions.${index}.description`]"
            />
        </div>
    </div>
    <!-- Question options -->
    <div v-if="shouldHaveOptions()">
        <div class="mt-3 flex justify-between">
            <h4 class="font-medium text-xl">Options</h4>
            <!-- Add new option -->
            <button
                type="button"
                @click="addOption"
                class="flex items-center text-xs py-1 px-2 rounded-md text-green-600 border border-transparent hover:border-green-600"
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
            </button>
        </div>
        <div class="text-start mt-1" v-if="!model.data.options.length">
            You don't have any options defined
        </div>
        <div
            class="flex mt-2 justify-between gap-2 items-center"
            v-for="(option, ind) in model.data.options"
        >
            {{ ind + 1 + ". " }}
            <input
                type="text"
                v-model="option.text"
                @change="dataChange"
                class="w-full grow border-gray-300 focus:border-indigo-500 shadow-sm rounded-md"
            />
            <!-- Delete Option -->
            <button
                type="button"
                @click="removeOption(option)"
                class="rounded-md h-100 py-1 px-2 text-red-500 border border-transparent hover:border-red-500"
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
            </button>
            <!-- No options -->
        </div>
    </div>

    <hr class="my-4" />
</template>
<script setup>
import { ref } from "vue";
import { computed } from "vue";
import { useStore } from "vuex";
import { v4 as uuidv4 } from "uuid";
import Input from "../Input.vue";
import Textarea from "../Textarea.vue";
import Select from "../Select.vue";
const store = useStore();
const { question, index, errors } = defineProps({
    question: Object,
    index: Number,
    errors: Object,
});

const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);
// Re-create the whole question data to avoid unintentional reference change
const model = ref(JSON.parse(JSON.stringify(question)));

// Get question types from vuex
const questionTypes = computed(() => store.state.questionTypes);

function shouldHaveOptions() {
    return ["select", "radio", "checkbox"].includes(model.value.type);
}
function getOptions() {
    return model.value.data.options;
}
function setOptions(options) {
    model.value.data.options = options;
}
// Add new option
function addOption() {
    setOptions([...getOptions(), { uuid: uuidv4(), text: "" }]);
    dataChange();
}

// Remove option
function removeOption(opt) {
    setOptions(getOptions().filter((op) => op !== opt));
    dataChange();
}
function typeChange() {
    if (shouldHaveOptions()) {
        setOptions(getOptions() || []);
    }
    dataChange();
}

// Add new Question
function addQuestion() {
    emit("addQuestion", index + 1);
}

// Delete a question
function deleteQuestion() {
    emit("deleteQuestion", question);
}

// Emit the data change
function dataChange() {
    const data = JSON.parse(JSON.stringify(model.value));
    if (!shouldHaveOptions()) {
        delete data.data.options;
    }
    emit("change", data);
}
</script>
<style></style>
