<script setup>
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SubmitButton from "@/Components/SubmitButton.vue";
import ProcessingIcon from "@/Components/Icons/ProcessingIcon.vue";

const form = useForm({
    name: "",
});

const submit = () => {
    form.post(route("permissions.store"));
};
</script>

<template>
    <Head title="Create Permissions" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="text-xl font-bold leading-tight text-gray-800 cursor-default dark:text-gray-200"
            >
                <Link :href="route('roles.index')">Roles</Link>
                <span class="text-indigo-500"> / Create</span>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg"
                >
                    <div
                        class="p-6 bg-white border-b dark:border-b-0 dark:bg-gray-800"
                    >
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel
                                    for="name"
                                    value="Permission Name"
                                    class="text-base text-gray-700 dark:text-gray-200"
                                />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="block w-full mt-1 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-800"
                                    :class="'ring-red-500' +
                                        (form.errors.name ? ' ring-2' : '')
                                    "
                                    v-model="form.name"
                                    placeholder="Permission Name"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <SubmitButton
                                class="w-full mt-4"
                                :disabled="form.processing"
                                :class="
                                    form.processing
                                        ? 'flex items-center justify-center'
                                        : ''
                                "
                            >
                                <ProcessingIcon v-if="form.processing" />
                                {{
                                    form.processing
                                        ? "Processing..."
                                        : "Create Role"
                                }}
                            </SubmitButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
