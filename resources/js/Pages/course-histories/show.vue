<template>
    <AuthenticatedLayout>
        <form method="POST">
            <div class="container mt-2">
                <div class="row text-center">
                    <h3>Προβολή Ιστορικού Μαθηματος</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-end">
                        <Link :href="route('course-histories.index')" class="btn btn-primary">Επιστροφή</Link>
                    </div>
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Τίτλος:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="course_history.title" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3 mt-3">
                    <label class="col-sm-2 col-form-label">Εικόνα:</label>
                    <div class="col-sm-10">
                        <img v-if="course_history.image" :src="`/storage/${course_history.image}`" height="500px" width="500px">
                        <p v-else>Δεν υπάρχει εικόνα</p>
                    </div>
                </div>
                <div class="form-group row mb-3 mt-3">
                    <label class="col-sm-2 col-form-label">Περιγραφή:</label>
                    <div class="col-sm-10">
                       <textarea class="form-control" rows="4" disabled>{{ course_history.description }}</textarea>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';

    defineProps({
        course_history: Object,
        require:true
    })
</script>
