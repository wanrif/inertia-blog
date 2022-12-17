<script setup>
import { ref, watchEffect } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import TrashIcon from "../Icons/TrashIcon.vue";

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

const deleteRole = (role) => {
    form.delete(route("roles.destroy", role));
    closeModal();
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
                                class="px-6 py-2 text-xs text-gray-600 dark:text-gray-400"
                            >
                                {{ props.body }}
                            </p>
                            <div
                                class="flex items-center justify-between w-full gap-4 mt-8"
                            >
                                <button
                                    @click="closeModal"
                                    type="button"
                                    class="w-full px-4 py-2 text-base font-semibold text-center text-white transition-all bg-white rounded-lg shadow-md dark:text-indigo-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-indigo-500"
                                >
                                    Cancel
                                </button>
                                <button
                                    @click.prevent="deleteRole(form.roleId)"
                                    type="button"
                                    class="w-full px-4 py-2 text-base font-semibold text-center text-gray-200 transition-all bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 focus:ring-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
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
