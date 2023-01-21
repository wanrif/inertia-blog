<script setup>
import { reactive, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PasswordIcon from "@/Components/Icons/PasswordIcon.vue";
import EyePasswordIcon from "@/Components/Icons/EyePasswordIcon.vue";
import EyePasswordHideIcon from "@/Components/Icons/EyePasswordHideIcon.vue";
import Multiselect from "@vueform/multiselect";

const props = defineProps({
    allRoles: {
        type: Array,
        required: true,
    },
    allPermissions: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
    permissions: [],
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const typePassword = () => {
    return showPassword.value ? "text" : "password";
};

const typeConfirmPassword = () => {
    return showConfirmPassword.value ? "text" : "password";
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
    typePassword();
};

const toggleConfirmPassword = () => {
    showConfirmPassword.value = !showConfirmPassword.value;
    typePassword();
};

const options = reactive([
    ...props.allRoles.map((role) => ({
        label: role.name,
        value: role.name,
    })),
]);

const submit = () => {
    form.post(route("users.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create User" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="text-xl font-bold leading-tight text-gray-800 cursor-default dark:text-gray-200"
            >
                <Link :href="route('users.index')">Users</Link>
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
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="name"
                                        value="Name"
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
                                        placeholder="Name"
                                        autofocus
                                        required
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
                                    />
                                </div>

                                <!-- EMAIL -->
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="email"
                                        value="Email"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="block w-full mt-1 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-800"
                                        :class="'ring-red-500' +
                                            (form.errors.email ? ' ring-2' : '')
                                        "
                                        v-model="form.email"
                                        placeholder="your@email.com"
                                        required
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.email"
                                    />
                                </div>

                                <!-- PASSWORD -->
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="password"
                                        value="Password"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <div class="relative">
                                        <input
                                            id="password"
                                            :type="typePassword()"
                                            class="block w-full px-4 py-2 text-sm border border-transparent rounded-lg shadow-sm appearance-none border-slate-300 focus:outline-none pl-11 pr-11 focus:z-10 focus:border-transparent focus:ring-2 focus:ring-indigo-600 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400"
                                            placeholder="********"
                                            v-model="form.password"
                                            required
                                            autocomplete="current-password"
                                        />
                                        <div
                                            class="absolute inset-y-0 left-0 z-20 flex items-center pl-4 pointer-events-none"
                                        >
                                            <PasswordIcon
                                                class="text-gray-400"
                                            />
                                        </div>
                                        <div
                                            @click="togglePassword"
                                            class="absolute inset-y-0 right-0 z-20 flex items-center pr-4 cursor-pointer"
                                        >
                                            <EyePasswordIcon
                                                v-if="!showPassword"
                                                class="text-gray-400"
                                            />
                                            <EyePasswordHideIcon
                                                v-else
                                                class="text-gray-400"
                                            />
                                        </div>
                                    </div>
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.password"
                                    />
                                </div>

                                <!-- PASSWORD CONFIRMATION -->
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="password_confirmation"
                                        value="Confirm Password"
                                        class="text-quill-gray-100"
                                    />
                                    <div class="relative">
                                        <input
                                            id="password_confirmation"
                                            :type="typeConfirmPassword()"
                                            class="block w-full px-4 py-2 text-sm border border-transparent rounded-lg shadow-sm appearance-none border-slate-300 focus:outline-none pl-11 pr-11 focus:z-10 focus:border-transparent focus:ring-2 focus:ring-indigo-600 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400"
                                            placeholder="********"
                                            v-model="form.password_confirmation"
                                            required
                                            autocomplete="new-password"
                                        />
                                        <div
                                            class="absolute inset-y-0 left-0 z-20 flex items-center pl-4 pointer-events-none"
                                        >
                                            <PasswordIcon
                                                class="text-gray-400"
                                            />
                                        </div>
                                        <div
                                            @click="toggleConfirmPassword"
                                            class="absolute inset-y-0 right-0 z-20 flex items-center pr-4 cursor-pointer"
                                        >
                                            <EyePasswordIcon
                                                v-if="!showConfirmPassword"
                                                class="text-gray-400"
                                            />
                                            <EyePasswordHideIcon
                                                v-else
                                                class="text-gray-400"
                                            />
                                        </div>
                                    </div>
                                    <InputError
                                        class="mt-2"
                                        :message="
                                            form.errors.password_confirmation
                                        "
                                    />
                                </div>

                                <!-- ROLES -->
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="role"
                                        value="Role"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <Multiselect
                                        id="role"
                                        v-model="form.role"
                                        placeholder="Select Role"
                                        :close-on-select="true"
                                        :searchable="true"
                                        :options="[...options]"
                                        :classes="{
                                            container:
                                                'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 dark:border-gray-800 rounded-lg bg-white dark:bg-gray-800 text-base leading-snug outline-none dark:text-gray-200',
                                            containerOpen: 'rounded-b-none',
                                            containerOpenTop: 'rounded-t-none',
                                            containerActive:
                                                'ring ring-indigo-500 ring-opacity-30',
                                            singleLabel:
                                                'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                            singleLabelText:
                                                'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                            search: 'search w-full absolute inset-0 outline-none focus:ring-2 focus:ring-indigo-600 appearance-none box-border border-0 text-base font-sans dark:bg-gray-700 rounded pl-3.5  dark:text-gray-100',
                                            placeholder:
                                                'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400',
                                            caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none',
                                            caretOpen:
                                                'rotate-180 pointer-events-auto',
                                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                            clearIcon:
                                                'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                            inifite:
                                                'flex items-center justify-center w-full',
                                            inifiteSpinner:
                                                'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 animate-spin flex-shrink-0 flex-grow-0 m-3.5',
                                            dropdown:
                                                'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 dark:border-gray-800 dark:bg-gray-700 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                            dropdownTop:
                                                '-translate-y-full top-px bottom-auto rounded-b-none rounded-t',
                                            dropdownHidden: 'hidden',
                                            options:
                                                'flex flex-col p-0 m-0 list-none',
                                            optionsTop: '',
                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 dark:bg-gray-700',
                                            optionPointed:
                                                'text-gray-800 dark:text-gray-100 bg-gray-100 dark:bg-gray-800',
                                            optionSelected:
                                                'text-white dark:text-gray-300 bg-indigo-500 dark:bg-indigo-600',
                                            optionDisabled:
                                                'text-gray-300 dark:text-gray-500 cursor-not-allowed',
                                            optionSelectedPointed:
                                                'text-white bg-indigo-500 dark:bg-indigo-600 opacity-90',
                                            optionSelectedDisabled:
                                                'text-indigo-100 bg-indigo-500 bg-opacity-50 cursor-not-allowed',
                                            noOptions:
                                                'py-2 px-3 text-gray-600 bg-white text-left',
                                            noResults:
                                                'py-2 px-3 text-gray-600 bg-white text-left',
                                            spacer: 'h-9 py-px box-content',
                                        }"
                                        :class="'ring-red-500' +
                                            (form.errors.role ? ' ring-2' : '')
                                        "
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.role"
                                    />
                                </div>

                                <!-- Permissions -->
                                <div
                                    v-if="allPermissions.length > 0"
                                    class="w-full col-span-2 mb-3"
                                >
                                    <InputLabel
                                        for="permissions"
                                        value="Permissions"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <div class="grid gap-3 sm:grid-cols-4">
                                        <div
                                            v-for="(
                                                permission, index
                                            ) in allPermissions"
                                            :key="index"
                                            class="flex items-center w-full col-span-1"
                                        >
                                            <div class="flex items-center">
                                                <input
                                                    v-model="form.permissions"
                                                    :id="
                                                        'checked-checkbox-' +
                                                        index
                                                    "
                                                    type="checkbox"
                                                    :value="permission.name"
                                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                />
                                                <label
                                                    :for="
                                                        'checked-checkbox-' +
                                                        index
                                                    "
                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >{{ permission.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-4">
                                <button
                                    type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white transition duration-200 ease-in bg-indigo-500 border border-transparent rounded-md dark:bg-indigo-600 hover:bg-teal-500 dark:hover:bg-teal-600 focus:ring-teal-500 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 min-w-[10rem]"
                                >
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
