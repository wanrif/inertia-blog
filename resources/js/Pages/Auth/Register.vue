<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import WriteIcon from "@/Components/Icons/WriteIcon.vue";
import PasswordIcon from "@/Components/Icons/PasswordIcon.vue";
import EyePasswordIcon from "@/Components/Icons/EyePasswordIcon.vue";
import EyePasswordHideIcon from "@/Components/Icons/EyePasswordHideIcon.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const typePassword = () => {
    return showPassword.value ? "text" : "password";
};

const typeConfirmPassword = () => {
    return showConfirmPassword.value ? "text" : "password";
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
    typePassword();
};

const toggleConfirmPassword = () => {
    showConfirmPassword.value = !showConfirmPassword.value;
    typePassword();
};

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel
                    for="name"
                    value="Name"
                    class="text-quill-gray-100"
                />
                <div class="relative">
                    <input
                        id="name"
                        type="text"
                        class="block w-full px-4 py-3 text-sm rounded-md shadow-sm border-shark-200 pl-11 focus:z-10 focus:border-cyan-500 focus:ring-cyan-500 dark:bg-shark-900 dark:border-shark-700 dark:text-gray-400"
                        placeholder="Ohara Trees"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <div
                        class="absolute inset-y-0 left-0 z-20 flex items-center px-4 pointer-events-none"
                    >
                        <WriteIcon class="text-gray-400" />
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="email"
                    value="Email"
                    class="text-quill-gray-100"
                />
                <div class="relative">
                    <input
                        id="email"
                        type="email"
                        class="block w-full px-4 py-3 text-sm rounded-md shadow-sm border-shark-200 pl-11 focus:z-10 focus:border-cyan-500 focus:ring-cyan-500 dark:bg-shark-900 dark:border-shark-700 dark:text-gray-400"
                        placeholder="you@site.com"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                    <div
                        class="absolute inset-y-0 left-0 z-20 flex items-center px-4 pointer-events-none"
                    >
                        <svg
                            class="w-4 h-4 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"
                            />
                        </svg>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password"
                    value="Password"
                    class="text-quill-gray-100"
                />
                <div class="relative">
                    <input
                        id="password"
                        :type="typePassword()"
                        class="block w-full px-4 py-3 text-sm rounded-md shadow-sm border-shark-200 pl-11 pr-11 focus:z-10 focus:border-cyan-500 focus:ring-cyan-500 dark:bg-shark-900 dark:border-shark-700 dark:text-gray-400"
                        placeholder="********"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                    <div
                        class="absolute inset-y-0 left-0 z-20 flex items-center pl-4 pointer-events-none"
                    >
                        <PasswordIcon class="text-gray-400" />
                    </div>
                    <div
                        @click="togglePassword"
                        class="absolute inset-y-0 right-0 z-20 flex items-center pr-4 cursor-pointer"
                    >
                        <EyePasswordIcon
                            v-if="!showPassword"
                            class="text-gray-400"
                        />
                        <EyePasswordHideIcon v-else class="text-gray-400" />
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                    class="text-quill-gray-100"
                />
                <div class="relative">
                    <input
                        id="password_confirmation"
                        :type="typeConfirmPassword()"
                        class="block w-full px-4 py-3 text-sm rounded-md shadow-sm border-shark-200 pl-11 focus:z-10 focus:border-cyan-500 focus:ring-cyan-500 dark:bg-shark-900 dark:border-shark-700 dark:text-gray-400"
                        placeholder="********"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <div
                        class="absolute inset-y-0 left-0 z-20 flex items-center pl-4 pointer-events-none"
                    >
                        <PasswordIcon class="text-gray-400" />
                    </div>
                    <div
                        @click="toggleConfirmPassword"
                        class="absolute inset-y-0 right-0 z-20 flex items-center pr-4 cursor-pointer"
                    >
                        <EyePasswordIcon
                            v-if="!showConfirmPassword"
                            class="text-gray-400"
                        />
                        <EyePasswordHideIcon v-else class="text-gray-400" />
                    </div>
                </div>
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="text-sm underline text-quill-gray-100"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ml-4"
                    bgColor="bg-accent-2 hover:bg-cyan-700 dark:bg-accent-2 dark:hover:bg-cyan-700"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
