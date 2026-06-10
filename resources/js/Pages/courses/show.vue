<template>
    <AuthenticatedLayout>
        <div class="container mt-2">
            <div class="row text-center">
                <h3>Προβολή Μαθηματος</h3>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <Link v-if="(role == 'Διαχειριστής' || role == 'Καθηγητής') && registered_user"
                        :href="route('registered-students.index',course.id)" class="btn btn-primary me-2">
                        Έγγεγραμένοι Φοιτητές
                    </Link>
                    <button v-if="registered_user" class="btn btn-primary me-2" @click="buyCourse">Αγορά Μαθήματος</button>
                    <Link v-if="registered_user" class="btn btn-primary">Αξιολόγηση</Link>
                </div>
                <div class="col text-end">
                    <Link :href="route('courses.index')" class="btn btn-primary">Επιστροφή</Link>
                </div>
            </div>
            <hr>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Τίτλος</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" :value="course.title" disabled>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Εικόνα</label>
                <div class="col-sm-10">
                    <img v-if="course.image" :src="`/storage/${course?.image}`" height="200px" width="200px">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Περιγραφή</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="4" :value="course.description" disabled></textarea>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import axios from 'axios';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        course: Object,
        registered_user: Object,
        role: String
    });

    const buyCourse = async () => {
        try {
            const res = await axios.post('/api/buy-course', {
                course_id: props.course.id
            });

            window.location.href = res.data.url;
        } catch (error) {
            console.error(error);
            alert('Σφάλμα κατά τη δημιουργία της πληρωμής');
        }
    };
</script>
