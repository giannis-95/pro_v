<template>
    <AuthenticatedLayout>
        <div class="container">
            <div class="row text-center mt-4">
                <h3>Ιστορικό Ανακοινώσεων</h3>
            </div>
            <hr>
            <div class="row text-end">
                <div class="col">
                    <Link :href="route('announcements.index')" class="btn btn-primary">Πίσω</Link>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3 mb-3">
                    <button type="button" @click="showFilterAnnouncement =! showFilterAnnouncement" class="btn btn-primary">
                        {{ showFilterAnnouncement ? 'Κλεισιμο Φίλτρων' : 'Φίλτρα' }}
                    </button>
                    <filterAnnouncements v-if="showFilterAnnouncement"
                                        @search="searchFilterAnnouncement"
                                        @reset="resetFilterAnnouncement"
                                        :courses="courses"
                                        :instructor_admins="instructor_admins">
                        <template #statusAnnouncement = "{ announcement_filters }">
                            <div class="row mt-4">
                                <div class="col">
                                    <div class="row">
                                        <label class="col-3 col-form-label">Κατάσταση Ανακοινώσης:</label>
                                        <div class="col-9">
                                            <select class="form-control" v-model="announcement_filters.status">
                                                <option value="">Επιλέξτε Κατάσταση...</option>
                                                <option value="Ενεργή">Ενεργή</option>
                                                <option value="Διαγραμμένη">Διαγραμμένη</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </filterAnnouncements>
                    <Link class="btn btn-secondary ml-2">Εκτύπωση Excel</Link>
                    <Link class="btn btn-danger ml-2">Εκτύπωση Pdf</Link>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Τίτλος</th>
                        <th>Μάθημα</th>
                        <th>Καθηγητής</th>
                        <th>Ημερομηνία Δημιουργίας</th>
                        <th>Ημερομηνία Ενημέρωσης</th>
                        <th>Κατάσταση Ανακοίνωσης</th>
                        <th>Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="announcement_history in announcement_histories.data" :key="announcement_history.id">
                        <td>{{ announcement_history.id }}</td>
                        <td>{{ announcement_history.title }}</td>
                        <td>{{ announcement_history.course }}</td>
                        <td>{{ announcement_history.user }}</td>
                        <td>{{ dayjs(announcement_history.created_at).format('DD-MM-YYYY HH:mm') }}</td>
                        <td>{{ dayjs(announcement_history.updated_at).format('DD-MM-YYYY HH:mm') }}</td>
                        <td>
                            <span v-if="announcement_history.status == 'Ενεργή'" class="badge bg-success">{{ announcement_history.status }}</span>
                            <span v-else-if="announcement_history.status == 'Διαγραμμένη'" class="badge bg-danger">{{ announcement_history.status }}</span>
                        </td>
                        <td>
                            <Link :href="route('announcement-histories.show',announcement_history.id)" class="btn btn-primary me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="announcement_history?.length === 0">
                        <td colspan="7">Δεν υπάρχει ιστορικό ανακοινώσεων</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <Link v-for="link in announcement_histories.links" :key="link.label" v-html="link.label" v-bind="link.url ? { href: link.url } : {}"
                    :class="[
                        'btn me-2',
                        link.active ? 'btn-primary fw-bold' : 'btn-light',
                        !link.url && 'disabled'
                    ]"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link, router } from '@inertiajs/vue3';
    import dayjs from 'dayjs';
    import { ref } from 'vue';
    import filterAnnouncements from '../filters/filterAnnouncements.vue';

    defineProps({
        announcement_histories:{
            type: Object,
            required: true
        },
        courses:{
            type: Object,
            required: true
        },
        instructor_admins:{
            type: Object,
            required: true
        }
    });

    const showFilterAnnouncement = ref(false);
    const showFilters = ref(false);

    function searchFilterAnnouncement(announcement_filters){
        router.get('/announcement-histories',announcement_filters,{
            preserveState: true,
            replace: true,
            onFinish: () => showFilters.value = false
        });
    }

    function resetFilterAnnouncement(){
        router.get('/announcement-histories',{},{
            preserveState: true,
            replace: true,
            onFinish: () => showFilters.value = false
        });
    }
</script>
