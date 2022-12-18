<script setup>
import { onMounted } from "vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";

const props = defineProps({
    message: String,
    type: String,
    duration: {
        type: Number,
        default: 2000,
    },
});

onMounted(() => {
    setTimeout(() => {
        emit("remove");
    }, props.duration);
});

const emit = defineEmits(["remove"]);
</script>

<template>
    <div
        :class="{
            'dark:bg-rose-700/25 border-rose-500 dark:border-rose-700':
                props.type === 'error',
            'dark:bg-green-700/25 border-green-500 dark:border-green-700':
                props.type === 'success',
        }"
        class="bg-white border-2 rounded-md shadow-lg"
        role="alert"
    >
        <div class="flex items-center justify-between p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg
                        v-if="props.type === 'success'"
                        class="h-4 w-4 text-green-500 mt-0.5"
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"
                        />
                    </svg>
                    <svg
                        v-if="props.type === 'error'"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        class="w-5 h-5 border-2 rounded-full fill-rose-500 border-rose-500"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-700 dark:text-gray-200">
                        {{ props.message }}
                    </p>
                </div>
            </div>
            <button
                @click="emit('remove')"
                type="button"
                class="p-1 transition ease-in bg-white rounded-lg hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700"
            >
                <CloseIcon />
            </button>
        </div>
    </div>
</template>
