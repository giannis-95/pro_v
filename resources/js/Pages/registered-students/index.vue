<template>
    <AuthenticatedLayout>
        <div class="container">
            <div class="row">
                <div class="col text-center mt-4 mb-2">
                    <h4>Έγγεγραμένοι Χρήστες</h4>
                </div>
            </div>
            <div class="row" v-if="successMessage">
                <div class="alert alert-success">
                    {{ successMessage }}
                </div>
            </div>
            <hr>
            <div class="row mt-2 mb-2">
                <div class="col-10">
                    <button class="btn btn-primary" @click="show_registered_students =! show_registered_students">
                        {{ show_registered_students ? 'Κλείσιμο Φίλτρων' : 'Φίλτρα' }}
                    </button>
                    <button class="btn btn-primary ml-2" @click="openAddStudentsModal">Προσθήκη Φοιτητών</button>
                    <button class="btn btn-secondary ml-2">Εξαγωγή σε Excel</button>
                    <button class="btn btn-danger ml-2">Εξαγωγή σε Pdf</button>
                </div>
                <div class="col-2 text-end">
                    <Link :href="route('courses.show',props.course.id)" class="btn btn-primary">Επιστροφή</Link>
                </div>
            </div>
            <FilterRegisterefStudents v-if="show_registered_students" @search="searchFilter" @reset="resetFilter"></FilterRegisterefStudents>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Όνομα</th>
                        <th>Email</th>
                        <th>Ρόλος</th>
                        <th>Ημερομηνία Δημιουργίας</th>
                        <th>Κατάσταση</th>
                        <th>Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="registered_student in registered_students.data" :key="registered_student.id">
                        <td>{{ registered_student.id }}</td>
                        <td>{{ registered_student.name }}</td>
                        <td>{{ registered_student.email }}</td>
                        <td>{{ registered_student.role }}</td>
                        <td>{{ dayjs(registered_student.created_at).format("DD-MM-YYYY") }}</td>
                        <td>
                            <span v-if="registered_student.is_deleted" class="badge bg-danger">Διαγραμμένος</span>
                            <span v-else class="badge bg-success">Ενεργός</span>
                        </td>
                        <td>
                            <button @click="openUnregistrationStudentModal" type="button" class="btn btn-danger" title="Απεγγραφή">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0
                                0 0-1 0v6a.5.5 0 0 0 1 0V6z" /> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" /> </svg>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="registered_students?.data?.length === 0">
                        <td colspan="7" style="text-align: center;">Δεν υπάρχουν εγγεγραμένοι φοιτητές</td>
                    </tr>
                </tbody>
                <AddStudents :students="students" :course="course" @confirm-add-students="storeStudents"/>
                <UnregistrationStudent :course="course" @confirm-unregistration="unregistrationStudents"/>
            </table>

            <div class="mt-4">
                <Link v-for="link in registered_students.links" :key="link.label" v-html="link.label" v-bind="link.url ? { href: link.url } : {}"
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
    import { ref } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import dayjs from 'dayjs';
    import { Link, router } from '@inertiajs/vue3';
    import { Modal } from 'bootstrap';
    import AddStudents from '@/Pages/registered-students/create.vue';
    import FilterRegisterefStudents from '@/Pages/filters/filterRegisterefStudents.vue';
    import UnregistrationStudent from '@/Pages/registered-students/unregistration.vue';

    const props = defineProps({
        registered_students:{
            type:Object,
            required:true
        },
        course:{
            type:Object,
            required:true
        },
        students:{
            type: Object,
            required:true
        },
        successMessage:{
            type: String,
            default:''
        }
    });

    const show_registered_students = ref(false);

    function searchFilter(filters){
        router.get(`/courses/${props.course.id}/registered-students`,filters,{
            preserveState: true,
            replace: true,
            onFinish: () => show_registered_students.value = false
        });
    }

    function resetFilter(){
        router.get(`/courses/${props.course.id}/registered-students`,{},{
            onFinish: () => show_registered_students.value = false
        });
    }

    function openAddStudentsModal(){
        const add_students_modal = new Modal(document.getElementById('addStudents'));
        add_students_modal.show();
    }

    function storeStudents(selected_students){
        const add_students_modal = document.getElementById('addStudents');
        const add_students_instance_modal = Modal.getInstance(add_students_modal) || new Modal(add_students_modal);
        add_students_instance_modal.hide();

        router.post(`/courses/${props.course.id}/store-students`,{
            students:selected_students
        });
    }

    function openUnregistrationStudentModal(){
        const unregistration_student_modal = new Modal(document.getElementById('unregistrationStudentModal'));
        unregistration_student_modal.show();
    }

    function unregistrationStudents(course){
        const unregistration_student_modal = document.getElementById('unregistrationStudentModal');
        const unregistration_student_instance_modal = Modal.getInstance(unregistration_student_modal) || new Modal(unregistration_student_modal);
        unregistration_student_instance_modal.hide();

        router.delete(`/courses/${course.id}/unregistered-students`,{
            course:course
        });
    }
</script>
