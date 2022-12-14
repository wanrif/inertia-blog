<script setup>
import { onMounted } from "vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";

const props = defineProps({
    message: String,
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
        class="bg-white border rounded-md shadow-lg dark:bg-gray-800 dark:border-gray-700"
        role="alert"
    >
        <div class="flex items-center justify-between p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg
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
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        {{ props.message }}
                    </p>
                </div>
            </div>
            <button
                @click="emit('remove')"
                type="button"
                class="p-1 transition ease-in bg-white rounded-lg dark:bg-gray-800 dark:hover:bg-gray-700"
            >
                <CloseIcon />
            </button>
        </div>
    </div>
</template>
