<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SubmitButton from "@/Components/SubmitButton.vue";
import ProcessingIcon from "@/Components/Icons/ProcessingIcon.vue";

const props = defineProps({
    permissions: {
        type: [Array, Boolean],
        default: false,
    },
});

const form = useForm({
    name: "",
    permissions: [],
});

const submit = () => {
    form.post(route("roles.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create Role" />

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
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <!-- NAME -->
                                <div class="w-full col-span-2 mb-3">
                                    <InputLabel
                                        for="name"
                                        value="Role Name"
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
                                        placeholder="Role Name"
                                        autofocus
                                        required
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
                                    />
                                </div>
                                <div
                                    v-if="permissions.length > 0"
                                    class="w-full col-span-2 mb-3"
                                >
                                    <div class="grid grid-cols-4 gap-3">
                                        <div
                                            v-for="permission in permissions"
                                            :key="permission.id"
                                            class="flex items-center w-full col-span-1"
                                        >
                                            <div class="flex items-center">
                                                <input
                                                    v-model="form.permissions"
                                                    :id="
                                                        'checked-checkbox-' +
                                                        permission.id
                                                    "
                                                    type="checkbox"
                                                    :value="permission.id"
                                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                />
                                                <label
                                                    :for="
                                                        'checked-checkbox-' +
                                                        permission.id
                                                    "
                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >{{ permission.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
