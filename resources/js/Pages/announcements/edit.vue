<template>
    <AuthenticatedLayout>
        <div class="container mt-2">
            <div class="row text-center">
                <h3>Ενημέρωση Ανακοίνωσης</h3>
            </div>
            <hr>
            <form @submit.prevent="submit" method="POST">
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Τίτλος</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="update_announcement.title">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Μάθημα</label>
                    <div class="col-sm-10">
                        <select class="form-control" v-model="update_announcement.course_id">
                            <option v-for="course in courses_user" :key="course.id" :value="course.id">{{ course.title }}</option>
                        </select>
                    </div>
                </div>
                    <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Καθηγητής</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="announcement.user.name" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Αρχείο</label>
                    <div class="col-sm-10">
                        <div v-if="announcement.file">
                            <a :href="route('announcements.download-file', announcement.id)">Κατέβασμα Αρχείου</a>
                            <input type="file" class="form-control" @change="handleFileChange">
                        </div>
                        <div v-else>
                            Δεν υπάρχει αρχείο
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Μήνυμα</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="4" v-model="update_announcement.message">{{ announcement.message }}</textarea>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <button type="submit" class="btn btn-primary me-2">Ενημέρωση</button>
                        <Link :href="route('announcements.index')" class="btn btn-danger">Ακύρωση</Link>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link , useForm, router } from '@inertiajs/vue3';

    const props = defineProps({
        announcement:{
            type: Object,
            required:true
        },
        courses_user:{
            type: Object,
            required:true
        }
    });

    const update_announcement = useForm({
        title: props.announcement.title,
        course_id: props.announcement.course_id,
        file: props.announcement.file,
        message: props.announcement.message
    });

    function handleFileChange(event) {
        update_announcement.file = event.target.files[0];
    }

    function submit(){
        router.put(route('announcements.update', {
            announcement: props.announcement.id
        }),
            update_announcement
        );

    }
</script>
