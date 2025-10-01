<template>
    <AuthenticatedLayout>
        <form @submit.prevent="saveCourse" method="POST">
            <div class="container mt-2">
                <div class="row text-center">
                    <h3>Επεξεργασία Μαθηματος</h3>
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" v-model="edit_course.title" >
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <img :src="`/storage/${course?.image}`" v-if="edit_course.image" height="200px" width="200px">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="image" @change="uploadImage">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                       <textarea class="form-control" rows="4" name="description" v-model="edit_course.description"></textarea>
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
    import { Link, useForm } from '@inertiajs/vue3';

    const props = defineProps({
        course:Object
    });

    const edit_course = useForm({
        title:  props.course.title,
        image:  props.course.image,
        description: props.course.description
    });

    function uploadImage(event){
        edit_course.image = event.target.files[0];
    }

    function saveCourse(){
        edit_course.put(`/courses/${props.course.id}`),{
            forceFormData: true
        };
    }
</script>
