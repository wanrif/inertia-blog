<script setup lang="ts">
export interface Props {
    size?: string;
}

const props = withDefaults(defineProps<Props>(), {
    size: "h-4 w-4",
});
</script>

<template>
    <svg
        :class="props.size"
        class="stroke-current"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_iconCarrier">
            <circle
                cx="9"
                cy="9"
                r="4"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
            ></circle>
            <path
                d="M16 19C16 15.6863 12.866 13 9 13C5.13401 13 2 15.6863 2 19"
                class="stroke-current"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
            ></path>
            <path
                d="M15 13C17.2091 13 19 11.2091 19 9C19 6.79086 17.2091 5 15 5C13.8053 5 12.7329 5.52375 12 6.35418"
                class="stroke-current"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
            ></path>
            <path
                d="M22 19C22 15.6863 18.866 13 15 13C14.1928 13 12.897 12.7069 12 11.7655"
                class="stroke-current"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
            ></path>
        </g>
    </svg>
</template>
