<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap gap-1">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 text-gray-400 border rounded dark:border-gray-400 dark:text-white"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :key="`link-${key}`"
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 transition duration-200 ease-in border rounded dark:border-gray-400 focus:text-indigo-500 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-offset-indigo-200 focus:ring-2 focus:ring-offset-2 dark:text-white"
                    :class="{ 'bg-indigo-500 text-white': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
        <div class="text-sm dark:text-white">Total post: {{ total }}</div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    links: Array,
    total: Number,
});
</script>
