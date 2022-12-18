<script setup>
import { ref, watchEffect } from "vue";

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

const closeModal = () => {
    isModalOpen.value = false;
    emit("close");
};

const emit = defineEmits(["close"]);
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
                    <div
                        class="flex items-center justify-between mb-2 space-x-2"
                    >
                        <div>
                            <h3
                                class="text-2xl font-bold border-b-4 border-indigo-600"
                            >
                                {{ props.title }}
                            </h3>
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
                        <div
                            :class="
                                props.content.permissions.length > 0
                                    ? 'grid grid-flow-col grid-rows-2 gap-2'
                                    : ''
                            "
                        >
                            <div
                                class="text-sm"
                                v-if="props.content.permissions.length > 0"
                                v-for="(perm, key) in props.content.permissions"
                            >
                                <div>{{ key + 1 }}. {{ perm }}</div>
                            </div>
                            <div v-else class="text-sm">
                                Doesn't have permissions
                            </div>
                        </div>
                    </div>
                    <div class="text-sm">{{ props.content.created_at }}</div>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.bg-modal-enter-active {
    animation: fade-in 0.5s;
}
.bg-modal-leave-active {
    animation: fade-in 0.5s reverse;
}
@keyframes fade-in {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.modal-enter-active {
    animation: bounce-in 0.5s;
}
.modal-leave-active {
    animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}
</style>
