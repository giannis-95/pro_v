<template>
    <AuthenticatedLayout>
        <div class="container mt-4">
            <div v-if="successMessage" class="alert alert-success">
                {{ successMessage }}
            </div>
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary" @click="show_announcement_filters =! show_announcement_filters">
                        {{ show_announcement_filters ? 'Κλείσιμο Φίλτρων' : 'Φίλτρα' }}
                    </button>
                    <FilterAnnouncements v-if="show_announcement_filters" @search="searchFilters" @reset="resetFilters" :courses="courses" :users="users"></FilterAnnouncements>
                    <Link v-if="user_role === 'Διαχειριστής'" :href="route('announcements.create')" class="btn btn-primary ml-2">Δημιουργία Ανακοίνωσης</Link>
                    <Link v-if="user_role === 'Διαχειριστής'" :href="route('announcement-histories.index')" class="btn btn-primary ml-2">Ιστορικό Ανακοινώσεων</Link>
                    <Link class="btn btn-secondary ml-2">Εκτύπωση Excel</Link>
                    <Link class="btn btn-danger ml-2">Εκτύπωση Pdf</Link>
                </div>
            </div>
            <div style="margin-top: 20px;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Τίτλος</th>
                            <th>Μάθημα</th>
                            <th>Καθηγητής</th>
                            <th>Ημερομηνία Δημιουργίας</th>
                            <th>Ημερομηνία Ενημέρωσης</th>
                            <th>Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="announcement in announcements">
                            <td>{{ announcement.id }}</td>
                            <td>{{ announcement.title }}</td>
                            <td>{{ announcement.course.title }}</td>
                            <td>{{ announcement.user.name }}</td>
                            <td>{{ dayjs(announcement.created_at).format("DD-MM-YYYY HH:mm:ss") }}</td>
                            <td>{{ dayjs(announcement.updated_at).format("DD-MM-YYYY HH:mm:ss") }}</td>
                            <td>
                                <Link :href="route('announcements.show' , announcement.id)" class="btn btn-primary me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg>
                                </Link>

                                <Link :href="route('announcements.edit', announcement.id)" class="btn btn-secondary me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                    </svg>
                                </Link>

                                <button @click="openModal(announcement)" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0
                                    0 0-1 0v6a.5.5 0 0 0 1 0V6z" /> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" /> </svg>
                                </button>
                            </td>
                        </tr>
                        <DeleteAnnouncement @confirm-delete="deleteAnnouncement" :announcement="announcement_delete"></DeleteAnnouncement>

                        <tr v-if="announcements?.length === 0">
                            <td colspan="7" style="text-align: center;">Δεν Υπάρχουν Ανακοίνωσεις</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import { Modal } from 'bootstrap';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link , router } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import FilterAnnouncements from '../filters/filterAnnouncements.vue';
    import dayjs from 'dayjs';
    import DeleteAnnouncement from '@/Pages/announcements/delete.vue';

    defineProps({
        announcements:{
            type: Object,
            required: true
        },
        courses:{
            type: Object,
            required:true
        },
        users:{
            type: Object,
            required:true
        },
        user_role:{
            type: String,
            required:true
        },
        successMessage:{
            type: String,
            default: ''
        }
    });

    const show_announcement_filters = ref(false);
    const announcement_delete = ref(null);

    function searchFilters(announcement){
        router.get(route(`announcements.index`),announcement,{
            preserveState:true,
            replace:true
        });
    }

    function resetFilters(){
        router.get(route(`announcements.index`),{});
    }

    function openModal(announcement){
        announcement_delete.value = announcement;
        const delete_announcement_modal = document.getElementById("deleteAnnouncement");
        const modal = new Modal(delete_announcement_modal)
        modal.show();
    }

    function deleteAnnouncement(announcement){
        const delete_announcement_modal = document.getElementById("deleteAnnouncement");
        const announcement_modal_instance = Modal.getInstance(delete_announcement_modal) || new Modal(delete_announcement_modal);
        announcement_modal_instance.hide();

        router.delete(route(`announcements.destroy`,{ announcement: announcement.id}));
    }
</script>
