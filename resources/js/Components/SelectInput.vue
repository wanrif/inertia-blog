<script setup>
const props = defineProps({
    selected: {
        type: String,
    },
});
</script>

<template>
    <select
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
    >
        <slot />
    </select>
</template>
