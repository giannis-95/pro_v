<template>
    <AuthenticatedLayout>
        <div class="container py-4">
            <div class="calendar-wrapper">
                <div class="calendar-header">
                    <button @click="prevMonth" class="btn btn-primary">←</button>
                    <h2>{{ monthName }} {{ year }}</h2>
                    <button @click="nextMonth" class="btn btn-primary">→</button>
                </div>
                <div class="weekdays">
                    <div v-for="day in weekdays" :key="day" class="weekday">{{ day }}</div>
                </div>
                <div class="calendar-grid">
                    <div v-for="(day,index) in calendarDays" :key="index" class="calendar-cell">
                        <div v-if="day">
                            <div class="day-number">
                                {{ day }}
                            </div>
                            <div class="announcements">
                                <div v-for="announcement in dayAnnouncements(day)" :key="announcement.id" class="announcement">
                                    <button type="button" style="color: white;" @click="openAnnouncementModal(announcement)">
                                        <div class="row">
                                            <span><strong>Τίτλος:</strong>{{ announcement.title }}</span>
                                            <span><strong>Μάθημα:</strong>{{ announcement.course.title }}</span>
                                            <span><strong>Καθηγητής:</strong>{{ announcement.user.name }}</span>
                                            <span><strong>Ημερομηνία:</strong>{{ dayjs(announcement.created_at).format('DD-MM-YYYY') }}</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ShowAnnouncementModal :announcement="show_announcement"></ShowAnnouncementModal>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import dayjs from 'dayjs';
import { Modal } from 'bootstrap';
import ShowAnnouncementModal from '@/Pages/calendar/show.vue';

const currentDate = ref(new Date())
const show_announcement = ref(null);

const props = defineProps({
    announcements: Array
})

const weekdays = [
    'Δευ',
    'Τρι',
    'Τετ',
    'Πεμ',
    'Παρ',
    'Σαβ',
    'Κυρ'
]

const months = [
    'Ιανουάριος',
    'Φεβρουάριος',
    'Μάρτιος',
    'Απρίλιος',
    'Μάιος',
    'Ιούνιος',
    'Ιούλιος',
    'Αύγουστος',
    'Σεπτέμβριος',
    'Οκτώβριος',
    'Νοέμβριος',
    'Δεκέμβριος'
]

const month = computed(() => {
    return currentDate.value.getMonth()
})

const year = computed(() => {
    return currentDate.value.getFullYear()
})

const monthName = computed(() => {
    return months[month.value]
})

const daysInMonth = computed(() => {
    return new Date(
        year.value,
        month.value + 1,
        0
    ).getDate()
})

const firstDay = computed(() => {
    let day = new Date(
        year.value,
        month.value,
        1
    ).getDay()

    return day === 0 ? 6 : day - 1
})

const calendarDays = computed(() => {
    let days = []

    for(let i = 0; i < firstDay.value; i++){
        days.push(null)
    }

    for(let d = 1; d <= daysInMonth.value; d++){
        days.push(d)
    }

    return days
})

const nextMonth = () => {
    currentDate.value = new Date(
        year.value,
        month.value + 1,
        1
    )
}

const prevMonth = () => {
    currentDate.value = new Date(
        year.value,
        month.value - 1,
        1
    )
}

const dayAnnouncements = (day) => {
    if(!day) return []

    const date = `${year.value}-${String(month.value + 1).padStart(2,'0')}-${String(day).padStart(2,'0')}`

    return props.announcements.filter(announcement =>
        announcement.created_at.startsWith(date)
    )
}

function openAnnouncementModal(announcement){
    show_announcement.value = announcement;
    const modal = new Modal(document.getElementById('announcementModal'))
    modal.show()
}
</script>

<style scoped>

.calendar-wrapper{
    background:white;
    padding:20px;
    border-radius:10px;
}

.calendar-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.calendar-grid,
.weekdays{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:10px;
}

.weekday{
    font-weight:bold;
    text-align:center;
}

.calendar-cell{
    min-height:120px;
    border:1px solid #ddd;
    border-radius:6px;
    padding:10px;
    background:#fafafa;
}

.calendar-cell:hover{
    background:#f0f0f0;
}

.day-number{
    font-weight:bold;
    margin-bottom:5px;
}

.announcements{
    display:flex;
    flex-wrap:wrap;
    gap:4px;
}

.announcement{
    background:#2563eb;
    color:white;
    padding:3px 6px;
    border-radius:12px;
    font-size:11px;
    white-space:nowrap;
}
</style>
