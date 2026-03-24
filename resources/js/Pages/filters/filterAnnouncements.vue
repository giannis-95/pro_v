<template>
    <div class="card mb-4">
        <div class="row">
            <div class="col">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <label class="col-3 col-form-label">Τίτλος:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" v-model="announcement_filters.title">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <div class="row">
                                <label class="col-3 col-form-label">Μάθημα:</label>
                                <div class="col-9">
                                    <select class="form-control" v-model="announcement_filters.course">
                                        <option>Επιλέξτε Μάθημα...</option>
                                        <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.title }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <label class="col-3 col-form-label">Καθηγητής:</label>
                                <div class="col-9">
                                    <select class="form-control" v-model="announcement_filters.user">
                                        <option>Επιλέξτε Καθηγητή...</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col col-form-label col-sm-3 col-md-3 col-lg-3">
                            <label>Ημερομηνία Δημιουργίας Ανακοίνωσης</label>
                        </div>
                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <div class="row">
                                <label class="col col-form-label">Από :</label>
                                <div class="col-5">
                                    <input type="date" class="form-control" v-model="announcement_filters.date_from">
                                </div>
                                <label class="col col-form-label">Εως :</label>
                                <div class="col-5">
                                    <input type="date" class="form-control" v-model="announcement_filters.date_to">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mb-4">
                        <div class="col-6">
                            <button type="button" class="btn btn-primary" @click="searhFilter">Αναζήτηση</button>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-danger" @click="resertFilter">Καθαρισμός</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive } from 'vue';

    defineProps({
        courses:{
            type: Object,
            required:true
        },
        users:{
            type: Object,
            required:true
        }
    });

    const emit = defineEmits(['search','reset']);

    const announcement_filters = reactive({
        title: '',
        course: '',
        user: '',
        date_to: '',
        date_from: ''
    });

    function resertFilter(){
        announcement_filters.title = '',
        announcement_filters.course = '',
        announcement_filters.user = '',
        announcement_filters.date_from = '',
        announcement_filters.date_to = ''
        emit('reset');
    }

    function searhFilter(){
        emit('search', {...announcement_filters});
    }
</script>
