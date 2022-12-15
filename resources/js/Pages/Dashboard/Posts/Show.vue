<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="text-xl font-bold leading-tight text-gray-800 cursor-default dark:text-gray-200"
            >
                <Link :href="route('posts.index')">Posts</Link>
                <span class="text-indigo-500"> / Show</span>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <div
                        class="max-w-2xl overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800"
                    >
                        <img
                            v-if="post.image.includes('post-images')"
                            :src="`/storage/${post.image}`"
                            class="object-cover w-full"
                            alt="Post Image"
                        />
                        <img
                            v-else-if="post.image.includes('https')"
                            :src="post.image"
                            class="object-cover w-full h-64"
                            alt="Post Image"
                        />
                        <img
                            v-else
                            class="object-cover w-full"
                            src="https://source.unsplash.com/800x400?blog"
                            alt="Post Image"
                        />

                        <div class="p-6">
                            <div>
                                <span
                                    class="text-xs font-medium text-blue-600 uppercase dark:text-blue-400"
                                    >Product</span
                                >
                                <a
                                    href="#"
                                    class="block mt-2 text-2xl font-semibold text-gray-800 transition-colors duration-300 transform dark:text-white hover:text-gray-600 hover:underline max-w-max"
                                    tabindex="0"
                                    role="link"
                                >
                                    {{ post.title }}
                                </a>
                                <div
                                    class="mt-2 prose text-gray-600 prose-gray lg:prose-md dark:text-gray-200"
                                    v-html="post.body"
                                />
                            </div>

                            <div class="mt-4">
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        <img
                                            class="object-cover h-10 rounded-full"
                                            src="https://images.unsplash.com/photo-1586287011575-a23134f797f9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=48&q=60"
                                            alt="Avatar"
                                        />
                                        <a
                                            href="#"
                                            class="mx-2 font-semibold text-gray-700 dark:text-gray-200"
                                            tabindex="0"
                                            role="link"
                                            >{{ post.author }}</a
                                        >
                                    </div>
                                    <span
                                        class="mx-1 text-xs text-gray-600 dark:text-gray-300"
                                    >
                                        {{ post.created_at }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";

const post = usePage().props.value.post;
</script>

<style lang="scss" scoped></style>
