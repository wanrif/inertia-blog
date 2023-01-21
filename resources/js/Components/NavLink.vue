<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps(["href", "active"]);

const classes = computed(() =>
    props.active
        ? "inline-flex items-center text-base font-semibold leading-5 text-indigo-500 dark:text-indigo-100 focus:outline-none transition duration-150 ease-in-out"
        : "inline-flex items-center text-base font-semibold leading-5 text-gray-900 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 transition duration-150 ease-in-out"
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
