<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { onUnmounted } from "vue";
import { nanoid } from "nanoid";
import ToastItem from "@/Components/ToastItem.vue";
import toastStore from "@/Store/toast";

let removeFinishEventListener = router.on("finish", () => {
    const { success, error } = usePage().props.toast;

    if (success) {
        toastStore.add({
            key: nanoid(6),
            type: "success",
            message: success,
        });
    }
    if (error) {
        toastStore.add({
            key: nanoid(6),
            type: "error",
            message: error,
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
            :type="item.type"
            :message="item.message"
            :duration="3500"
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
