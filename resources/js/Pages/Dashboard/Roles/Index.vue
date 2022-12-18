<script setup>
import { ref, watch } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { debounce } from "lodash";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import ToastNotification from "@/Components/ToastNotification.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import DetailModal from "@/Components/Role/DetailModal.vue";
import TableButton from "@/Components/TableButton.vue";
import DeleteModal from "@/Components/Role/DeleteModal.vue";

const props = defineProps({
    roles: Object,
    filters: Object,
    permissions: Object,
});

/**
 * Search input value and watch for changes
 */
let search = ref(props.filters.search);
watch(
    search,
    debounce((value) => {
        Inertia.get(
            route("roles.index"),
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
    detail: null,
    delete: null,
});

const detailModal = (role) => {
    data.value.detail = role;
};

const deleteModal = (role) => {
    data.value.delete = role;
};
</script>

<template>
    <Head title="Roles" />

    <AuthenticatedLayout>
        <ToastNotification />

        <template #header>
            <div
                class="text-xl font-bold leading-tight text-gray-800 cursor-default dark:text-gray-200"
            >
                Roles
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div
                        class="p-4 bg-white border-b border-gray-200 dark:border-b-0 dark:bg-gray-800"
                    >
                        <div
                            class="flex flex-col md:items-center md:justify-between gap-y-2 md:gap-y-0 md:flex-row"
                        >
                            <div class="flex items-center gap-1">
                                <input
                                    v-model="search"
                                    type="text"
                                    class="block w-full px-3 py-2 text-sm border-gray-200 rounded-md shadow-sm md:w-72 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                    placeholder="Search..."
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
                            <Link
                                :href="route('roles.create')"
                                class="px-4 py-2 text-base font-semibold text-center text-white transition duration-200 ease-in bg-indigo-600 rounded-lg shadow-md w-52 hover:bg-teal-600 focus:ring-teal-500 focus:ring-offset-teal-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                            >
                                Create Role
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
                                                        Role
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
                                                    v-if="roles.total !== 0"
                                                    v-for="role in roles.data"
                                                    :key="role.id"
                                                >
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium text-gray-800 capitalize whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ role.name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ role.created_at }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ role.updated_at }}
                                                    </td>
                                                    <td
                                                        class="flex items-center float-right px-6 py-4 space-x-2 text-sm font-medium text-right whitespace-nowrap"
                                                    >
                                                        <TableButton
                                                            @click="
                                                                detailModal(
                                                                    role
                                                                )
                                                            "
                                                            value="Detail"
                                                            typeButton="btnDetail"
                                                        />
                                                        <Link
                                                            :href="
                                                                route(
                                                                    'roles.edit',
                                                                    role.id
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
                                                                deleteModal(
                                                                    role.id
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
                                                        No Roles found
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <DetailModal
                            id="detail-modal"
                            title="Role Details"
                            :content="data.detail"
                            @close="data.detail = null"
                        />
                        <DeleteModal
                            title="Delete Role"
                            body="Are you sure you want to delete this role?"
                            :roleId="data.delete"
                            @close="data.delete = null"
                        />

                        <!-- Pagination -->
                        <Pagination
                            class="mt-6"
                            :links="roles.links"
                            :total="roles.total"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
