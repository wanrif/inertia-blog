<script setup>
import { ref, watchEffect } from "vue";
import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    content: Object,
});

const isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;
    emit("close");
};

const emit = defineEmits(["close"]);

watchEffect(() => {
    if (props.content) {
        isModalOpen.value = true;
    }
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
        <transition name="bounce">
            <div
                @click.self="closeModal"
                v-if="isModalOpen"
                class="fixed inset-0 z-20 flex justify-center"
            >
                <div
                    class="p-4 m-auto bg-gray-100 shadow-lg dark:text-gray-200 rounded-2xl dark:bg-gray-800 max-w-[50rem] max-h-[40rem] sm:max-h-fit overflow-y-auto"
                >
                    <div
                        class="flex items-center justify-between mb-2 space-x-2"
                    >
                        <div
                            class="text-2xl italic font-bold uppercase border-b-4 border-indigo-600"
                            style="letter-spacing: 1rem"
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
                        class="grid grid-flow-row-dense grid-cols-1 gap-4 sm:grid-cols-3"
                    >
                        <div class="block">
                            <img
                                src="https://source.unsplash.com/400x400?cat"
                                alt="user profile"
                                class="object-cover w-full h-64 rounded-lg"
                            />
                        </div>
                        <div class="flex flex-col gap-1">
                            <div>
                                <div
                                    class="text-sm italic text-gray-500 border-b-4 max-w-max border-b-indigo-500"
                                >
                                    Name:
                                </div>
                                <div class="text-gray-800 dark:text-gray-300">
                                    {{ props.content.name }}
                                </div>
                            </div>
                            <div>
                                <div
                                    class="text-sm italic text-gray-500 border-b-4 max-w-max border-b-indigo-500"
                                >
                                    Email:
                                </div>
                                <div class="text-gray-800 dark:text-gray-300">
                                    {{ props.content.email }}
                                </div>
                            </div>
                            <div>
                                <div
                                    class="text-sm italic text-gray-500 border-b-4 max-w-max border-b-indigo-500"
                                >
                                    Posts:
                                </div>
                                <div
                                    class="text-gray-800 capitalize dark:text-gray-300"
                                >
                                    {{ props.content.posts_count }} post
                                </div>
                            </div>
                            <div>
                                <div
                                    class="text-sm italic text-gray-500 border-b-4 max-w-max border-b-indigo-500"
                                >
                                    Role:
                                </div>
                                <div
                                    class="text-gray-800 capitalize dark:text-gray-300"
                                >
                                    {{ props.content.role }}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <div>
                                <div
                                    class="text-sm italic text-gray-500 border-b-4 max-w-max border-b-indigo-500"
                                >
                                    Permissions:
                                </div>
                                <div class="text-gray-800 dark:text-gray-300">
                                    {{ props.content.permissions }}
                                </div>
                            </div>
                            <div>
                                <div
                                    class="text-sm italic text-gray-500 border-b-4 max-w-max border-b-indigo-500"
                                >
                                    Created At:
                                </div>
                                <div class="text-gray-800 dark:text-gray-300">
                                    {{ props.content.created_at }}
                                </div>
                            </div>
                            <div>
                                <div
                                    class="text-sm italic text-gray-500 border-b-4 max-w-max border-b-indigo-500"
                                >
                                    Updated At:
                                </div>
                                <div class="text-gray-800 dark:text-gray-300">
                                    {{ props.content.updated_at }}
                                </div>
                            </div>
                        </div>
                        <div class="absolute px-72">
                            <ApplicationLogo
                                class="hidden w-60 h-w-60 sm:block"
                                color="text-gray-600/20 dark:text-gray-300/10"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped></style>
