<script setup>
// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

defineProps({
    MyImage: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <file-pond
        name="test"
        ref="pond"
        label-idle="Drop files here or <span class='filepond--label-action'>Browse</span>"
        allow-multiple="false"
        accepted-file-types="image/jpeg, image/png"
        v-bind:files="MyImage"
    />
</template>
