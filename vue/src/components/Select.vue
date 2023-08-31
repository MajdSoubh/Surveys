<template>
    <div>
        <label
            :for="'question_type' + id"
            class="text-base block font-medium"
            >{{ label }}</label
        >
        <select
            :id="'question_type' + id"
            class="mt-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            :value="modelValue"
            @change="emit('update:modelValue', $event.target.value)"
        >
            <option v-for="(opt, ind) in options" :key="ind" :value="opt">
                {{ upperCaseFirst(opt) }}
            </option>
        </select>
        <div v-if="errors">
            <div v-for="(error, ind) in errors" :key="ind" class="ml-1 mt-2">
                <span class="text-red-500 text-sm block font-medium">
                    * {{ error }}
                </span>
            </div>
        </div>
    </div>
</template>
<script setup>
const { modelValue, options, label, id, errors } = defineProps({
    modelValue: [Object, String],
    options: Array,
    label: String,
    id: String,
    errors: [Array, String],
});

const emit = defineEmits(["update:modelValue"]);

// Transform first letter of a string to upper case
function upperCaseFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>
<style></style>
