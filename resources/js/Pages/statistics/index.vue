<template>
    <AuthenticatedLayout>
        <div class="container">
            <div class="row mt-4">
                <div class="col">
                    <button class="btn btn-danger me-2">Εξαγωγή pdf</button>
                    <Link :href="route('statistics.courses')" class="btn btn-primary me-2">Στατιστικά Μαθημάτων</Link>
                    <Link :href="route('statistics.my-courses')" class="btn btn-primary me-2">Στατιστικά των Μαθημάτων μου</Link>
                    <Link :href="route('statistics.announcements')" class="btn btn-primary">Στατιστικά Ανακοίνωσεων</Link>
                </div>
            </div>
            <div class="row text-center mt-4 mb-4">
                <div class="col">
                    <h4>Στατιστικά Χρηστών</h4>
                </div>
            </div>
            <div class="p-6">
                <apexchart
                    type="bar"
                    height="350"
                    :options="chartOptions"
                    :series="users"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import dayjs from 'dayjs';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    dates: Array,
    totals: Array
})

const users = computed(() => [
    {
        name: 'Χρήστες',
        data: props.totals ?? []
    }
])

const chartOptions = computed(() => ({
    chart: {
        id: 'users-chart'
    },
    yaxis:{
        title:{
            text:'Πλήθος Χρηστών'
        }
    },
    xaxis: {
        categories: (props.dates ?? []).map(date =>
            dayjs(date).format("DD-MM-YYYY")
        ),
        title:{
            text:'Ημερομηνία Δημιουργίας'
        }
    }
}))
</script>
