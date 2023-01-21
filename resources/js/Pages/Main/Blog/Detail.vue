<script setup>
import { computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

const post = computed(() => usePage().props.post);
</script>

<template>
    <Head :title="'Post | ' + post.title" />

    <MainLayout>
        <div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <div
                        class="overflow-hidden bg-white rounded-lg shadow-md max-w-fit dark:bg-gray-800"
                    >
                        <img
                            v-if="post.image !== '' && post.image !== null"
                            :v-lazy="`/storage/${post.image}`"
                            class="object-cover w-full"
                            alt="Post Image"
                        />
                        <img
                            v-else
                            class="object-cover w-full h-[23rem]"
                            v-lazy="'https://source.unsplash.com/800x400?blog'"
                            alt="Post Image"
                        />

                        <div class="p-6">
                            <div>
                                <span
                                    class="text-xs font-medium text-blue-600 uppercase dark:text-blue-400"
                                    >{{ post.category }}</span
                                >
                                <h1
                                    class="block mt-2 text-2xl font-semibold text-gray-800 dark:text-white hover:text-gray-600 hover:underline max-w-max"
                                >
                                    {{ post.title }}
                                </h1>
                                <div
                                    class="mt-2 prose prose-dark dark:prose-invert lg:prose-lg"
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
                                        {{ post.created_at }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
