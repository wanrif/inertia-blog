<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import ThemeMode from "@/Components/ThemeMode.vue";
import FooterVue from "@/Components/Footer.vue";

const canLogin = computed(() => usePage().props.canLogin);
const canRegister = computed(() => usePage().props.canRegister);

const isOpen = ref(false);

const showMobileMenu = () => {
    isOpen.value = true;
};

const closeMobileMenu = () => {
    isOpen.value = false;
};
</script>

<template>
    <div class="bg-white dark:bg-shark-900 sm:bg-quill-gray-100">
        <nav
            class="fixed z-10 w-full bg-white shadow sm:bg-quill-gray-100 sm:shadow-transparent sm:relative dark:bg-shark-900"
        >
            <div
                class="container flex items-center justify-between p-6 mx-auto sm:block"
            >
                <div class="flex items-center gap-1 sm:justify-center">
                    <ApplicationLogo class="w-8 h-8 fill-cyan-500" />
                    <Link
                        href="/"
                        class="text-2xl font-bold text-gray-800 font-viga dark:text-white lg:text-3xl hover:text-gray-700 dark:hover:text-gray-300"
                        >Wanrif
                    </Link>
                </div>

                <!-- Primary Navigation Menu -->
                <div
                    class="items-center justify-center hidden mt-6 text-gray-600 capitalize sm:flex dark:text-gray-300"
                >
                    <div
                        class="items-center hidden px-10 py-1 border-2 rounded-full border-cyan-500 sm:flex"
                    >
                        <Link
                            href="/"
                            :class="
                                route().current('home')
                                    ? 'text-gray-800 dark:text-gray-200 border-b-2 border-cyan-500'
                                    : 'border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-cyan-500'
                            "
                            class="mx-1.5 sm:mx-6"
                            >Home
                        </Link>

                        <Link
                            :href="route('blog.index')"
                            :class="
                                route().current('blog.*')
                                    ? 'text-gray-800 dark:text-gray-200 border-b-2 border-cyan-500'
                                    : 'border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-cyan-500'
                            "
                            class="mx-1.5 sm:mx-6"
                            >Blog
                        </Link>

                        <div v-if="canLogin">
                            <Link
                                v-if="$page.props.auth"
                                :href="route('dashboard')"
                                class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-cyan-500 mx-1.5 sm:mx-6"
                                >Dashboard
                            </Link>
                            <Link
                                v-if="$page.props.auth"
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-cyan-500 mx-1.5 sm:mx-5 md:mx-6"
                                >Logout
                            </Link>
                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-cyan-500 mx-1.5 sm:mx-5 md:mx-6"
                                    >Login
                                </Link>
                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-cyan-500 mx-1.5 sm:mx-6"
                                    >Register
                                </Link>
                            </template>
                        </div>

                        <!-- Switch Theme -->
                        <ThemeMode class="mx-1.5 sm:mx-5" />
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                <div class="sm:hidden">
                    <button
                        @click="showMobileMenu"
                        type="button"
                        class="px-2 py-2 transition duration-200 ease-in rounded-lg hover:text-gray-800 dark:text-gray-100 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 min-w-max focus:ring-offset-cyan-200"
                    >
                        <svg
                            class="w-4 h-4 fill-current"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <title>Menu</title>
                            <path
                                d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <Teleport to="body">
                    <transition name="bg-modal">
                        <div
                            @click.self="closeMobileMenu"
                            v-if="isOpen"
                            class="fixed inset-0 z-20 min-h-screen sm:hidden backdrop-blur-sm bg-black/20 dark:bg-slate-900/80"
                        ></div>
                    </transition>
                    <transition name="bounce">
                        <div
                            v-if="isOpen"
                            class="fixed inset-0 z-20 m-10 bg-gray-100 rounded-lg shadow-lg sm:hidden dark:bg-slate-800 min-h-max"
                        >
                            <!-- Close Button -->
                            <button
                                @click="closeMobileMenu"
                                type="button"
                                class="absolute z-30 px-1 py-1 m-4 transition duration-200 ease-in bg-gray-200 rounded-lg cursor-pointer dark:bg-gray-800 top-1 right-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-cyan-200"
                            >
                                <CloseIcon
                                    fill="fill-gray-800 dark:fill-gray-300"
                                />
                            </button>
                            <div class="px-2 pt-2 pb-4">
                                <Link
                                    href="/"
                                    :class="
                                        route().current('home')
                                            ? 'bg-cyan-700 text-gray-100 dark:text-gray-200 border-cyan-500'
                                            : 'hover:text-gray-800 dark:hover:text-gray-200 hover:border-cyan-500 dark:text-gray-300'
                                    "
                                    class="block px-4 py-2 mt-2 text-sm font-medium rounded hover:bg-gray-100 dark:hover:bg-gray-800"
                                    >Home
                                </Link>
                                <Link
                                    :href="route('blog.index')"
                                    :class="
                                        route().current('blog.index')
                                            ? 'bg-cyan-700 text-gray-100 dark:text-gray-200 border-cyan-500'
                                            : 'hover:text-gray-800 text-gray-700 dark:hover:text-gray-200 hover:border-cyan-500 dark:text-gray-300'
                                    "
                                    class="block px-4 py-2 mt-2 text-sm font-medium rounded hover:bg-gray-100 dark:hover:bg-gray-800"
                                    >Blog
                                </Link>
                                <div v-if="canLogin">
                                    <Link
                                        v-if="$page.props.auth"
                                        :href="route('dashboard')"
                                        class="block px-4 py-2 mt-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                                        >Dashboard
                                    </Link>
                                    <Link
                                        v-if="$page.props.auth"
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="block px-4 py-2 mt-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                                        >Logout
                                    </Link>
                                    <template v-else>
                                        <Link
                                            :href="route('login')"
                                            class="block px-4 py-2 mt-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                                            >Login
                                        </Link>
                                        <Link
                                            v-if="canRegister"
                                            :href="route('register')"
                                            class="block px-4 py-2 mt-2 text-sm font-medium text-gray-700 rounded hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                                            >Register
                                        </Link>
                                    </template>
                                </div>
                                <hr />
                                <!-- Switch Theme -->
                                <div
                                    class="flex items-center justify-between w-full px-4 py-2 mt-2 text-sm font-medium text-gray-700 transition duration-200 ease-in rounded-lg dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-cyan-200 dark:text-gray-300"
                                >
                                    Switch Theme
                                    <ThemeMode rounded="square" />
                                </div>
                            </div>
                        </div>
                    </transition>
                </Teleport>
            </div>
        </nav>

        <div class="pt-24 pb-4 overflow-y-hidden sm:pt-10 sm:pb-4">
            <slot />
        </div>
        <FooterVue />
    </div>
</template>

<style scoped>
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.bg-modal-enter-active {
    animation: fade-in 0.5s;
}
.bg-modal-leave-active {
    animation: fade-in 0.5s reverse;
}
@keyframes fade-in {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.bounce-enter-active {
    animation: bounce-in 0.5s;
}
.bounce-leave-active {
    animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.12);
    }
    100% {
        transform: scale(1);
    }
}
</style>
