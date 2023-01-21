<script setup>
import { computed } from "vue";
import { useColorMode, useCycleList } from "@vueuse/core";
import MoonIcon from "./Icons/MoonIcon.vue";
import SunIcon from "./Icons/SunIcon.vue";
import DesktopIcon from "./Icons/DesktopIcon.vue";

const props = defineProps({
    rounded: {
        type: String,
        default: "rounded-full",
    },
});

const isRounded = computed(() => {
    if (props.rounded === "square") {
        return "rounded-lg";
    } else {
        return "rounded-full";
    }
});

const mode = useColorMode({
    emitAuto: true,
});

const { next } = useCycleList(["dark", "light", "auto"], {
    initialValue: mode,
});
</script>

<template>
    <button
        @click="next()"
        class="px-1 py-1 transition duration-200 ease-in hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-cyan-200"
        :class="isRounded"
    >
        <MoonIcon v-if="mode === 'dark'" size="h-5 w-5" />
        <SunIcon v-if="mode === 'light'" size="h-5 w-5" />
        <DesktopIcon v-if="mode === 'auto'" size="h-5 w-5" />
    </button>
</template>
