<script setup>
import { ref, watchEffect, onMounted, onUnmounted } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    content: {
        type: Object,
    },
});

const isModalOpen = ref(false);

watchEffect(() => {
    if (props.content) {
        isModalOpen.value = true;
    }
});

const emit = defineEmits(["close"]);

const closeModal = () => {
    isModalOpen.value = false;
    emit("close");
};

const closeOnEscape = (e) => {
    if (e.key === "Escape" && isModalOpen.value) {
        closeModal();
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
});
</script>

<template>
    <div class="relative">
        <transition name="bg-modal">
            <div
                v-if="isModalOpen"
                class="fixed inset-0 z-10 bg-black bg-opacity-50"
            ></div>
        </transition>
        <transition name="modal">
            <div
                v-if="isModalOpen"
                class="fixed inset-0 z-20 flex items-center justify-center"
            >
                <div
                    class="p-8 overflow-hidden bg-white rounded-lg shadow-xl dark:text-gray-200 dark:bg-gray-800"
                >
                    <div class="flex items-center justify-between mb-2">
                        <div
                            class="text-xl font-bold border-b-4 border-indigo-600"
                        >
                            {{ props.title }}
                        </div>
                        <button
                            @click="closeModal"
                            class="p-2 text-gray-700 transition duration-150 ease-in-out rounded-full hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700"
                        >
                            Close
                        </button>
                    </div>
                    <div
                        class="text-center text-gray-100 bg-indigo-600 rounded"
                    >
                        {{ props.content.name }}
                    </div>
                    <div class="flex flex-col my-3">
                        <div>Role permissions:</div>
                        <div>
                            <ul
                                class="ml-4 text-sm list-disc"
                                v-if="props.content.permissions.length > 0"
                                v-for="perm in props.content.permissions"
                            >
                                <li>
                                    {{ perm }}
                                </li>
                            </ul>
                            <div v-else class="text-sm">
                                Doesn't have permissions
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-between gap-2 sm:flex-row item-center"
                    >
                        <div class="text-sm">
                            <div class="text-xs text-gray-600">Created At:</div>
                            {{ props.content.created_at }}
                        </div>
                        <div class="text-sm">
                            <div class="text-xs text-gray-600">Updated AT:</div>
                            {{ props.content.updated_at }}
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
