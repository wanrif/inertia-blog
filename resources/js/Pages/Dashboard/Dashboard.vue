<script setup>
import CategoryIcon from "@/Components/Icons/CategoryIcon.vue";
import PermissionsIcon from "@/Components/Icons/PermissionsIcon.vue";
import PostsIcon from "@/Components/Icons/PostsIcon.vue";
import RolesIcon from "@/Components/Icons/RolesIcon.vue";
import UsersIcon from "@/Components/Icons/UsersIcon.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
// import { computed } from "vue";

// const username = computed(() => usePage().props.auth.user.name);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-xl dark:bg-gray-800"
                >
                    <div
                        class="p-6 bg-white border-b border-gray-200 dark:text-gray-200 dark:bg-gray-800 dark:border-b-0"
                    >
                        Welcome to Dashboard,
                        {{ $page.props.auth.user.name }}!
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-3 mt-5">
                    <div class="col-span-4 sm:col-span-1">
                        <div
                            class="overflow-hidden bg-white shadow-sm sm:rounded-xl dark:bg-gray-800"
                        >
                            <div
                                class="p-6 bg-white border-b border-gray-200 dark:text-gray-200 dark:bg-gray-800 dark:border-b-0"
                            >
                                <h2
                                    class="mb-3 text-xl font-semibold leading-tight tracking-wider text-gray-800 dark:text-gray-200"
                                >
                                    Posts
                                </h2>
                                <div class="flex items-center">
                                    <div class="p-2 bg-indigo-200 rounded-full">
                                        <PostsIcon
                                            class="w-8 h-8 fill-indigo-600"
                                        />
                                    </div>
                                    <div class="flex flex-col ml-2">
                                        <div class="text-xl font-semibold">
                                            0
                                        </div>
                                        <div
                                            class="text-sm font-bold text-indigo-600"
                                        >
                                            Total Posts
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-4 sm:col-span-1">
                        <div
                            class="overflow-hidden bg-white shadow-sm sm:rounded-xl dark:bg-gray-800"
                        >
                            <div
                                class="p-6 bg-white border-b border-gray-200 dark:text-gray-200 dark:bg-gray-800 dark:border-b-0"
                            >
                                <h2
                                    class="mb-3 text-xl font-semibold leading-tight tracking-wider text-gray-800 dark:text-gray-200"
                                >
                                    Category
                                </h2>
                                <div class="flex items-center">
                                    <div
                                        class="p-2 rounded-full bg-emerald-200"
                                    >
                                        <CategoryIcon
                                            class="w-8 h-8 fill-emerald-600"
                                        />
                                    </div>
                                    <div class="flex flex-col ml-2">
                                        <div class="text-xl font-semibold">
                                            0
                                        </div>
                                        <div
                                            class="text-sm font-bold text-emerald-600"
                                        >
                                            Total Category
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-4 sm:col-span-1">
                        <div
                            class="overflow-hidden bg-white shadow-sm sm:rounded-xl dark:bg-gray-800"
                        >
                            <div
                                class="p-6 bg-white border-b border-gray-200 dark:text-gray-200 dark:bg-gray-800 dark:border-b-0"
                            >
                                <h2
                                    class="mb-3 text-xl font-semibold leading-tight tracking-wider text-gray-800 dark:text-gray-200"
                                >
                                    Users
                                </h2>
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-amber-200">
                                        <UsersIcon
                                            class="w-8 h-8 text-amber-600"
                                        />
                                    </div>
                                    <div class="flex flex-col ml-2">
                                        <div class="text-xl font-semibold">
                                            0
                                        </div>
                                        <div
                                            class="text-sm font-bold text-amber-600"
                                        >
                                            Total Users
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-4 sm:col-span-1">
                        <div
                            class="overflow-hidden bg-white shadow-sm sm:rounded-xl dark:bg-gray-800"
                        >
                            <div
                                class="p-6 bg-white border-b border-gray-200 dark:text-gray-200 dark:bg-gray-800 dark:border-b-0"
                            >
                                <h2
                                    class="mb-3 text-xl font-semibold leading-tight tracking-wider text-gray-800 dark:text-gray-200"
                                >
                                    Roles
                                </h2>
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-rose-200">
                                        <RolesIcon
                                            class="w-8 h-8 fill-rose-600"
                                        />
                                    </div>
                                    <div class="flex flex-col ml-2">
                                        <div class="text-xl font-semibold">
                                            0
                                        </div>
                                        <div
                                            class="text-sm font-bold text-rose-600"
                                        >
                                            Total Roles
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-4 sm:col-span-1">
                        <div
                            class="overflow-hidden bg-white shadow-sm sm:rounded-xl dark:bg-gray-800"
                        >
                            <div
                                class="p-6 bg-white border-b border-gray-200 dark:text-gray-200 dark:bg-gray-800 dark:border-b-0"
                            >
                                <h2
                                    class="mb-3 text-xl font-semibold leading-tight tracking-wider text-gray-800 dark:text-gray-200"
                                >
                                    Permissions
                                </h2>
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-sky-200">
                                        <PermissionsIcon
                                            class="w-8 h-8 text-sky-600"
                                        />
                                    </div>
                                    <div class="flex flex-col ml-2">
                                        <div class="text-xl font-semibold">
                                            0
                                        </div>
                                        <div
                                            class="text-sm font-bold text-sky-600"
                                        >
                                            Total Permissions
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="relative w-full p-6 mt-5 overflow-hidden bg-white shadow-sm rounded-xl md:w-96 dark:bg-gray-800"
                >
                    <div class="flex items-center justify-between w-full mb-8">
                        <p
                            class="text-xl font-semibold tracking-wider text-gray-800 dark:text-white"
                        >
                            Activity
                        </p>
                        <a
                            href="#"
                            class="flex items-center text-sm text-gray-300 border-0 hover:text-gray-600 dark:text-gray-50 dark:hover:text-white focus:outline-none"
                        >
                            VIEW ALL
                        </a>
                    </div>
                    <div class="flex items-start justify-between mb-6 rounded">
                        <span
                            class="p-2 text-white bg-yellow-300 rounded-full dark:text-gray-800"
                        >
                            <svg
                                width="20"
                                height="20"
                                fill="currentColor"
                                viewBox="0 0 1792 1792"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M1596 380q28 28 48 76t20 88v1152q0 40-28 68t-68 28h-1344q-40 0-68-28t-28-68v-1600q0-40 28-68t68-28h896q40 0 88 20t76 48zm-444-244v376h376q-10-29-22-41l-313-313q-12-12-41-22zm384 1528v-1024h-416q-40 0-68-28t-28-68v-416h-768v1536h1280zm-128-448v320h-1024v-192l192-192 128 128 384-384zm-832-192q-80 0-136-56t-56-136 56-136 136-56 136 56 56 136-56 136-136 56z"
                                ></path>
                            </svg>
                        </span>
                        <div class="flex items-center justify-between w-full">
                            <div
                                class="flex flex-col items-start justify-between w-full ml-2 text-sm"
                            >
                                <p class="text-gray-700 dark:text-white">
                                    <span class="mr-1 font-bold"> Andrea </span>
                                    uploaded 3 documents on concept deisgn home
                                    page
                                </p>
                                <p class="text-gray-300">Aug 10</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start justify-between mb-6 rounded">
                        <span
                            class="p-2 text-white bg-green-400 rounded-full dark:text-gray-800"
                        >
                            <svg
                                width="20"
                                height="20"
                                fill="currentColor"
                                viewBox="0 0 1792 1792"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M1520 1216q0-40-28-68l-208-208q-28-28-68-28-42 0-72 32 3 3 19 18.5t21.5 21.5 15 19 13 25.5 3.5 27.5q0 40-28 68t-68 28q-15 0-27.5-3.5t-25.5-13-19-15-21.5-21.5-18.5-19q-33 31-33 73 0 40 28 68l206 207q27 27 68 27 40 0 68-26l147-146q28-28 28-67zm-703-705q0-40-28-68l-206-207q-28-28-68-28-39 0-68 27l-147 146q-28 28-28 67 0 40 28 68l208 208q27 27 68 27 42 0 72-31-3-3-19-18.5t-21.5-21.5-15-19-13-25.5-3.5-27.5q0-40 28-68t68-28q15 0 27.5 3.5t25.5 13 19 15 21.5 21.5 18.5 19q33-31 33-73zm895 705q0 120-85 203l-147 146q-83 83-203 83-121 0-204-85l-206-207q-83-83-83-203 0-123 88-209l-88-88q-86 88-208 88-120 0-204-84l-208-208q-84-84-84-204t85-203l147-146q83-83 203-83 121 0 204 85l206 207q83 83 83 203 0 123-88 209l88 88q86-88 208-88 120 0 204 84l208 208q84 84 84 204z"
                                ></path>
                            </svg>
                        </span>
                        <div class="flex items-center justify-between w-full">
                            <div
                                class="flex flex-col items-start justify-between w-full ml-2 text-sm"
                            >
                                <p class="text-gray-700 dark:text-white">
                                    <span class="mr-1 font-bold"> Karen </span>
                                    leave some comments on concept deisgn
                                    support page
                                </p>
                                <p class="text-gray-300">Aug 10</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start justify-between mb-6 rounded">
                        <span
                            class="p-2 text-white bg-indigo-400 rounded-full dark:text-gray-800"
                        >
                            <svg
                                width="20"
                                height="20"
                                fill="currentColor"
                                viewBox="0 0 1792 1792"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M1520 1216q0-40-28-68l-208-208q-28-28-68-28-42 0-72 32 3 3 19 18.5t21.5 21.5 15 19 13 25.5 3.5 27.5q0 40-28 68t-68 28q-15 0-27.5-3.5t-25.5-13-19-15-21.5-21.5-18.5-19q-33 31-33 73 0 40 28 68l206 207q27 27 68 27 40 0 68-26l147-146q28-28 28-67zm-703-705q0-40-28-68l-206-207q-28-28-68-28-39 0-68 27l-147 146q-28 28-28 67 0 40 28 68l208 208q27 27 68 27 42 0 72-31-3-3-19-18.5t-21.5-21.5-15-19-13-25.5-3.5-27.5q0-40 28-68t68-28q15 0 27.5 3.5t25.5 13 19 15 21.5 21.5 18.5 19q33-31 33-73zm895 705q0 120-85 203l-147 146q-83 83-203 83-121 0-204-85l-206-207q-83-83-83-203 0-123 88-209l-88-88q-86 88-208 88-120 0-204-84l-208-208q-84-84-84-204t85-203l147-146q83-83 203-83 121 0 204 85l206 207q83 83 83 203 0 123-88 209l88 88q86-88 208-88 120 0 204 84l208 208q84 84 84 204z"
                                ></path>
                            </svg>
                        </span>
                        <div class="flex items-center justify-between w-full">
                            <div
                                class="flex flex-col items-start justify-between w-full ml-2 text-sm"
                            >
                                <p class="text-gray-700 dark:text-white">
                                    <span class="mr-1 font-bold"> Karen </span>
                                    change project description to
                                    &quot;SubMarine protection project&quot;
                                </p>
                                <p class="text-gray-300">Aug 09</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start justify-between rounded">
                        <span
                            class="p-2 text-white bg-yellow-300 rounded-full dark:text-gray-800"
                        >
                            <svg
                                width="20"
                                height="20"
                                fill="currentColor"
                                viewBox="0 0 1792 1792"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M1596 380q28 28 48 76t20 88v1152q0 40-28 68t-68 28h-1344q-40 0-68-28t-28-68v-1600q0-40 28-68t68-28h896q40 0 88 20t76 48zm-444-244v376h376q-10-29-22-41l-313-313q-12-12-41-22zm384 1528v-1024h-416q-40 0-68-28t-28-68v-416h-768v1536h1280zm-128-448v320h-1024v-192l192-192 128 128 384-384zm-832-192q-80 0-136-56t-56-136 56-136 136-56 136 56 56 136-56 136-136 56z"
                                ></path>
                            </svg>
                        </span>
                        <div class="flex items-center justify-between w-full">
                            <div
                                class="flex flex-col items-start justify-between w-full ml-2 text-sm"
                            >
                                <p class="text-gray-700 dark:text-white">
                                    <span class="mr-1 font-bold"> John </span>
                                    uploaded 17 pictures on concept deisgn
                                    galery page
                                </p>
                                <p class="text-gray-300">Aug 1</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
