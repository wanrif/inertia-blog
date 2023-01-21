<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { reactive, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Multiselect from "@vueform/multiselect";
import DeleteModal from "./Partials/DeleteModal.vue";

const props = defineProps({
    user: {
        type: Object,
    },
    allRoles: {
        type: Array,
    },
    allPermissions: {
        type: Array,
    },
});

const auth = usePage().props.auth.user;

const data = reactive({
    delete: "",
});

const openDeleteModal = (id) => {
    data.delete = id;
};

const closeDeleteModal = () => {
    data.delete = "";
};

onMounted(() => {
    if (auth.role != "super-admin") {
        document.getElementById("name").disabled = true;
        document.getElementById("email").disabled = true;
    }
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.userRole,
    permissions: props.user.userPermissions,
});

const options = reactive([
    ...props.allRoles.map((role) => ({
        label: role.name,
        value: role.name,
        disabled:
            auth.role != "super-admin" && role.name == "super-admin"
                ? true
                : false,
    })),
]);

const updateUser = () => {
    form.patch(route("users.update", props.user.id), {
        preserveState: true,
    });
};
</script>

<template>
    <Head :title="'Edit ' + user.name" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="text-xl font-bold leading-tight text-gray-800 cursor-default dark:text-gray-200"
            >
                <Link :href="route('users.index')">User / </Link>
                <span class="text-indigo-500">{{ props.user.name }}</span>
                <span> / Edit</span>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div
                        class="p-6 bg-white border-b dark:border-b-0 dark:bg-gray-800"
                    >
                        <!-- DELETE BUTTON -->
                        <div class="flex mb-4 sm:justify-end">
                            <button
                                @click="openDeleteModal(props.user.id)"
                                type="button"
                                class="px-4 py-2 text-sm font-medium text-white transition duration-200 ease-in bg-rose-500 border border-transparent rounded-md dark:bg-rose-600 hover:bg-rose-700 dark:hover:bg-rose-600 focus:ring-rose-500 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 min-w-[10rem]"
                            >
                                Delete
                            </button>
                        </div>

                        <DeleteModal
                            title="Delete User"
                            body="Are you sure you want to delete this user?"
                            :userId="data.delete"
                            @close="closeDeleteModal"
                        />

                        <form @submit.prevent="updateUser">
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <!-- Name -->
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
                                        class="block w-full mt-1 dark:text-gray-200 dark:bg-gray-700 dark:border-gray-800"
                                        :class="'ring-red-500' +
                                            (user.role !== 'super-admin'
                                                ? ' disabled:text-gray-500 dark:disabled:text-gray-400 dark:border-gray-800 disabled:bg-gray-200 disabled:cursor-not-allowed'
                                                : '') +
                                            (form.errors.name ? ' ring-2' : '')
                                        "
                                        v-model="form.name"
                                        placeholder="Name"
                                        required
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
                                    />
                                </div>

                                <!-- Email -->
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
                                        type="text"
                                        class="block w-full mt-1 dark:text-gray-200 dark:bg-gray-700"
                                        :class="'ring-red-500' +
                                            (user.role !== 'super-admin'
                                                ? ' disabled:text-gray-500 dark:disabled:text-gray-400 dark:border-gray-800 disabled:bg-gray-200 disabled:cursor-not-allowed'
                                                : '') +
                                            (form.errors.email ? ' ring-2' : '')
                                        "
                                        v-model="form.email"
                                        placeholder="Email"
                                        required
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.email"
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
                                        :object="true"
                                        :resolve-on-load="false"
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
                                            search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans dark:bg-gray-700 rounded pl-3.5  dark:text-gray-100',
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

                            <div
                                class="flex justify-center mt-4 sm:justify-end"
                            >
                                <button
                                    type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white transition duration-200 ease-in bg-indigo-500 border border-transparent rounded-md dark:bg-indigo-600 hover:bg-teal-500 dark:hover:bg-teal-600 focus:ring-teal-500 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 min-w-[10rem]"
                                >
                                    Update
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

<style>
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

.bounce-enter-active {
    animation: bounce-in 0.5s;
}
.bounce-leave-active {
    animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.12);
    }
    100% {
        transform: scale(1);
    }
}
</style>
