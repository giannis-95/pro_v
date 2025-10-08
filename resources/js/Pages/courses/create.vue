<template>
    <AuthenticatedLayout>
        <form @submit.prevent="createCourse" method="POST" enctype="multipart/form-data">
            <div class="container mt-2">
                <div v-if="create_course.hasErrors" class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="(errorMessage , field) in create_course.errors" :key="field">
                            {{ errorMessage }}
                        </li>
                    </ul>
                </div>
                <div class="row text-center">
                    <h3>Δημιουργία Μαθηματος</h3>
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" v-model="create_course.title" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" @change="handleFileChange" name="image">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                       <textarea class="form-control" rows="4" name="description" v-model="create_course.description"></textarea>
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
    import { Link,useForm } from '@inertiajs/vue3';

    const create_course = useForm({
        title:'',
        image:'',
        description:''
    });


    function handleFileChange(event) {
        create_course.image = event.target.files[0];
    }

    function createCourse(){
        create_course.post(route('courses.store'), {
            forceFormData: true
        });
    }
</script>
