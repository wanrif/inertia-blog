<script setup>
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import { truncate, debounce } from "lodash";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import DeleteModal from "@/Components/Post/DeleteModal.vue";
import ToastNotification from "@/Components/ToastNotification.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import TableButton from "@/Components/TableButton.vue";

// TODO: Create edit post

const props = defineProps({
    posts: Object,
    filters: Object,
});

/**
 * Search input value and watch for changes
 */
let search = ref(props.filters.search);

watch(
    search,
    debounce((value) => {
        Inertia.get(
            route("dashboard.posts.index"),
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
    search.value = null;
};

/**
 * Delete post
 * @param {string} slug
 */
const data = ref({
    slugs: null,
});

function openModal(slug) {
    data.value.slugs = slug;
}

const closeModal = () => {
    data.value.slugs = null;
};
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <ToastNotification />

        <template #header>
            <div
                class="text-xl font-bold leading-tight text-gray-800 cursor-default dark:text-gray-200"
            >
                Posts
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
                                :href="route('dashboard.posts.create')"
                                class="px-4 py-2 text-base font-semibold text-center text-white transition duration-200 ease-in bg-indigo-600 rounded-lg shadow-md w-52 hover:bg-teal-600 focus:ring-teal-500 focus:ring-offset-teal-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                            >
                                Create Post
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
                                                        Title
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-200"
                                                    >
                                                        Author
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
                                                    v-if="posts.data.length > 0"
                                                    v-for="post in posts.data"
                                                    :key="post.id"
                                                >
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{
                                                            truncate(post.title)
                                                        }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ post.author }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200"
                                                    >
                                                        {{ post.created_at }}
                                                    </td>
                                                    <td
                                                        class="flex items-center float-right px-6 py-4 space-x-2 text-sm font-medium text-right whitespace-nowrap"
                                                    >
                                                        <Link
                                                            :href="
                                                                route(
                                                                    'dashboard.posts.show',
                                                                    post
                                                                )
                                                            "
                                                        >
                                                            <TableButton
                                                                value="Detail"
                                                                typeButton="btnDetail"
                                                            />
                                                        </Link>
                                                        <Link
                                                            :href="
                                                                route(
                                                                    'dashboard.posts.edit',
                                                                    post
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
                                                                openModal(
                                                                    post.slug
                                                                )
                                                            "
                                                            type="button"
                                                            value="Delete"
                                                            typeButton="btnDelete"
                                                            data-hs-overlay="#delete-modal"
                                                        />
                                                    </td>
                                                </tr>
                                                <tr v-else>
                                                    <td
                                                        colspan="4"
                                                        class="py-4 text-sm text-center text-gray-500 dark:text-gray-200"
                                                    >
                                                        No posts found
                                                    </td>
                                                </tr>
                                                <DeleteModal
                                                    title="Delete Post"
                                                    body="Are you sure you want to delete this post?"
                                                    :slug="data.slugs || null"
                                                    @closeModal="closeModal"
                                                />
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Pagination
                            class="mt-6"
                            :links="posts.links"
                            :total="posts.total"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style></style>
