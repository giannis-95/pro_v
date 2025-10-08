<template>
    <AuthenticatedLayout>
        <form @submit.prevent="saveCourse" method="POST" enctype="multipart/form-data">
            <div class="container mt-2">
                <div v-if="edit_course.hasErrors" class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="(errorMessage , field) in edit_course.errors" :key="field">
                            {{ errorMessage }}
                        </li>
                    </ul>
                </div>
                <div class="row text-center">
                    <h3>Επεξεργασία Μαθηματος</h3>
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" v-model="edit_course.title">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <img v-if="edit_course.image && typeof edit_course.image === 'string'" :src="`/storage/${edit_course.image}`" height="200px" width="200px">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="image" @change="handleImageUpload">
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
        description: props.course.description,
    });

    function handleImageUpload(event) {
        edit_course.image = event.target.files[0];
    }

    console.log(edit_course.hasErrors);

    function saveCourse() {
        edit_course.transform(data => {
            const formData = new FormData();
            formData.append('title', data.title);
            formData.append('description', data.description);

            if(data.image instanceof File){
                formData.append('image', data.image);
            }

            formData.append('_method', 'PUT');
            return formData;
        }).post(route('courses.update', props.course.id), {
            forceFormData: true,
        });
    }

</script>
