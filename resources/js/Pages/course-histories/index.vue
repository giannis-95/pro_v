<template>
    <AuthenticatedLayout>
        <div class="container">
            <div class="row text-center mt-4">
                <h3>Ιστορικό Μαθημάτων</h3>
            </div>
            <hr>
            <div class="row text-end">
                <div class="col">
                    <Link :href="route('courses.index')" class="btn btn-primary">Πίσω</Link>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3 mb-3">
                    <button type="button" class="btn btn-primary" @click="showFilterCourse =! showFilterCourse">
                        {{ showFilterCourse ? 'Κλείσιμο Φίλτρων' : 'Φίλτρα'}}
                    </button>
                    <filterCourses v-if="showFilterCourse" @reset="resetFilterCourse" @search="searchFilterCourse">
                        <template #courseStatus="{ filters }">
                            <div class="row mt-4">
                                <div class="col">
                                    <div class="row">
                                        <label class="col-3 col-form-label">Κατάσταση Μαθήματος:</label>
                                        <div class="col-9">
                                            <select class="form-control" v-model="filters.status">
                                                <option value="">Επιλεξτε Κατάσταση...</option>
                                                <option value="Ενεργό">Ενεργό</option>
                                                <option value="Μη Ενεργό">Μη Ενεργό</option>
                                                <option value="Διεγεγραμένο">Διεγεγραμένο</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </filterCourses>
                    <Link class="btn btn-secondary ml-2">Εκτύπωση Excel</Link>
                    <Link class="btn btn-danger ml-2">Εκτύπωση Pdf</Link>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Τίτλος</th>
                        <th>Εικόνα</th>
                        <th>Ημερομηνια Δημιουργίας</th>
                        <th>Ημερομηνια Επεξεργασίας</th>
                        <th>Κατάσταση Μαθήματος</th>
                        <th>Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="course_history in course_histories.data" :key="course_history.id">
                        <td>{{ course_history.id }}</td>
                        <td>{{ course_history.title }}</td>
                        <td>
                            <img v-if="course_history.image" :src="`/storage/${course_history.image}`" height="80" width="80">
                             <p v-else>-</p>
                        </td>
                        <td>{{ dayjs(course_history.created_at).format('DD-MM-YYYY') }}</td>
                        <td>{{ dayjs(course_history.updated_at).format('DD-MM-YYYY') }}</td>
                        <td>
                            <span v-if="course_history.status == 'Ενεργό'" class="badge bg-success">{{ course_history.status }}</span>
                            <span v-else-if="course_history.status == 'Μη Ενεργό'" class="badge bg-info">{{ course_history.status }}</span>
                            <span v-else class="badge bg-danger">{{ course_history.status }}</span>
                        </td>
                        <td>
                            <Link  :href="route('course-histories.show', { course_history: course_history.id })"class="btn btn-primary me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="course_histories?.lenght === 0">
                        <td colspan="7" style="text-align: center;">Δεν υπάρχει Ιστορικό μαθημάτων</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <Link v-for="link in course_histories.links" :key="link.label" v-html="link.label" v-bind="link.url ? { href: link.url } : {}"
                    :class="[
                        'btn me-2',
                        link.active ? 'btn-primary fw-bold' : 'btn-light',
                        !link.url && 'disabled'
                    ]"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link,router } from '@inertiajs/vue3';
    import dayjs from 'dayjs';
    import { ref } from 'vue';
    import filterCourses from '../filters/filterCourses.vue';

    defineProps({
        course_histories: Object,
        required:true
    });

    const showFilterCourse = ref(false);
    const showFilters = ref(null);

    function searchFilterCourse(filters){
        router.get('/course-histories',filters,{
            preserveState: true,
            replace: true,
            onFinish: () => showFilters.value = false
        });
    }

    function resetFilterCourse(){
        router.get('/course-histories',{},{
            onFinish: () => showFilters.value = false
        });
    }
</script>
