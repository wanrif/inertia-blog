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
        viewBox="0 0 48 48"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_iconCarrier">
            <path
                d="M20 10H6C4.89543 10 4 10.8954 4 12V38C4 39.1046 4.89543 40 6 40H42C43.1046 40 44 39.1046 44 38V29.5"
                class="stroke-current"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="round"
            ></path>
            <path
                d="M10 23H20"
                class="stroke-current"
                stroke-width="4"
                stroke-linecap="round"
            ></path>
            <path
                d="M10 31H38"
                class="stroke-current"
                stroke-width="4"
                stroke-linecap="round"
            ></path>
            <circle
                cx="34"
                cy="16"
                r="6"
                fill="#2F88FF"
                class="stroke-current"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="round"
            ></circle>
            <path
                d="M44.0001 28.4187C42.0469 24.6023 38.153 22 33.6682 22C28.2313 22 23.663 25.8243 22.3677 31"
                class="stroke-current"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="round"
            ></path>
        </g>
    </svg>
</template>
