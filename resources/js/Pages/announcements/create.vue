<template>
    <AuthenticatedLayout>
        <form @submit.prevent="submit" method="POST" enctype="multipart/form-data">
            <div class="container mt-2">
                <div class="row text-center">
                    <h3>Δημιουργία Ανακοίνωσης</h3>
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Τίτλος:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" v-model="create_announcement.title" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Μάθημα:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="course_id" v-model="create_announcement.course_id" required>
                            <option>Επιλέξτε μάθημα...</option>
                            <option v-for="course in courses" :key="course.id" :value="course.id">
                                {{ course.title }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Αρχείο:</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="file" @change="handleFile">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Μήνυμα:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="4" name="message" v-model="create_announcement.message"></textarea>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <button type="submit" class="btn btn-primary me-2">Αποθήκευση</button>
                        <Link :href="route('announcements.index')" class="btn btn-danger">Ακύρωση</Link>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link, useForm } from '@inertiajs/vue3';

    defineProps({
        courses:{
            type:Object,
            required:true
        }
    });

    const create_announcement = useForm({
        title:'',
        course_id:'',
        file:'',
        message:''
    });

    function handleFile(event){
        create_announcement.file = event.target.files[0];
    }

    function submit(){
        create_announcement.post(route('announcements.store'),{
            forceFormData:true
        });
    }
</script>
