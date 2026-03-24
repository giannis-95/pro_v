<template>
    <div>
        <AuthenticatedLayout>
            <div class="container mt-2">
                <div class="row text-center">
                    <h3>Προβολή Ιστορικού Χρήστη</h3>
                </div>
                <hr>
                <div class="row text-end mt-4 mb-4">
                    <div class="col">
                        <Link :href="route('user-histories.index')" class="btn btn-primary">Επιστροφή</Link>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Όνομα:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="user_history.name" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="user_history.email" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Ρόλος:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="user_history.role" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Ημερομηνία δημιουργίας:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="dayjs(user_history.created_at).format('DD-MM-YYYY HH:mm:ss')" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Ημερομηνία Επεξεργασίας:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="dayjs(user_history.updated_at).format('DD-MM-YYYY HH:mm:ss')" disabled>
                    </div>
                </div>
                 <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Κατάσταση:</label>
                    <div class="col-sm-10 mt-2">
                        <span v-if="user_history.status == 'Ενεργός'" style="color: green; margin-top: 20px;">{{ user_history.status }}</span>
                        <span v-else-if="user_history.status == 'Μη Ενεργός'" style="color: #17a2b8; margin-top: 20px;">{{ user_history.status }}</span>
                        <span v-else style="color: red;">{{ user_history.status }}</span>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';
    import dayjs from 'dayjs';

    defineProps({
        user_history:Object,
        require:true
    })
</script>
