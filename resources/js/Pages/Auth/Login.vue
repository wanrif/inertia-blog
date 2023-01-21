<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PasswordIcon from "@/Components/Icons/PasswordIcon.vue";
import EyePasswordIcon from "@/Components/Icons/EyePasswordIcon.vue";
import EyePasswordHideIcon from "@/Components/Icons/EyePasswordHideIcon.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "superadmin@role.test",
    password: "password",
    remember: false,
});

const showPassword = ref(false);

const typePassword = () => {
    return showPassword.value ? "text" : "password";
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
    typePassword();
};

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="mb-4">
            <div class="text-2xl font-semibold text-accent-2">
                Log in to your account
            </div>
            <div class="text-sm text-quill-gray-100">
                Don't have an account?
                <Link
                    :href="route('register')"
                    class="font-semibold underline text-quill-gray-100"
                >
                    Register.
                </Link>
            </div>
        </div>

        <div
            v-if="status"
            class="p-2 mb-4 text-sm font-medium rounded-md text-accent-2 bg-quill-gray-100 dark:bg-shark-900"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel
                    for="email"
                    value="Email"
                    class="text-sm text-quill-gray-100"
                />
                <div class="relative">
                    <input
                        id="email"
                        type="email"
                        class="block w-full px-4 py-3 text-sm border-gray-200 rounded-md shadow-sm pl-11 focus:z-10 focus:border-cyan-500 focus:ring-cyan-500 dark:bg-shark-900 dark:border-shark-700 dark:text-shark-400"
                        placeholder="you@site.com"
                        v-model="form.email"
                        required
                        autofocus
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
                    class="text-sm text-quill-gray-100"
                />
                <div class="relative">
                    <input
                        id="password"
                        :type="typePassword()"
                        class="block w-full px-4 py-3 text-sm rounded-md shadow-sm border-shark-200 pl-11 pr-11 focus:z-10 focus:border-cyan-500 focus:ring-cyan-500 dark:bg-shark-900 dark:border-shark-700 dark:text-gray-400"
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

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-quill-gray-100"
                        >Remember me</span
                    >
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm underline text-quill-gray-100"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton
                    class="ml-4"
                    bgColor="bg-accent-2 hover:bg-cyan-700 dark:bg-accent-2 dark:hover:bg-cyan-700"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
