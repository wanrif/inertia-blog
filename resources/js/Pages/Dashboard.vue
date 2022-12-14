<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
// import { computed } from "vue";

// const username = computed(() => usePage().props.value.auth.user.name);
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
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div
                        class="p-6 bg-white border-b border-gray-200 dark:text-gray-200 dark:bg-gray-800 dark:border-b-0"
                    >
                        Welcome to Dashboard,
                        {{ $page.props.auth.user.username }}!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
