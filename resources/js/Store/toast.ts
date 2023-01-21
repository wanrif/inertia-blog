import { reactive } from "vue";

interface ToastStore {
    items: any[];
    add: (toast: any) => void;
    remove: (index: number) => void;
}

const toastStore: ToastStore = reactive({
    items: [],
    add(toast) {
        this.items.unshift(toast);
    },
    remove(index) {
        this.items.splice(index, 1);
    },
});

export default toastStore;
