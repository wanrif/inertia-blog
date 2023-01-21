<script setup>
import { ref, watchEffect, onMounted, onUnmounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import ProcessingIcon from "@/Components/Icons/ProcessingIcon.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    body: {
        type: String,
        required: true,
    },
    roleId: Number,
});

const form = useForm({
    roleId: "",
});

const isModalOpen = ref(false);

watchEffect(() => {
    if (props.roleId) {
        isModalOpen.value = true;
        form.roleId = props.roleId;
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

const submit = () => {
    form.delete(route("roles.destroy", props.roleId), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        },
    });
};
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
                    class="w-64 p-4 m-auto bg-white shadow-lg rounded-2xl dark:bg-gray-800"
                >
                    <div class="w-full h-full text-center">
                        <div class="flex flex-col justify-between h-full">
                            <TrashIcon size="h-12 w-14 m-auto text-rose-500" />
                            <p
                                class="mt-4 text-xl font-bold text-gray-800 dark:text-gray-200"
                            >
                                {{ props.title }}
                            </p>
                            <p
                                class="px-6 py-2 text-sm text-gray-600 dark:text-gray-400"
                            >
                                {{ props.body }}
                            </p>
                            <div
                                class="flex items-center justify-between w-full gap-4 mt-8"
                            >
                                <button
                                    @click="closeModal"
                                    type="button"
                                    class="w-full px-4 py-2 text-base font-semibold text-center transition-all bg-white border rounded-lg shadow-md dark:text-indigo-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-indigo-500"
                                >
                                    Cancel
                                </button>
                                <button
                                    :disabled="form.processing"
                                    :class="form.processing ? '' : ''"
                                    @click.prevent="submit"
                                    type="button"
                                    class="flex items-center justify-center w-full px-4 py-2 text-base font-semibold text-center text-gray-200 transition-all bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 focus:ring-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                >
                                    <ProcessingIcon
                                        classes="h-6 w-6"
                                        v-if="form.processing"
                                    />
                                    {{ form.processing ? "" : "Delete" }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
