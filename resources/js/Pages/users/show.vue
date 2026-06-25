<template>
    <div>
        <AuthenticatedLayout>
            <div class="container mt-2">
                <div class="row text-center">
                    <h3>Προβολή Χρήστη</h3>
                </div>
                <hr>
                <div class="row mt-4 mb-4">
                    <div class="col">
                        <Link class="btn btn-primary">Στατιστικά</Link>
                    </div>
                    <div class="col text-end">
                        <Link :href="route('users.index')" class="btn btn-primary text-end">Επιστροφή</Link>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Όνομα:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="user.name" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="user.email" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Ρόλος:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="user.role" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Ημερομηνία Δημιουργίας:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="dayjs(user.created_at).format('DD-MM-YYYY')" disabled>
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <h4>Εγγεγραμένα Μαθήματα</h4>
                </div>
                <hr>
                <table class="table table-striped mb-4">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Τίτλος</th>
                            <th>Εικόνα</th>
                            <th>Ημερομηνιά Δημιουργίας</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="course in registered_courses.data" :key="course.id">
                            <td>{{ course.id }}</td>
                            <td>{{ course.title }}</td>
                            <td>
                                <img v-if="course.image" height="80" width="80" :src="`/storage/${course.image }`" />
                            </td>
                            <td>{{ dayjs(course.created_at).format("DD-MM-YYYY HH:mm:ss") }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                    <Link v-for="link in registered_courses.links" :key="link.label" v-html="link.label" v-bind="link.url ? { href: link.url } : {}"
                        :class="[
                            'btn me-2',
                            link.active ? 'btn-primary fw-bold' : 'btn-light',
                            !link.url && 'disabled'
                        ]"
                    />
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
        user:{
            type: Object,
            required:true
        },
        registered_courses:{
            type: Object,
            required:true
        }
    });
</script>
