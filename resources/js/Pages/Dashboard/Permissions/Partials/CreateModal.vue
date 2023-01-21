<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, watchEffect, onMounted, onUnmounted } from "vue";
import ProcessingIcon from "@/Components/Icons/ProcessingIcon.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SubmitButton from "@/Components/SubmitButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    isOpen: Boolean,
});

const form = useForm({
    name: "",
});

const isModalOpen = ref(false);

watchEffect(() => {
    if (props.isOpen) {
        isModalOpen.value = true;
    }
});

const emit = defineEmits(["close"]);

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
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
    form.post(route("permissions.store"), {
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
                    <div class="flex flex-col my-3">
                        <InputLabel
                            for="name"
                            value="Name"
                            class="text-base dark:text-gray-200"
                        />
                        <TextInput
                            id="name"
                            type="text"
                            class="block mt-1 w-80"
                            :class="'ring-red-500' +
                                (form.errors.name ? ' ring-2' : '')
                            "
                            v-model="form.name"
                            placeholder="name"
                            autofocus
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="flex item-center">
                        <SubmitButton
                            type="button"
                            :disabled="form.processing"
                            :class="
                                form.processing
                                    ? 'flex items-center justify-center'
                                    : ''
                            "
                            @click.prevent="submit"
                        >
                            <ProcessingIcon v-if="form.processing" />
                            {{
                                form.processing ? "Processing..." : props.title
                            }}
                        </SubmitButton>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
