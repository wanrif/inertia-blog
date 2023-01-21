<script setup>
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
</script>

<template>
    <MainLayout>
        <Head title="Home" />

        <header
            class="min-h-screen bg-white sm:bg-quill-gray-100 dark:bg-shark-900"
        >
            <div
                class="container flex flex-col px-6 py-4 mx-auto space-y-6 lg:h-[32rem] lg:py-16 lg:flex-row lg:items-center"
            >
                <div class="flex items-center w-full lg:flex-row lg:w-1/2">
                    <div class="max-w-lg lg:mx-12 lg:order-2">
                        <h1
                            class="text-3xl font-semibold tracking-wide border-b-8 text-sharbg-shark-900 dark:text-[#df4139] lg:text-4xl border-rose-600 dark:border-quill-gray-100 max-w-max flex flex-col sm:flex-row"
                        >
                            Hello,&nbsp;
                            <span class="text-accent-2">
                                I'm Redwan Syarif
                            </span>
                        </h1>
                        <p class="mt-4 text-gray-600 dark:text-quill-gray-100">
                            I am a graduate from Gunadarma University majoring
                            in Information Systems. I am a full-stack web
                            developer who enjoys building web applications using
                            Laravel and Vue.js. I also enjoy creating mobile
                            applications using Flutter.
                        </p>
                        <div class="mt-6">
                            <button
                                class="px-6 py-2.5 mt-6 text-sm font-medium leading-5 text-center bg-cyan-600 hover:bg-cyan-700 focus:ring-cyan-500 focus:ring-offset-cyan-200 text-white transition ease-in duration-200 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg"
                            >
                                Hire Me Now!
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-center w-full h-96 lg:w-1/2"
                >
                    <img
                        class="object-cover w-full h-full max-w-2xl rounded-md"
                        src="/storage/static/aric-athesis-05.jpg"
                        alt="aric-athesis-05"
                    />
                </div>
            </div>
        </header>
    </MainLayout>
</template>
