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
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 100 100"
        enable-background="new 0 0 100 100"
        xml:space="preserve"
    >
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_iconCarrier">
            <g>
                <path
                    d="M61.8,29.4l8.9,8.9l0,0c2,1.9,2,5.1,0,7l0,0L47.5,68.4V47.3V36.6l7.2-7.3C56.6,27.4,59.9,27.4,61.8,29.4z"
                ></path>
            </g>
            <path
                d="M37.5,20H25c-2.8,0-5,2.2-5,5v43.8C20,75,25,80,31.2,80s11.2-5,11.2-11.2V25C42.5,22.2,40.2,20,37.5,20z M31.2,73.8c-2.8,0-5-2.2-5-5s2.2-5,5-5s5,2.2,5,5S34,73.8,31.2,73.8z"
            ></path>
            <g>
                <path
                    d="M75,57.5h-8.8l-6,6H74L73.9,74H49.8l-6,6H75c2.8,0,5-2.2,5-5V62.5C80,59.8,77.8,57.5,75,57.5L75,57.5z"
                ></path>
            </g>
        </g>
    </svg>
</template>
