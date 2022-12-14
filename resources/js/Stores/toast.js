import { reactive } from "vue";

export default reactive({
    items: [],
    add(toast) {
        this.items.unshift(toast);
    },
    remove(index) {
        this.items.splice(index, 1);
    }
});
