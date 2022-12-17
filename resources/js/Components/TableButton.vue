<script setup>
import { shallowRef, ref } from "vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import DetailIcon from "@/Components/Icons/DetailIcon.vue";
import EditIcon from "@/Components/Icons/EditIcon.vue";

const props = defineProps({
    typeButton: {
        type: String,
        default: "btnDetail",
    },
    type: {
        type: String,
        default: "button",
    },
    value: {
        type: String,
        default: "Detail",
    },
});

const isClass = ref({
    btnDetail: "bg-indigo-500 hover:bg-indigo-600 focus:ring-indigo-500",
    btnEdit: "bg-teal-500 hover:bg-teal-600 focus:ring-teal-500",
    btnDelete: "bg-rose-500 hover:bg-rose-600 focus:ring-rose-500",
});

const isIcon = shallowRef({
    btnDetail: DetailIcon,
    btnEdit: EditIcon,
    btnDelete: TrashIcon,
});
</script>

<template>
    <button
        :type="type"
        :class="isClass[props.typeButton]"
        class="flex items-center justify-center gap-1 px-2 py-1 text-sm font-semibold text-white transition-all border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
    >
        {{ props.value }}
        <component :is="isIcon[props.typeButton]" />
    </button>
</template>
