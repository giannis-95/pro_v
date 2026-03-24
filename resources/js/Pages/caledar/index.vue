<template>
    <AuthenticatedLayout>
          <div>
            <FullCalendar
                :plugins="[dayGridPlugin, interactionPlugin]"
                initial-view="dayGridMonth"
                :events="events"
                @date-click="handleDateClick"
                @event-click="handleEventClick"
            />

            <!-- Modal ή form για προσθήκη νέου event -->
            <form @submit.prevent="addEvent">
            <input v-model="newEvent.title" placeholder="Event Title" required />
            <input type="datetime-local" v-model="newEvent.start" required />
            <input type="datetime-local" v-model="newEvent.end" />
            <button type="submit">Add Event</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import { Inertia } from '@inertiajs/inertia'
</script>
