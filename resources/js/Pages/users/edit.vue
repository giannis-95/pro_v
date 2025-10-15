<template>
    <div>
        <AuthenticatedLayout>
            <form @submit.prevent="submit" method="POST">
                <div class="container mt-2">
                    <div class="row text-center">
                        <h3>Επεξεργασία Χρήστη</h3>
                    </div>
                    <hr>
                    <div v-if="edit_user.hasErrors" class="alert alert-danger">
                        <ul class="mb-0">
                            <li v-for="(errorMessages, field) in create_user.errors" :key="field">
                                {{ errorMessages }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" v-model="edit_user.name">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" v-model="edit_user.email">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" v-model="edit_user.password">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" v-model="edit_user.password_confirmation">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Ρόλος</label>
                        <div class="col-sm-10">
                            <select class="form-control" v-model="edit_user.role">
                                <option value="">Επιλέξτε ρόλο του χρήστη...</option>
                                <option value="Φοιτητής">Φοιτητής</option>
                                <option value="Καθηγητής">Καθηγητής</option>
                                <option value="Διαχειριστής">Διαχειριστής</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Updated at</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" :value="dayjs(edit_user.updated_at).format('DD-MM-YYYY HH:mm:ss')" disabled>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <button type="submit" class="btn btn-primary me-2">Αποθήκευση</button>
                            <Link :href="route('users.index')" class="btn btn-danger">Ακύρωση</Link>
                        </div>
                    </div>
                </div>
            </form>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link, useForm } from '@inertiajs/vue3';
    import dayjs from 'dayjs';

    const props = defineProps({
        user: Object
    });

    const edit_user = useForm({
        name: props.user.name,
        email: props.user.email,
        password: props.user.password,
        password_confirmation: props.user.password_confirmation,
        role: props.user.role
    });

    function submit(){
        edit_user.put(`/users/${props.user.id}`);
    }
</script>
