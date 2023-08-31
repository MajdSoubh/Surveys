<template>
    <div class="flex-col flex gap-2">
        <label :for="id" class="block font-medium text-sm text-gray-900">
            {{ label }}
        </label>
        <textarea
            :id="id"
            rows="3"
            :placeholder="placeholder"
            :value="modelValue"
            @change="emit('update:modelValue', $event.target.value)"
            class="mt-2 w-full focus:ring-indigo-500 focus:ring-2 focus:border-none foucs:ring-offset-2 rounded-md shadow-sm border-gray-300"
        />
        <div v-if="errors">
            <div v-for="(error, ind) in errors" :key="ind" class="ml-1">
                <span class="mb-2 text-red-500 text-sm block font-medium">
                    * {{ error }}
                </span>
            </div>
        </div>
    </div>
</template>
<script setup>
const { label, placeholder, modelValue, errors } = defineProps({
    label: String,
    id: String,
    placeholder: String,
    modelValue: [String, Object, Boolean],
    errors: [Array, String],
});

const emit = defineEmits(["update:modelValue"]);
</script>
<style></style>
