<script setup>
import { onMounted, onUnmounted, reactive, ref, watch } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { truncate, debounce } from "lodash";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import Pagination from "@/Components/MainPagination.vue";
import TagIcon from "@/Components/Icons/TagIcon.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    posts: Object,
    categories: Object,
    authors: Object,
    filters: Object,
});

const form = reactive({
    search: props.filters.search,
    category: props.filters.category,
    author: props.filters.author,
});

watch(
    form,
    debounce((value) => {
        router.get(
            route("blog.index"),
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
    }, 500),
    { deep: true }
);

const isOpen = ref(false);

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

/**
 * Reset search & category filters
 */
const reset = () => {
    form.search = "";
};

/**
 * Reset all filters
 */
const resetFilter = () => {
    form.category = "";
    form.author = "";
};
</script>

<template>
    <Head title="Home" />

    <MainLayout>
        <div
            class="container min-h-screen px-0 sm:mx-auto sm:px-7 dark:text-gray-100"
        >
            <div class="flex flex-col sm:gap-2 sm:flex-row item-center">
                <div class="relative w-full px-3 mb-5 sm:px-0 sm:max-w-sm">
                    <input
                        v-model="form.search"
                        type="text"
                        class="block w-full px-5 py-3 text-sm border-gray-300 rounded-full focus:border-cyan-500 focus:ring-cyan-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                        placeholder="Search by title, author, or category..."
                    />
                    <svg
                        v-if="!form.search"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="absolute w-6 h-6 right-6 bottom-2.5 sm:right-3 fill-cyan-500"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <div
                        v-if="form.search"
                        @click="reset()"
                        class="absolute p-1 rounded-full cursor-pointer bg-slate-200 dark:bg-slate-700 right-6 bottom-2.5 sm:right-3"
                    >
                        <CloseIcon class="w-6 h-6 fill-cyan-500" />
                    </div>
                </div>
                <div class="px-3 sm:px-0">
                    <div class="flex gap-2">
                        <button
                            @click="openFilter"
                            class="flex items-center w-full gap-1 p-3 mb-5 bg-white border border-gray-300 rounded-full sm:text-sm focus:border-cyan-500 focus:ring-cyan-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 max-w-max sm:max-w-max"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-4 h-4"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M3.792 2.938A49.069 49.069 0 0112 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 011.541 1.836v1.044a3 3 0 01-.879 2.121l-6.182 6.182a1.5 1.5 0 00-.439 1.061v2.927a3 3 0 01-1.658 2.684l-1.757.878A.75.75 0 019.75 21v-5.818a1.5 1.5 0 00-.44-1.06L3.13 7.938a3 3 0 01-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Filter
                        </button>
                        <button
                            v-if="form.category || form.author"
                            @click="resetFilter()"
                            class="flex items-center w-full gap-1 p-3 mb-5 bg-white border border-gray-300 rounded-full sm:text-sm focus:border-cyan-500 focus:ring-cyan-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 max-w-max sm:max-w-max"
                        >
                            reset
                        </button>
                    </div>

                    <div class="relative">
                        <transition name="fade">
                            <div
                                @click.self="closeFilter"
                                v-if="isOpen"
                                class="fixed inset-0 z-10 bg-gray-800 bg-opacity-50 sm:bg-opacity-50 sm:bg-black dark:bg-opacity-50 backdrop-blur-sm sm:backdrop-blur-none"
                            ></div>
                        </transition>
                        <transition name="fade">
                            <div
                                v-if="isOpen"
                                class="fixed z-20 flex items-center justify-center"
                            >
                                <div
                                    class="flex gap-3 p-3 overflow-hidden bg-white rounded-lg shadow-xl dark:text-gray-200 dark:bg-gray-800"
                                >
                                    <div>
                                        <InputLabel
                                            value="Category"
                                            class="mb-1 text-sm text-gray-700 dark:text-gray-200"
                                        />
                                        <select
                                            v-model="form.category"
                                            class="block w-full px-3 py-2 text-sm border-gray-300 rounded-md pr-9 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                        >
                                            <option :value="null" selected />
                                            <option
                                                v-for="(
                                                    category, key
                                                ) in props.categories"
                                                :key="key"
                                                :value="category"
                                            >
                                                {{ category }}
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <InputLabel
                                            value="Author"
                                            class="mb-1 text-sm text-gray-700 dark:text-gray-200"
                                        />
                                        <select
                                            v-model="form.author"
                                            class="block w-full px-3 py-2 text-sm border-gray-300 rounded-md pr-9 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                        >
                                            <option value="" selected />
                                            <option
                                                v-for="(
                                                    author, key
                                                ) in props.authors"
                                                :key="key"
                                                :value="author"
                                            >
                                                {{ author }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>

            <div
                v-if="posts.data.length > 0"
                class="grid gap-x-2 gap-y-6 xl:grid-cols-2"
            >
                <div
                    v-for="post in posts.data"
                    :key="post.id"
                    class="p-4 items-center justify-center sm:w-[680px] rounded-xl group sm:flex space-x-6 bg-gray-50 dark:bg-gray-800 bg-opacity-50 shadow-xl hover:rounded-2xl"
                >
                    <img
                        class="block object-cover w-full h-40 mx-auto rounded-lg sm:w-4/12"
                        alt="art cover"
                        loading="lazy"
                        v-lazy="'https://picsum.photos/seed/2/2000/1000'"
                    />
                    <div class="p-5 pl-0 sm:w-8/12">
                        <div class="space-y-2">
                            <Link
                                :href="route('blog.show', post.slug)"
                                class=""
                            >
                                <h4
                                    class="font-semibold text-justify text-md text-cyan-900 dark:text-cyan-500"
                                >
                                    {{ post.title }}
                                </h4>
                                <p
                                    class="text-sm prose text-justify prose-gray dark:prose-invert"
                                    v-html="
                                        truncate(post.body, {
                                            length: 100,
                                            separator: /,? +/,
                                        })
                                    "
                                />
                            </Link>
                            <div>
                                <div class="flex gap-3 space-y-1">
                                    <img
                                        v-lazy="
                                            'https://flowbite.com/docs/images/people/profile-picture-1.jpg'
                                        "
                                        loading="lazy"
                                        class="w-8 h-8 rounded-full"
                                    />
                                    <span class="text-sm">
                                        {{ post.author }} 🔥
                                    </span>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-between space-x-4"
                            >
                                <div
                                    class="flex flex-row my-1 space-x-1 text-grey-500"
                                >
                                    <svg
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-width="0"
                                        viewBox="0 0 24 24"
                                        height="1em"
                                        width="1em"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                    <p class="text-xs">{{ post.created_at }}</p>
                                </div>
                                <div class="block">
                                    <div
                                        class="flex items-center justify-center px-3 py-1 space-x-2 text-center text-white shadow-lg cursor-pointer bg-cyan-500 shadow- shadow-cyan-600 rounded-xl"
                                    >
                                        <TagIcon />
                                        <span>{{ post.category }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-if="posts.data.length === 0"
                class="flex items-center justify-center w-full h-full gap-3"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-6 h-6 animate-bounce fill-cyan-500"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                        clip-rule="evenodd"
                    />
                </svg>

                <h1 class="text-2xl font-semibold text-center animate-bounce">
                    No posts found
                </h1>
            </div>
            <Pagination class="mt-12" :links="posts.links" />
        </div>
    </MainLayout>
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
