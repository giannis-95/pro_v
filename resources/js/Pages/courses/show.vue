<template>
    <AuthenticatedLayout>
        <form method="POST">
            <div class="container mt-2">
                <div class="row text-center">
                    <h3>Προβολή Μαθηματος</h3>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <Link :href="route('courses.index')" class="btn btn-primary">Επιστροφή</Link>
                    </div>
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="course.title" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <img v-if="course.image" :src="`/storage/${course?.image}`" height="200px" width="200px">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                       <textarea class="form-control" rows="4" :value="course.description" disabled></textarea>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        course: Object
    });
</script>
