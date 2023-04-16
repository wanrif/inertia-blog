<script setup>
import { computed, ref, onMounted, onUnmounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import AccessControll from "@/Components/Icons/AccessControll.vue";
import DashboardIcon from "@/Components/Icons/DashboardIcon.vue";
import NavLink from "@/Components/NavLink.vue";
import PermissionsIcon from "@/Components/Icons/PermissionsIcon.vue";
import PostsIcon from "@/Components/Icons/PostsIcon.vue";
import RolesIcon from "@/Components/Icons/RolesIcon.vue";
import TagIcon from "@/Components/Icons/TagIcon.vue";
import UsersIcon from "@/Components/Icons/UsersIcon.vue";

const user = computed(() => usePage().props.auth.user);

const isOpenAccessControll = ref(false);

const clickOutside = (e) => {
    if (!e.target.closest("#dropdown-access-controll")) {
        isOpenAccessControll.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", clickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", clickOutside);
});
</script>

<template>
    <div
        class="fixed z-10 mt-16 shadow-sm dark:bg-gray-800 bg-white capitalize hidden sm:block transition-all inset-0 right-auto w-[17.5rem] pb-10 overflow-y-auto"
    >
        <div class="relative">
            <div class="px-6 pt-6">
                <div class="text-sm text-gray-500">Main</div>
            </div>
            <div>
                <!-- Dashboard -->
                <div
                    class="py-4 pl-6"
                    :class="{
                        'border-r-indigo-500 border-r-4 bg-gradient-to-r bg-indigo-50 dark:bg-indigo-900/50 from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-indigo-900':
                            route().current('dashboard'),
                    }"
                >
                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="flex items-center w-full gap-2"
                    >
                        <DashboardIcon size="h-5 w-5" />
                        Dashboard
                    </NavLink>
                </div>

                <!-- Posts -->
                <div
                    class="py-4 pl-6"
                    :class="{
                        'border-r-indigo-500 border-r-4 bg-gradient-to-r bg-indigo-50 dark:bg-indigo-900/50 from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-indigo-900':
                            route().current('dashboard.posts.*'),
                    }"
                >
                    <NavLink
                        :href="route('dashboard.posts.index')"
                        :active="route().current('dashboard.posts.*')"
                        class="flex items-center w-full gap-2"
                    >
                        <PostsIcon size="h-5 w-5" />
                        Posts
                    </NavLink>
                </div>

                <!-- Categories -->
                <div
                    v-if="user.role === 'super-admin' || user.role === 'admin'"
                    class="py-4 pl-6"
                    :class="{
                        'border-r-indigo-500 border-r-4 bg-gradient-to-r bg-indigo-50 dark:bg-indigo-900/50 from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-indigo-900':
                            route().current('dashboard.categories.*'),
                    }"
                >
                    <NavLink
                        :href="route('dashboard.categories.index')"
                        :active="route().current('dashboard.categories.*')"
                        class="flex items-center w-full gap-2"
                    >
                        <TagIcon size="h-5 w-5" />
                        Categories
                    </NavLink>
                </div>

                <!-- User -->
                <div
                    v-if="user.role === 'super-admin' || user.role === 'admin'"
                    class="py-4 pl-6"
                    :class="{
                        'border-r-indigo-500 border-r-4 bg-gradient-to-r bg-indigo-50 dark:bg-indigo-900/50 from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-indigo-900':
                            route().current('users.*'),
                    }"
                >
                    <NavLink
                        :href="route('users.index')"
                        :active="route().current('users.*')"
                        class="flex items-center w-full gap-2"
                    >
                        <UsersIcon size="h-5 w-5" />
                        User
                    </NavLink>
                </div>
            </div>
            <div v-if="user.role === 'super-admin' || user.role === 'admin'">
                <div class="px-6 py-2">
                    <div class="text-sm text-gray-500">Access Controll</div>
                </div>
                <div
                    id="dropdown-access-controll"
                    class="flex flex-col gap-2 px-6 py-4 font-semibold dark:text-gray-500 dark:hover:text-gray-300"
                    :class="{
                        'border-r-indigo-500 border-r-4 bg-gradient-to-r bg-indigo-50 dark:bg-indigo-900/50 from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-indigo-900':
                            route().current('roles.*') ||
                            route().current('permissions.*'),
                    }"
                >
                    <button
                        @click="isOpenAccessControll = !isOpenAccessControll"
                        class="flex items-center justify-between"
                    >
                        <div class="flex items-center gap-2">
                            <AccessControll size="h-5 w-5" />
                            Role & Permissions
                        </div>
                        <svg
                            class="w-5 h-5 transition fill-current duration-250"
                            :class="{
                                'transform rotate-180': isOpenAccessControll,
                            }"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_iconCarrier">
                                <rect
                                    x="0"
                                    fill="none"
                                    width="20"
                                    height="20"
                                ></rect>
                                <g>
                                    <path
                                        d="M15 14l-5-5-5 5-2-1 7-7 7 7z"
                                    ></path>
                                </g>
                            </g>
                        </svg>
                    </button>

                    <!-- Dropdown Access Controll -->
                    <transition name="dropdown">
                        <div
                            v-show="isOpenAccessControll"
                            class="flex flex-col gap-2 px-2 py-2 bg-gray-100 rounded-md dark:bg-gray-900"
                        >
                            <!-- Roles -->
                            <Link
                                :href="route('roles.index')"
                                class="flex items-center gap-2 px-2 py-1 text-sm transition rounded hover:bg-indigo-300 dark:text-gray-500 dark:hover:bg-gray-800"
                                :class="{
                                    'bg-indigo-300 dark:bg-gray-800':
                                        route().current('roles.*'),
                                }"
                            >
                                <RolesIcon />
                                Roles
                            </Link>

                            <!-- Permissions -->
                            <Link
                                :href="route('permissions.index')"
                                class="flex items-center gap-2 px-2 py-1 text-sm transition rounded hover:bg-indigo-300 dark:text-gray-500 dark:hover:bg-gray-800"
                                :class="{
                                    'bg-indigo-300 dark:bg-gray-800':
                                        route().current('permissions.*'),
                                }"
                            >
                                <PermissionsIcon size="w-5 h-5" />
                                Permissions
                            </Link>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.dropdown {
    transition: all 0.3s ease;
}

.dropdown-enter-active,
.dropdown-leave-active {
    transition: all 0.3s ease;
}

.dropdown-enter,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

.dropdown-enter-to {
    opacity: 1;
    transform: translateY(0);
}
</style>
