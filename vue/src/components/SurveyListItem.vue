<template>
    <div
        class="flex mx-2 my-2 flex-col py-5 px-5 rounded-sm bg-white shadow-md hover:bg-gray-50 h-[470px]"
    >
        <img
            :src="
                survey.image_url ||
                'https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg'
            "
            class="w-full h-48 object-cover rounded"
        />
        <h4 class="mt-4 text-lg font-bold">{{ survey.title }}</h4>
        <div v-html="survey.description" class="overflow-hidden flex-1"></div>
        <div class="flex justify-between gap-2 items-center">
            <div class="flex items-center gap-2 justify-between">
                <!-- Fill the survey -->
                <a
                    target="_blank"
                    :href="`/view/survey/${survey.slug}`"
                    class="text-emerald-500 text-xs w-9 h-9 flex justify-center items-center hover:text-white hover:bg-emerald-500 rounded-full ring-offset-4 focus:ring-2 focus:ring-emerald-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </a>
                <!-- View Answers -->
                <router-link
                    :to="{
                        name: 'SurveySubmissions',
                        params: { surveyId: survey.id },
                    }"
                    class="text-indigo-600 text-xs w-9 h-9 flex justify-center items-center hover:text-white hover:bg-indigo-500 rounded-full ring-offset-4 focus:ring-2 focus:ring-indigo-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                </router-link>
            </div>
            <div class="flex justify-between gap-2 items-center">
                <!-- Edit button -->
                <router-link
                    :to="{ name: 'SurveyView', params: { id: survey.id } }"
                    class="text-indigo-600 text-xs w-9 h-9 flex justify-center items-center hover:text-white hover:bg-indigo-500 rounded-full ring-offset-4 focus:ring-2 focus:ring-indigo-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                        />
                    </svg>
                </router-link>
                <!-- Delete button -->
                <button
                    @click="emit('delete', survey)"
                    class="text-red-600 text-xs w-9 h-9 flex justify-center items-center hover:text-white hover:bg-red-500 rounded-full ring-offset-4 focus:ring-2 focus:ring-red-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
const { survey } = defineProps({
    survey: Object,
});
const emit = defineEmits(["delete"]);
</script>
<style></style>
