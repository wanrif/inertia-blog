<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap gap-1 px-1 sm:px-0">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 text-gray-400 bg-white border rounded shadow-lg dark:border-gray-400 dark:text-gray-400 dark:bg-gray-900"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :key="`link-${key}`"
                    class="px-4 py-3 mb-1 mr-1 text-sm leading-4 transition duration-200 ease-in border rounded shadow-lg dark:border-gray-400 focus:text-cyan-500 focus:border-cyan-500 focus:ring-cyan-500 focus:ring-offset-cyan-200 focus:ring-2 focus:ring-offset-2 dark:text-white bg-gray-50 dark:bg-gray-900"
                    :class="{
                        'bg-cyan-500 dark:bg-cyan-600 text-white': link.active,
                    }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
        <div class="text-sm dark:text-white">
            <span v-if="total">Total post:</span> {{ total }}
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    links: Array,
    total: Number,
});
</script>
