<script setup>
import axios from "axios";
import { ref, shallowRef } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Editor from "ckeditor5-custom-build/build/ckeditor";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import SubmitButton from "@/Components/SubmitButton.vue";
import ProcessingIcon from "@/Components/Icons/ProcessingIcon.vue";

const props = defineProps({
    categories: Object,
});

/**
 * Form Helpers
 * @type {import("@inertiajs/vue3").Form}
 * @see https://inertiajs.com/forms#form-helper
 */
const form = useForm({
    title: "",
    slug: "",
    category_id: "",
    image: "",
    body: "",
});

/**
 * Slugify the title
 */
function titleField() {
    if (form.title) {
        axios
            .get(`/dashboard/posts/getSlug?title=${form.title}`)
            .then((response) => {
                form.slug = response.data.slug;
            });
    } else {
        form.reset("slug");
    }
}

/**
 * Image Upload
 * onChange: Read the file and set the form image
 * onRemove: Reset the form image and the input file
 */
const urlImage = ref(null);
function imageField() {
    return {
        onChange: (event) => {
            const file = event.target.files[0];
            const reader = new FileReader();
            form.image = file;
            reader.onload = (event) => {
                urlImage.value = event.target.result;
            };
            reader.readAsDataURL(file);
        },
        onRemove: () => {
            document.querySelector("#imageInput").value = "";
            form.reset("image");
            urlImage.value = null;
        },
    };
}

const textEditor = shallowRef({
    editor: Editor,
    editorConfig: {
        toolbar: {
            items: [
                "heading",
                "|",
                "bold",
                "italic",
                "strikethrough",
                "underline",
                "link",
                "bulletedList",
                "numberedList",
                "|",
                "alignment",
                "outdent",
                "indent",
                "|",
                "htmlEmbed",
                "imageUpload",
                "blockQuote",
                "insertTable",
                "mediaEmbed",
                "|",
                "removeFormat",
                "undo",
                "redo",
            ],
        },
        language: "en",
        table: {
            contentToolbar: ["tableColumn", "tableRow", "mergeTableCells"],
        },
    },
});

/**
 * Submit Form
 */
function submit() {
    form.post(route("dashboard.posts.store"), {
        onSuccess: () => {
            form.reset();
            urlImage.value = null;
        },
    });
}
</script>

<template>
    <Head title="Create Post" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="text-xl font-bold leading-tight text-gray-800 cursor-default dark:text-gray-200"
            >
                <Link :href="route('dashboard.posts.index')">Posts</Link>
                <span class="text-indigo-500"> / Create</span>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg"
                >
                    <div
                        class="p-6 bg-white border-b dark:border-b-0 dark:bg-gray-800"
                    >
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <!-- TITLE -->
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="title"
                                        value="Title"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <TextInput
                                        id="title"
                                        type="text"
                                        class="block w-full mt-1 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-800"
                                        :class="'ring-red-500' +
                                            (form.errors.title ? ' ring-2' : '')
                                        "
                                        @change="titleField()"
                                        v-model="form.title"
                                        placeholder="Title"
                                        autofocus
                                        required
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.title"
                                    />
                                </div>

                                <!-- SLUG -->
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="slug"
                                        value="Slug"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <TextInput
                                        id="slug"
                                        type="text"
                                        class="block w-full mt-1 placeholder-gray-400 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-800 disabled:text-gray-500 dark:disabled:text-gray-400 disabled:bg-gray-200 disabled:cursor-not-allowed"
                                        :class="'ring-red-500' +
                                            (form.errors.slug ? ' ring-2' : '')
                                        "
                                        v-model="form.slug"
                                        placeholder="Slug"
                                        disabled="disabled"
                                        required
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.slug"
                                    />
                                </div>

                                <!-- IMAGE -->
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="image"
                                        value="Image"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <div class="flex items-center gap-2">
                                        <label class="w-full">
                                            <span class="sr-only">
                                                Choose image
                                            </span>
                                            <input
                                                @change="imageField().onChange"
                                                id="imageInput"
                                                type="file"
                                                class="block w-full text-sm border border-gray-100 rounded-full dark:border-gray-700 text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 dark:text-gray-200 hover:file:bg-violet-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none focus:rounded-full"
                                            />
                                        </label>
                                        <button
                                            v-show="urlImage"
                                            @click="imageField().onRemove"
                                            type="button"
                                            class="p-1 transition duration-200 ease-in rounded-full hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="w-6 h-6"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                    <transition
                                        enterActiveClass="transition ease-out duration-300"
                                        enterClass="opacity-0 transform scale-90"
                                        enterToClass="opacity-100 transform scale-100"
                                        leaveActiveClass="transition ease-in duration-200"
                                        leaveClass="opacity-100 transform scale-100"
                                        leaveToClass="opacity-0 transform scale-90"
                                    >
                                        <img
                                            v-show="urlImage"
                                            :src="urlImage"
                                            class="w-full mt-4 h-80"
                                        />
                                    </transition>
                                    <div
                                        v-if="form.errors.image"
                                        class="mt-1 text-sm text-red-500"
                                    >
                                        {{ form.errors.image }}
                                    </div>
                                </div>

                                <!-- CATEGORY -->
                                <div
                                    class="w-full col-span-2 mb-3 md:col-span-1"
                                >
                                    <InputLabel
                                        for="category_id"
                                        value="Category"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <select
                                        v-model="form.category_id"
                                        class="dark:bg-gray-700 dark:text-gray-200 dark:border-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                                        :class="'ring-red-500' +
                                            (form.errors.category_id
                                                ? ' ring-2'
                                                : '')
                                        "
                                    >
                                        <option disabled value="" selected>
                                            Please select one category
                                        </option>
                                        <option
                                            v-for="category in props.categories"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.category_id"
                                    />
                                </div>

                                <!-- BODY -->
                                <div class="w-full col-span-2 mb-2">
                                    <InputLabel
                                        value="Body"
                                        class="text-base text-gray-700 dark:text-gray-200"
                                    />
                                    <ckeditor
                                        :editor="textEditor.editor"
                                        v-model="form.body"
                                        :config="textEditor.editorConfig"
                                    ></ckeditor>

                                    <div
                                        v-if="form.errors.body"
                                        class="mt-1 text-sm text-red-500"
                                    >
                                        {{ form.errors.body }}
                                    </div>
                                </div>
                            </div>

                            <SubmitButton
                                :disabled="form.processing"
                                :class="
                                    form.processing
                                        ? 'flex items-center justify-center'
                                        : ''
                                "
                            >
                                <ProcessingIcon v-if="form.processing" />
                                {{
                                    form.processing
                                        ? "Processing..."
                                        : "Create Post"
                                }}
                            </SubmitButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style></style>
