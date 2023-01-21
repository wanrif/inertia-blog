<script setup>
import { debounce } from "lodash";
import { Head, Link, router } from "@inertiajs/vue3";
import { onMounted, onUnmounted, reactive, ref, watch } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import DeleteModal from "./Partials/DeleteModal.vue";
import DetailModal from "./Partials/DetailModal.vue";
import Pagination from "@/Components/DashboardPagination.vue";
import ToastNotification from "@/Components/ToastNotification.vue";
import TableButton from "@/Components/TableButton.vue";

const props = defineProps({
    users: Object,
    filters: Object,
});

/**
 * Search input value and watch for changes
 */
const form = reactive({
    search: props.filters.search,
});

watch(
    form,
    debounce((value) => {
        router.get(
            route("users.index"),
            { search: value.search },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500)
);

/**
 * Reset search input
 */
const reset = () => {
    form.search = "";
};

const isOpen = ref(false);

const openFilter = () => {
    isOpen.value = true;
};

const closeFilter = () => {
    isOpen.value = false;
};

const data = reactive({
    detail: null,
    delete: "",
});

const openDetailModal = (user) => {
    data.detail = user;
};

const closeDetailModal = () => {
    data.detail = null;
};

const openDeleteModal = (id) => {
    data.delete = id;
};

const closeDeleteModal = () => {
    data.delete = "";
};

const closeOnEscape = (e) => {
    if (e.key === "Escape" && isOpen.value) {
        closeFilter();
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
});
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <ToastNotification />

        <template #header>
            <Link
                :href="route('users.create')"
                class="text-xl font-bold leading-tight text-gray-800 cursor-pointer dark:text-gray-200"
            >
                Users
            </Link>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-900"
                >
                    <div
                        class="p-4 bg-white border-b border-gray-200 dark:border-b-0 dark:bg-gray-900"
                    >
                        <div
                            class="flex flex-col md:items-center md:justify-between gap-y-2 md:gap-y-0 md:flex-row"
                        >
                            <div class="flex items-center gap-2">
                                <div>
                                    <button
                                        @click="openFilter"
                                        class="flex items-center w-full px-3 py-2 text-sm border-gray-200 rounded-md shadow focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                    >
                                        Filter
                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center gap-1">
                                    <input
                                        v-model="form.search"
                                        type="text"
                                        class="block w-full px-3 py-2 text-sm border-gray-200 rounded-md shadow-sm md:w-72 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                        placeholder="Search by name or email..."
                                    />
                                    <button
                                        v-if="form.search"
                                        @click="reset()"
                                        type="button"
                                        class="p-1 transition ease-in bg-white rounded-lg dark:bg-gray-800 dark:hover:bg-gray-700"
                                    >
                                        <CloseIcon />
                                    </button>
                                </div>
                            </div>
                            <Link
                                :href="route('users.create')"
                                class="px-4 py-2 text-base font-semibold text-center text-white transition duration-200 ease-in bg-indigo-600 rounded-lg shadow-md w-52 hover:bg-teal-600 focus:ring-teal-500 focus:ring-offset-teal-200 dark:focus:ring-offset-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2"
                            >
                                Create User
                            </Link>
                        </div>

                        <!-- Table -->
                        <div class="flex flex-col mt-5">
                            <div class="overflow-x-auto">
                                <div
                                    class="inline-block min-w-full align-middle"
                                >
                                    <div
                                        class="overflow-hidden border rounded-lg dark:border-gray-700"
                                    >
                                        <table
                                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                                        >
                                            <thead
                                                class="bg-gray-50 dark:bg-gray-900/50"
                                            >
                                                <tr>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-200"
                                                    >
                                                        Name
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-200"
                                                    >
                                                        Email
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-200"
                                                    >
                                                        Role
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-200"
                                                    >
                                                        Created at
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-xs font-medium text-right text-gray-500 uppercase dark:text-gray-200"
                                                    >
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800"
                                            >
                                                <tr
                                                    v-if="users.total > 0"
                                                    v-for="user in users.data"
                                                    :key="user.id"
                                                >
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ user.name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ user.email }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ user.role }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ user.created_at }}
                                                    </td>
                                                    <td
                                                        class="flex items-center float-right px-6 py-4 space-x-2 text-sm font-medium text-right whitespace-nowrap"
                                                    >
                                                        <TableButton
                                                            @click="
                                                                openDetailModal(
                                                                    user
                                                                )
                                                            "
                                                            value="Detail"
                                                            typeButton="btnDetail"
                                                        />
                                                        <Link
                                                            :href="
                                                                route(
                                                                    'users.edit',
                                                                    user.id
                                                                )
                                                            "
                                                        >
                                                            <TableButton
                                                                value="Edit"
                                                                typeButton="btnEdit"
                                                            />
                                                        </Link>
                                                        <TableButton
                                                            @click="
                                                                openDeleteModal(
                                                                    user.id
                                                                )
                                                            "
                                                            value="Delete"
                                                            typeButton="btnDelete"
                                                        />
                                                    </td>
                                                </tr>
                                                <tr v-else>
                                                    <td
                                                        colspan="5"
                                                        class="py-4 text-sm text-center text-gray-500 dark:text-gray-200"
                                                    >
                                                        No users found
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <DetailModal
                            title="Detail User"
                            :content="data.detail"
                            @close="closeDetailModal"
                        />

                        <DeleteModal
                            title="Delete User"
                            body="Are you sure you want to delete this user?"
                            :userId="data.delete"
                            @close="closeDeleteModal"
                        />

                        <Pagination
                            class="mt-6"
                            :links="users.links"
                            :total="users.total"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

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
