<template>
    <AuthenticatedLayout>
        <div class="container">
            <div class="row text-center mt-4 mb-4">
                <div class="col">
                    <h4>Στατιστικά Ανακοίνωσεων</h4>
                </div>
            </div>
            <div class="row text-end mt-2 mb-4">
                <div class="col">
                    <Link :href="route('statistics.index')" class="btn btn-primary">Πίσω</Link>
                </div>
            </div>
           <apexchart
                type="bar"
                height="350"
                :options="chartOptions"
                :series="announcements"
           />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import dayjs from 'dayjs';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    dates:Array,
    totals:Array
});

const announcements = computed(() => [
    {
        announcements:'Ανακοίνωσεις',
        data:props.totals ?? []
    }
]);

const chartOptions = computed(() => ({
    chart:{
        id:'announcements-charts'
    },
    yaxis: {
        title: {
            text: 'Πλήθος Ανακοινώσεων'
        }
    },
    xaxis:{
        categories: (props.dates ?? []).map(
            date => dayjs(date).format('DD-MM-YYYY')
        ),
        title:{
            text: 'Ημερομηνίες Δημιουργίας'
        }
    }
}));
</script>
