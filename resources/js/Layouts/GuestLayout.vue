<script setup>
import { Link } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { useColorMode } from "@vueuse/core";
import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";

onMounted(() => {
    useColorMode({
        emitAuto: true,
    });
});
</script>

<template>
    <div
        class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 dark:bg-shark-900 bg-quill-gray-100"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-accent-2" />
            </Link>
        </div>

        <div
            class="w-full px-6 py-4 mt-6 overflow-hidden shadow-md bg-shark-900 dark:bg-shark-800 dark:bg-gradient-to-b dark:from-shark-800 dark:to-shark-900 sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
