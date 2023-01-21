<script setup>
defineProps({
    type: {
        type: String,
        default: "submit",
    },
    bgColor: {
        type: String,
        default:
            "bg-gray-800 dark:bg-gray-900 hover:bg-gray-700 active:bg-gray-900 dark:hover:bg-gray-700",
    },
});
</script>

<template>
    <button
        :type="type"
        :class="bgColor"
        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out border border-transparent rounded-md focus:outline-none focus:border-gray-900 focus:shadow-outline-gray"
    >
        <slot />
    </button>
</template>
