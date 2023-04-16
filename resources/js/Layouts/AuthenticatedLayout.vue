<script setup>
import { computed, ref, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { useColorMode, useCycleList } from "@vueuse/core";
import ApplicationLogo from "@/Components/Icons/ApplicationLogo.vue";
import DesktopIcon from "@/Components/Icons/DesktopIcon.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import MoonIcon from "@/Components/Icons/MoonIcon.vue";
import Sidebar from "./Partials/Sidebar.vue";
import SunIcon from "@/Components/Icons/SunIcon.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import ThemeMode from "@/Components/ThemeMode.vue";

const showingNavigationDropdown = ref(false);

const user = computed(() => usePage().props.auth.user);

const mode = useColorMode({
    emitAuto: true,
});

const { next } = useCycleList(["dark", "light", "auto"], {
    initialValue: mode,
});

const sidebar = ref(true);

onMounted(() => {
    if (window.innerWidth < 992) {
        sidebar.value = false;
    }
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav
                class="bg-white border-b border-gray-100 sm:fixed sm:w-full sm:z-10 dark:bg-gray-800 dark:border-gray-700"
            >
                <!-- Primary Navigation Menu -->
                <div class="px-4 mx-auto sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div
                                class="flex items-center sm:justify-between sm:min-w-[240px]"
                            >
                                <div class="flex items-center gap-4 font-viga">
                                    <Link :href="route('dashboard')">
                                        <ApplicationLogo
                                            class="block w-auto h-9"
                                        />
                                    </Link>
                                    <div
                                        class="text-xl font-semibold text-indigo-500 capitalize dark:text-gray-100 sm:text-2xl"
                                    >
                                        BlogifyX
                                    </div>
                                </div>

                                <!-- Sidebar Button -->
                                <button
                                    @click="sidebar = !sidebar"
                                    class="hidden p-1 transition duration-200 ease-in rounded-lg focus:ring-indigo-500 focus:ring-offset-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:block"
                                >
                                    <svg
                                        v-if="sidebar"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        class="w-5 h-5 text-indigo-500 -rotate-90 stroke-current dark:text-gray-100"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12"
                                        />
                                    </svg>
                                    <svg
                                        v-else
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        class="w-5 h-5 text-indigo-500 -rotate-90 stroke-current dark:text-gray-100"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Theme Mode -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <button
                                @click="next()"
                                class="p-2 transition duration-200 ease-in rounded-lg focus:ring-indigo-500 focus:ring-offset-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                            >
                                <div
                                    class="items-center block font-medium text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-gray-500"
                                >
                                    <MoonIcon
                                        v-if="mode === 'dark'"
                                        size="h-5 w-5"
                                    />
                                    <SunIcon
                                        v-if="mode === 'light'"
                                        size="h-5 w-5"
                                        fill="fill-indigo-500"
                                    />
                                    <DesktopIcon
                                        v-if="mode === 'auto'"
                                        size="h-5 w-5"
                                    />
                                </div>
                            </button>

                            <!-- Settings Dropdown -->
                            <div class="relative ml-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-200 dark:bg-gray-800 hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div
                                            class="block w-full px-4 py-2 text-xs leading-5 text-left transition duration-150 ease-in-out border-b select-none to-gray-700 dark:text-gray-200"
                                        >
                                            Signed in as {{ user.email }}
                                        </div>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                            class="flex items-center gap-4"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="w-5 h-5"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>

                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('home')"
                                            class="flex items-center gap-4"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="w-5 h-5"
                                            >
                                                <path
                                                    d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"
                                                />
                                                <path
                                                    d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"
                                                />
                                            </svg>

                                            Home
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="flex items-center gap-4"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="w-5 h-5"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm5.03 4.72a.75.75 0 010 1.06l-1.72 1.72h10.94a.75.75 0 010 1.5H10.81l1.72 1.72a.75.75 0 11-1.06 1.06l-3-3a.75.75 0 010-1.06l3-3a.75.75 0 011.06 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>

                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center -mr-2 sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 dark:hover:bg-gray-900"
                            >
                                <svg
                                    class="w-6 h-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('dashboard.posts.index')"
                            :active="route().current('dashboard.posts.*')"
                        >
                            Posts
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="
                                user.role === 'super-admin' ||
                                user.role === 'admin'
                            "
                            :href="route('dashboard.categories.index')"
                            :active="route().current('dashboard.categories.*')"
                        >
                            Categories
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="
                                user.role === 'super-admin' ||
                                user.role === 'admin'
                            "
                            :href="route('users.index')"
                            :active="route().current('users.*')"
                        >
                            User
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="
                                user.role === 'super-admin' ||
                                user.role === 'admin'
                            "
                            :href="route('roles.index')"
                            :active="route().current('roles.*')"
                        >
                            Roles
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="
                                user.role === 'super-admin' ||
                                user.role === 'admin'
                            "
                            :href="route('permissions.index')"
                            :active="route().current('permissions.*')"
                        >
                            Permissions
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex justify-between px-4">
                            <div>
                                <div
                                    class="text-base font-medium text-gray-500"
                                >
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>

                            <!-- Switch Theme -->
                            <ThemeMode />
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('profile.edit')"
                                :active="route().current('profile.edit')"
                            >
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('home')">
                                Home
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="w-full sm:flex">
                <!-- Sidebar -->
                <transition name="slide-fade">
                    <Sidebar v-show="sidebar" />
                </transition>

                <!-- Page Heading -->
                <div
                    class="w-full sm:mt-16"
                    :class="
                        sidebar
                            ? 'sm:ml-[280px] transition-all duration-300'
                            : 'transition-all duration-500'
                    "
                >
                    <header
                        class="bg-white shadow dark:bg-gray-800"
                        v-if="$slots.header"
                    >
                        <div
                            class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8"
                        >
                            <slot name="header" />
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main>
                        <slot />
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(-20px);
    opacity: 0;
}
</style>
