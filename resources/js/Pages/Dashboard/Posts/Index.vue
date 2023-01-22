<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, watch, onMounted, onUnmounted, reactive } from "vue";
import { truncate, debounce } from "lodash";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import DeleteModal from "./Partials/DeleteModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Pagination from "@/Components/DashboardPagination.vue";
import ToastNotification from "@/Components/ToastNotification.vue";
import TableButton from "@/Components/TableButton.vue";

const props = defineProps({
    posts: Object,
    filters: Object,
    categories: Object,
    authors: Object,
});

/**
 * Search input value and watch for changes
 */
const form = reactive({
    search: props.filters.search,
    category: props.filters.category,
    author: props.filters.author,
});

watch(
    form,
    debounce((value) => {
        router.get(
            route("dashboard.posts.index"),
            {
                search: value.search,
                category: value.category,
                author: value.author,
            },
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
    form.category = "";
    form.author = "";
};

const data = reactive({
    slugs: null,
});

const isOpen = ref(false);

const openModal = (slug) => {
    data.slugs = slug;
};

const closeModal = () => {
    data.slugs = null;
};

const openFilter = () => {
    isOpen.value = true;
};

const closeFilter = () => {
    isOpen.value = false;
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
    <Head title="Posts" />

    <AuthenticatedLayout>
        <ToastNotification />

        <template #header>
            <Link
                :href="route('dashboard.posts.index')"
                class="text-xl font-bold leading-tight text-gray-800 cursor-pointer dark:text-gray-200"
            >
                Posts
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
                                        class="flex items-center w-full px-3 py-2 text-sm border border-gray-200 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
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

                                    <div class="relative">
                                        <transition name="fade">
                                            <div
                                                @click.self="closeFilter"
                                                v-if="isOpen"
                                                class="fixed inset-0 z-10 bg-black bg-opacity-20 dark:bg-opacity-40"
                                            ></div>
                                        </transition>
                                        <transition name="fade">
                                            <div
                                                v-if="isOpen"
                                                class="fixed z-20 flex items-center justify-center mt-2"
                                            >
                                                <div
                                                    class="p-3 overflow-hidden bg-white rounded-lg shadow-xl dark:text-gray-200 dark:bg-gray-800"
                                                >
                                                    <div>
                                                        <InputLabel
                                                            value="Category"
                                                            class="mb-1 text-sm text-gray-700 dark:text-gray-200"
                                                        />
                                                        <select
                                                            v-model="
                                                                form.category
                                                            "
                                                            class="block w-full px-3 py-2 text-sm border-gray-300 rounded-md pr-9 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                                        >
                                                            <option
                                                                :value="null"
                                                                selected
                                                            />
                                                            <option
                                                                v-for="(
                                                                    category,
                                                                    key
                                                                ) in props.categories"
                                                                :key="key"
                                                                :value="
                                                                    category.name
                                                                "
                                                            >
                                                                {{
                                                                    category.name
                                                                }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <InputLabel
                                                            value="Author"
                                                            class="mb-1 text-sm text-gray-700 dark:text-gray-200"
                                                        />
                                                        <select
                                                            v-model="
                                                                form.author
                                                            "
                                                            class="block w-full px-3 py-2 text-sm border-gray-300 rounded-md pr-9 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                                        >
                                                            <option
                                                                value=""
                                                                selected
                                                            />
                                                            <option
                                                                v-for="(
                                                                    author, key
                                                                ) in props.authors"
                                                                :key="key"
                                                                :value="
                                                                    author.name
                                                                "
                                                            >
                                                                {{
                                                                    author.name
                                                                }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </transition>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <input
                                        v-model="form.search"
                                        type="text"
                                        class="block w-full px-3 py-2 text-sm border-gray-200 rounded-md shadow-sm md:w-72 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                        placeholder="Search by title, author, or category"
                                    />
                                    <button
                                        v-if="
                                            form.search ||
                                            form.category ||
                                            form.author
                                        "
                                        @click="reset()"
                                        type="button"
                                        class="p-1 transition ease-in bg-white rounded-lg dark:bg-gray-800 dark:hover:bg-gray-700"
                                    >
                                        <CloseIcon />
                                    </button>
                                </div>
                            </div>
                            <Link
                                :href="route('dashboard.posts.create')"
                                class="px-4 py-2 text-base font-semibold text-center text-white transition duration-200 ease-in bg-indigo-600 rounded-lg shadow-md w-52 hover:bg-teal-600 focus:ring-teal-500 focus:ring-offset-teal-200 dark:focus:ring-offset-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2"
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
                                                        Category
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
                                                    v-if="posts.total > 0"
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
                                                        {{ post.category }}
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
                                                        />
                                                    </td>
                                                </tr>
                                                <tr v-else>
                                                    <td
                                                        colspan="5"
                                                        class="py-4 text-sm text-center text-gray-500 dark:text-gray-200"
                                                    >
                                                        No posts found
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <DeleteModal
                            title="Delete Post"
                            body="Are you sure you want to delete this post?"
                            :slug="data.slugs"
                            @close="closeModal"
                        />

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

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}
.fade-enter-to,
.fade-leave {
    opacity: 1;
}
</style>
