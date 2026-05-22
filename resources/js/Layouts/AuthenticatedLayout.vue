<script setup>
import { ref, onMounted } from 'vue';
import { Link , usePage } from '@inertiajs/vue3';

const open = ref(false);
const showingNavigationDropdown = ref(false);
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const notifications = ref([]);
const userId = usePage().props.auth.user.id;

onMounted(async () => {
    const res = await axios.get('/notifications/send');
    notifications.value = res.data;
    window.Echo.private(`App.Models.User.${userId}`).notification((notification) => {
        notifications.value.unshift(notification);
    });

    // window.Echo.channel('chat')
    // .listen('MessageSent', (e) => {
    //     console.log('New message:', e.message)
    //     messages.value.push(e.message)
    // })
});

const markAsRead = async (notification) => {
    await axios.post(`/notifications/${notification.id}/read`);

    notifications.value = notifications.value.filter(
        notification_user => notification_user.id !== notification.id
    );
};

const isAdmin = usePage().props.auth.user.roles.some(role => role.name === 'Διαχειριστής');
</script>

<template>
<div>
    <div class="min-h-screen">
        <nav class="border-b bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-10">
                <div class="flex h-16 justify-between">
                    <!-- Links -->
                    <div class="flex mt-4">
                        <div class="hidden space-x-6 sm:-my-px sm:ms-7 sm:flex">
                            <Link :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</Link>
                            <Link :href="route('users.index')" v-if="isAdmin">Χρήστες</Link>
                            <Link :href="route('courses.index')">Μαθήματα</Link>
                            <Link :href="route('courses.my-course')">Τα Μαθήματα μου</Link>
                            <Link :href="route('announcements.index')">Ανακοινώσεις</Link>
                            <Link :href="route('messages.index')">Μηνύματα</Link>
                            <Link :href="route('calendar.index')">Ημερολόγιο</Link>
                            <Link :href="route('statistics.index')" v-if="isAdmin">Στατιστικά</Link>
                        </div>
                    </div>
                    <!-- User Dropdown & Notifications -->
                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <!-- User Dropdown -->
                        <div class="relative ms-3">
                            <div class="dropdown" style="text-align:right;" width="48">
                                <div class="relative inline-block text-left">
                                    <button @click="open = !open"
                                        class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
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
                        <!-- Notification Icon -->
                        <div class="dropdown">
                            <button type="button"
                                class="btn btn-primary"
                                id="dropdownNotification"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                                style="margin-left: 20px;
                                overflow-y: auto;
                                max-height:200px;">🔔
                                <span v-if="notifications.length" class="badge bg-danger">
                                    {{ notifications.length }}
                                </span>
                            </button>
                            <div class="dropdown-menu notification-menu">
                                <div v-if="notifications.length">
                                    <a v-for="(notification, index) in notifications" :key="notification.id + '-' + index" class="dropdown-item" @click.stop="markAsRead(notification)">
                                        <div>
                                            <strong>{{ notification.data?.message || notification.message }}</strong>
                                        </div>
                                        <div>
                                            <span style="color: green;">{{ notification.data?.title || notification.title }}</span>
                                        </div>
                                        <small class="text-muted">
                                            {{ new Date(notification.created_at).toLocaleString() }}
                                        </small>
                                    </a>
                                </div>
                                <div v-else class="dropdown-item text-muted">
                                    Δεν υπάρχουν νέες ειδοποιήσεις
                                </div>
                                <hr>
                                <div class="d-flex justify-content-center mt-2">
                                    <Link :href="route('notifications.index')" class="btn btn-primary">Όλες οι ειδοποιήσεις μου</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
