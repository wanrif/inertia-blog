<script setup>
import { ref, watch } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/DashboardPagination.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import ToastNotification from "@/Components/ToastNotification.vue";
import TableButton from "@/Components/TableButton.vue";
import DetailModal from "./Partials/DetailModal.vue";
import EditModal from "./Partials/EditModal.vue";
import DeleteModal from "./Partials/DeleteModal.vue";
import CreateModal from "./Partials/CreateModal.vue";

const props = defineProps({
    permissions: Object,
    filters: Object,
});

/**
 * Search input value and watch for changes
 */
let search = ref(props.filters.search);
watch(
    search,
    debounce((value) => {
        router.get(
            route("permissions.index"),
            { search: value },
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
    search.value = "";
};

const data = ref({
    create: false,
    detail: null,
    edit: null,
    delete: null,
});

const openCreateModal = () => {
    data.value.create = true;
};

const openDetailModal = (permission) => {
    data.value.detail = permission;
};

const openEditModal = (permission) => {
    data.value.edit = permission;
};

const openDeleteModal = (permission) => {
    data.value.delete = permission;
};
</script>

<template>
    <Head title="Permissions" />

    <AuthenticatedLayout>
        <ToastNotification />

        <template #header>
            <Link
                :href="route('permissions.index')"
                class="text-xl font-bold leading-tight text-gray-800 cursor-pointer dark:text-gray-200"
            >
                Permissions
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
                            <div class="flex items-center gap-1">
                                <input
                                    v-model="search"
                                    type="text"
                                    class="block w-full px-3 py-2 text-sm border-gray-200 rounded-md shadow-sm md:w-72 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                    placeholder="Search Permission..."
                                />
                                <button
                                    v-if="search"
                                    @click="reset()"
                                    type="button"
                                    class="p-1 transition ease-in bg-white rounded-lg dark:bg-gray-800 dark:hover:bg-gray-700"
                                >
                                    <CloseIcon />
                                </button>
                            </div>
                            <button
                                @click="openCreateModal"
                                class="px-4 py-2 text-base font-semibold text-center text-white transition duration-200 ease-in bg-indigo-600 rounded-lg shadow-md w-52 hover:bg-teal-600 focus:ring-teal-500 focus:ring-offset-teal-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                            >
                                Create Permission
                            </button>
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
                                                        Permission
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-200"
                                                    >
                                                        Created AT
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-200"
                                                    >
                                                        Updated AT
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
                                                    v-if="
                                                        permissions.total !== 0
                                                    "
                                                    v-for="permission in permissions.data"
                                                    :key="permission.id"
                                                >
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium text-gray-800 capitalize whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ permission.name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{
                                                            permission.created_at
                                                        }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{
                                                            permission.updated_at
                                                        }}
                                                    </td>
                                                    <td
                                                        class="flex items-center float-right px-6 py-4 space-x-2 text-sm font-medium text-right whitespace-nowrap"
                                                    >
                                                        <TableButton
                                                            @click="
                                                                openDetailModal(
                                                                    permission
                                                                )
                                                            "
                                                            value="Detail"
                                                            typeButton="btnDetail"
                                                        />
                                                        <TableButton
                                                            @click="
                                                                openEditModal(
                                                                    permission
                                                                )
                                                            "
                                                            value="Edit"
                                                            typeButton="btnEdit"
                                                        />
                                                        <TableButton
                                                            @click="
                                                                openDeleteModal(
                                                                    permission
                                                                )
                                                            "
                                                            value="Delete"
                                                            typeButton="btnDelete"
                                                        />
                                                    </td>
                                                </tr>
                                                <tr v-else>
                                                    <td
                                                        colspan="4"
                                                        class="py-4 text-sm text-center text-gray-500 dark:text-gray-200"
                                                    >
                                                        No permissions found
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <CreateModal
                            title="Create Permission"
                            :isOpen="data.create"
                            @close="data.create = false"
                        />

                        <DetailModal
                            title="Detail Permission"
                            :content="data.detail"
                            @close="data.detail = null"
                        />

                        <EditModal
                            title="Edit Permission"
                            :content="data.edit"
                            @close="data.edit = null"
                        />

                        <DeleteModal
                            title="Delete Permission"
                            body="Are you sure you want to delete this permission?"
                            :content="data.delete"
                            @close="data.delete = null"
                        />

                        <!-- Pagination -->
                        <Pagination
                            class="mt-6"
                            :links="permissions.links"
                            :total="permissions.total"
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
        transform: scale(1.12);
    }
    100% {
        transform: scale(1);
    }
}
</style>
