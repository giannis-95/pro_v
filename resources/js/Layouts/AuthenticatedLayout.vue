<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

const notifications = ref([]);
const showDropdown = ref(false);
const open = ref(false);
const showingNavigationDropdown = ref(false);
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const toggleDropdown = () => {
    showDropdown.value = !showDropdown.value;
};

const userId = window.userId || null;

onMounted(() => {
    if (!userId) return console.warn('User ID missing!');

    if (!window.Echo) {
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: import.meta.env.VITE_PUSHER_APP_KEY,
            cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            forceTLS: true,
        });
    }

   window.Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        // debug για να δεις τι έρχεται
        console.log(notification);

        // προσθέτουμε στο array μόνο το message από data
        notifications.value.unshift(notification.data.message);
    });
});
</script>

<template>
<div>
    <div class="min-h-screen bg-gray-100">
        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <Link :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</Link>
                            <Link :href="route('users.index')">Users</Link>
                            <Link :href="route('courses.index')">Courses</Link>
                            <Link :href="route('courses.my-course')">My Courses</Link>
                        </div>
                    </div>

                    <!-- Notification Icon -->
                    <div class="notification-wrapper">
                        <div class="notification-icon" @click="toggleDropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16"><path d="M8 16a2 2 0 0 0 1.985-1.75H6.015A2 2 0 0 0 8 16z"/>
                                <path d="M8 1a4 4 0 0 1 4 4v2.086a1.5 1.5 0 0 0 .293.879l.823 1.03A1 1 0 0 1 12.382 11H3.618a1 1 0 0 1-.734-1.671l.823-1.03A1.5 1.5 0 0 0 4 7.086V5a4 4 0 0 1 4-4z"/>
                            </svg>
                            <span v-if="notifications.length" class="badge">{{ notifications.length }}</span>
                        </div>

                        <div class="notification-dropdown" v-show="showDropdown">
                            <div v-if="notifications.length === 0" class="notification-item">
                                No notifications
                            </div>
                            <div v-for="(notif, index) in notifications" :key="index" class="notification-item">
                                {{ notif }}
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <div class="relative ms-3">
                            <div class="dropdown" style="text-align:right;" width="48">
                                <div class="relative inline-block text-left">
                                    <button @click="open = !open" class="inline-flex justify-center w-full
                                        px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                        {{ $page.props.auth.user.name }}
                                        <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>

                                    <div v-if="open" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                        <div class="py-1">
                                            <form :action="route('logout')" method="POST" class="block px-4 py-2">
                                                <input type="hidden" name="_token" :value="csrfToken" />
                                                <Link :href="route('logout')" method="post" type="submit" class="w-full text-left text-sm text-gray-700 hover:bg-gray-100">Log Out</Link>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown =!showingNavigationDropdown" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ hidden: showingNavigationDropdown,'inline-flex':!showingNavigationDropdown,}"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
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
        </nav>

        <header class="bg-white shadow" v-if="$slots.header">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main>
            <slot />
        </main>
    </div>
</div>
</template>

<style scoped>
.notification-wrapper {
  position: relative;
  display: inline-block;
}

.notification-icon {
  cursor: pointer;
  font-size: 24px;
  position: relative;
}

.badge {
  position: absolute;
  top: -6px;
  right: -6px;
  background: red;
  color: white;
  border-radius: 50%;
  padding: 2px 6px;
  font-size: 12px;
}

.notification-dropdown {
  position: absolute;
  right: 0;
  top: 28px;
  width: 200px;
  background: white;
  border: 1px solid #ddd;
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
  z-index: 100;
}

.notification-item {
  padding: 8px 12px;
  border-bottom: 1px solid #eee;
}

.notification-item:last-child {
  border-bottom: none;
}
</style>
