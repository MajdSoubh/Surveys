<template>
    <div>
        <div
            :class="[
                shouldReverse() ? 'flex-row items-center' : 'flex-col',
                ,
                'flex   gap-2',
            ]"
        >
            <label
                :for="id"
                :class="[
                    shouldReverse() ? 'order-2' : '',
                    'block font-medium text-base text-gray-900',
                ]"
            >
                {{ label }}
            </label>
            <input
                :id="id"
                :value="modelValue"
                :checked="modelValue"
                @change="dataChange"
                :type="type"
                :class="[
                    shouldReverse()
                        ? 'order-1 focus:ring-indigo-500 focus:ring-2 focus:border-none foucs:ring-offset-2 rounded-md shadow-sm border-gray-300'
                        : 'w-full focus:ring-indigo-500 focus:ring-2 focus:border-none foucs:ring-offset-2 rounded-md shadow-sm border-gray-300',
                ]"
            />
        </div>
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
const { label, type, modelValue, errors } = defineProps({
    label: String,
    id: String,
    type: String,
    modelValue: [Object, String, Boolean, Number],
    errors: [Array, String],
});

const emit = defineEmits(["update:modelValue"]);
function shouldReverse() {
    if (type === "radio" || type === "checkbox") {
        return true;
    }
    return false;
}

function dataChange(event) {
    if (type === "checkbox") {
        emit("update:modelValue", event.target.checked);
    } else {
        emit("update:modelValue", event.target.value);
    }
}
</script>
<style></style>
