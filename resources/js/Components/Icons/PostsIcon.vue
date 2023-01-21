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
        class="fill-current"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
    >
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_iconCarrier">
            <rect x="0" fill="none" width="24" height="24"></rect>
            <g>
                <path
                    d="M16 19H3v-2h13v2zm5-10H3v2h18V9zM3 5v2h11V5H3zm14 0v2h4V5h-4zm-6 8v2h10v-2H11zm-8 0v2h5v-2H3z"
                ></path>
            </g>
        </g>
    </svg>
</template>
