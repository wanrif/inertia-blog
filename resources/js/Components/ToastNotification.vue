<script setup>
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-vue3";
import { onUnmounted } from "vue";
import { nanoid } from "nanoid";
import ToastItem from "@/Components/ToastItem.vue";
import toastStore from "@/Stores/toasts";

const page = usePage();

let removeFinishEventListener = Inertia.on("finish", () => {
    if (page.props.value.toast.message) {
        toastStore.add({
            key: nanoid(6),
            message: page.props.value.toast.message,
        });
    }
});

onUnmounted(() => removeFinishEventListener());
</script>

<template>
    <TransitionGroup
        name="list"
        tag="div"
        class="fixed z-50 w-full max-w-xs space-y-4 right-4 top-14"
    >
        <ToastItem
            v-for="(item, index) in toastStore.items"
            :key="item.key"
            :message="item.message"
            :duration="3000"
            @remove="toastStore.remove(index)"
        />
    </TransitionGroup>
</template>

<style>
.list-move, /* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
.list-leave-active {
    position: absolute;
}
</style>
