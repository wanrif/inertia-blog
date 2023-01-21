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
        viewBox="0 0 64 64"
        data-name="Material Expand"
        id="Material_Expand"
        xmlns="http://www.w3.org/2000/svg"
    >
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_iconCarrier">
            <path
                d="M60,3H22a2,2,0,0,0-2,2v6H4a2,2,0,0,0-2,2V45a2,2,0,0,0,2,2h8.264l-3.5,7H4v4H40V54H35.236l-3.5-7H42a2,2,0,0,0,2-2V39H60a2,2,0,0,0,2-2V5A2,2,0,0,0,60,3ZM40,15V35H6V15ZM30.764,54H13.236l3.5-7H27.264ZM40,43H6V39H40Zm18-8H44V13a2,2,0,0,0-2-2H24V7H58Z"
            ></path>
            <path
                d="M12,31H22a2,2,0,0,0,2-2V21a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2v8A2,2,0,0,0,12,31Zm2-8h6v4H14Z"
            ></path>
            <rect height="4" width="8" x="28" y="19"></rect>
            <rect height="4" width="8" x="28" y="27"></rect>
            <rect height="4" width="6" x="48" y="11"></rect>
            <rect height="4" width="6" x="48" y="19"></rect>
            <rect height="4" width="6" x="48" y="27"></rect>
        </g>
    </svg>
</template>
