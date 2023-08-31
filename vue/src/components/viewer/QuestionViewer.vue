<template>
    <div class="my-7">
        <div class="mb-3">
            <h2 class="font-medium text-lg text-gray-900">
                {{ index + 1 }}. {{ question.question }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">{{ question.description }}</p>
        </div>
        <div>
            <div v-if="question.type === 'text'">
                <input
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 text-base"
                    :value="modelValue"
                    @change="emits('update:modelValue', $event.target.value)"
                    type="text"
                />
            </div>
            <div v-else-if="question.type === 'select'">
                <select
                    :value="modelValue"
                    @change="emits('update:modelValue', $event.target.value)"
                    class="border-gray-300 py-2 px-4 shadow-sm w-full rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">Please Select</option>
                    <option
                        v-for="(option, ind) in question.data.options"
                        :key="option.uuid"
                        :value="option.text"
                    >
                        {{ option.text }}
                    </option>
                </select>
            </div>
            <div v-else-if="question.type === 'checkbox'">
                <div v-for="(option, ind) in question.data.options">
                    <div class="flex items-center gap-4 mb-1">
                        <input
                            class="border-gray-300 focus:ring-indigo-500 rounded text-indigo-600"
                            :id="option.uuid"
                            v-model="model[option.text]"
                            @change="onCheckboxChange"
                            type="checkbox"
                        />
                        <label
                            :for="option.uuid"
                            class="text-sm text-gray-700 font-medium"
                            >{{ option.text }}</label
                        >
                    </div>
                </div>
            </div>
            <div v-else-if="question.type === 'radio'">
                <div v-for="(option, ind) in question.data.options">
                    <div class="flex items-center mb-1">
                        <input
                            :id="option.uuid"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                            :value="option.text"
                            @change="
                                emits('update:modelValue', $event.target.value)
                            "
                            type="radio"
                            :name="question.id"
                        />
                        <label
                            :for="option.uuid"
                            class="ml-4 block font-medium text-sm text-gray-700"
                            >{{ option.text }}</label
                        >
                    </div>
                </div>
            </div>
            <div v-else-if="question.type === 'textarea'">
                <textarea
                    :value="modelValue"
                    @input="emits('update:modelValue', $event.target.value)"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                ></textarea>
            </div>
        </div>
    </div>
    <hr class="bg-gray-400" />
</template>
<script setup>
import { ref } from "vue";
const { question, index, modelValue } = defineProps({
    modelValue: [String, Object],
    question: Object,
    index: Number,
});
const model = ref({});

const emits = defineEmits(["update:modelValue"]);

function onCheckboxChange($event) {
    const selectedOptions = [];
    for (let uuid in model.value) {
        if (model.value[uuid]) {
            selectedOptions.push(uuid);
        }
    }
    emits("update:modelValue", selectedOptions);
}
</script>
<style></style>
