<template>
    <AuthenticatedLayout>
        <form method="POST">
            <div class="container mt-2">
                <div class="row text-center">
                    <h3>Επεξεργασία Μαθηματος</h3>
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="" >
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="" >
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                       <textarea class="form-control" rows="4" name=""></textarea>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <button type="submit" class="btn btn-primary me-2">Αποθήκευση</button>
                        <Link :href="route('courses.index')" class="btn btn-danger">Ακύρωση</Link>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';
</script>
