<script setup>
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <MainLayout :canLogin="canLogin" :canRegister="canRegister">
        <Head title="About" />

        <div class="container px-12 mx-auto">
            <h1
                class="text-4xl font-bold text-center text-gray-800 capitalize dark:text-white"
            >
                About Me
            </h1>

            <section>
                <h2
                    class="text-2xl font-bold text-gray-800 capitalize dark:text-white"
                >
                    My name is Wanrif
                </h2>
                <p class="text-gray-600 capitalize dark:text-gray-300">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Quisquam, quae.
                </p>
            </section>
        </div>
    </MainLayout>
</template>
