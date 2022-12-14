import { reactive } from "vue";

interface Toast {
    // Add the properties that a Toast object should have
}

interface ToastStore {
    items: Toast[];
    add(toast: Toast): void;
    remove(index: number): void;
}

const toastStore: ToastStore = reactive({
    items: [],
    add(toast: Toast) {
        this.items.unshift(toast);
    },
    remove(index: number) {
        this.items.splice(index, 1);
    },
});

export default toastStore;
