<script setup>
import { computed } from "vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const post = computed(() => usePage().props.post);
</script>

<template>
    <Head :title="'Post | ' + post.title" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="flex items-center gap-2 text-sm font-bold leading-tight text-gray-800 cursor-default sm:text-xl dark:text-gray-200"
            >
                <Link :href="route('dashboard.posts.index')">Posts</Link>
                <span class="text-gray-400">/</span>
                <span class="text-indigo-500">{{ post.title }}</span>
                <span class="text-gray-400">/</span>
                <span>Detail</span>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col justify-center">
                    <div
                        class="grid grid-cols-1 gap-6 p-6 overflow-hidden bg-white rounded-lg shadow-md sm:grid-cols-3 dark:bg-gray-800"
                    >
                        <img
                            v-if="post.image !== '' && post.image !== null"
                            :v-lazy="`/storage/${post.image}`"
                            class="object-cover w-full rounded-md"
                            loading="lazy"
                            alt="Post Image"
                        />
                        <img
                            v-else
                            v-lazy="'https://source.unsplash.com/400x400?blog'"
                            class="object-cover w-full h-[15rem] rounded-md"
                            loading="lazy"
                            alt="Post Image"
                        />

                        <div class="capitalize">
                            <div
                                class="italic text-gray-500 dark:text-gray-300"
                            >
                                Title
                            </div>
                            <h1
                                class="block text-gray-800 transition-colors duration-300 transform dark:text-white hover:text-gray-600 max-w-max"
                            >
                                {{ post.title }}
                            </h1>
                            <div class="mt-4">
                                <div
                                    class="italic text-gray-500 dark:text-gray-300"
                                >
                                    Slug
                                </div>
                                <h1
                                    class="block text-gray-800 normal-case transition-colors duration-300 transform dark:text-white hover:text-gray-600 max-w-max"
                                >
                                    {{ post.slug }}
                                </h1>
                            </div>
                            <div class="mt-4">
                                <div
                                    class="italic text-gray-500 dark:text-gray-300"
                                >
                                    category
                                </div>
                                <span
                                    class="text-indigo-600 dark:text-indigo-400"
                                >
                                    {{ post.category }}
                                </span>
                            </div>
                        </div>

                        <div class="capitalize">
                            <div
                                class="italic text-gray-500 dark:text-gray-300"
                            >
                                Author
                            </div>
                            <h1
                                class="block text-gray-800 transition-colors duration-300 transform dark:text-white hover:text-gray-600 max-w-max"
                            >
                                {{ post.author }}
                            </h1>
                            <div
                                class="mt-4 italic text-gray-500 dark:text-gray-300"
                            >
                                Created At
                            </div>
                            <div
                                class="block text-gray-800 transition-colors duration-300 transform dark:text-white hover:text-gray-600 max-w-max"
                            >
                                {{ post.created_at }} WIB
                            </div>
                            <div
                                class="mt-4 italic text-gray-500 dark:text-gray-300"
                            >
                                Updated At
                            </div>
                            <div
                                class="block text-gray-800 transition-colors duration-300 transform dark:text-white hover:text-gray-600 max-w-max"
                            >
                                {{ post.updated_at }} WIB
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-5 mt-5 bg-white rounded-lg shadow-md dark:border-gray-700 dark:bg-gray-800"
                    >
                        <div
                            class="mb-3 text-2xl font-semibold capitalize border-b-4 border-gray-800 dark:border-b-gray-200 dark:text-gray-300"
                        >
                            Content
                        </div>
                        <div class="flex justify-center mt-5">
                            <div
                                class="w-full prose prose-dark dark:prose-invert lg:prose-lg"
                                v-html="post.body"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
