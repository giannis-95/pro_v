<template>
    <AuthenticatedLayout>
        <div class="container">
            <div v-if="successMessage" class="alert alert-success">
                {{ successMessage }}
            </div>
            <div v-if="$page.props.errors.unauthorizedAction" class="alert alert-danger">
                {{ $page.props.errors.unauthorizedAction }}
            </div>
            <div class="row">
                <div class="col mt-3 mb-3">
                     <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Φίλτρα
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 1400px;height: 250px;">
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <label class="col-3 col-form-label">Όνομα Χρήστη:</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" v-model="filters.name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <label class="col-3 col-form-label">Ρόλος Χρήστη:</label>
                                        <div class="col-9">
                                            <select class="form-control" v-model="filters.role">
                                                <option value="">Επιλεξτε Ρόλο...</option>
                                                <option value="Φοιτητής">Φοιτητής</option>
                                                <option value="Καθηγητής">Καθηγητής</option>
                                                <option value="Διαχειριστής">Διαχειριστής</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col col-form-label col-sm-3 col-md-3 col-lg-3">
                                    <label>Ημερομηνία Δημιουργίας Χρήστη</label>
                                </div>
                                <div class="col-sm-9 col-md-9 col-lg-9">
                                    <div class="row">
                                        <label class="col col-form-label">Από :</label>
                                        <div class="col-5">
                                            <input type="date" class="form-control" v-model="filters.from_date">
                                        </div>
                                        <label class="col col-form-label">Εως :</label>
                                        <div class="col-5">
                                            <input type="date" class="form-control" v-model="filters.to_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-6">
                                    <button @click="applyFilters()" class="btn btn-primary">Αναζήτηση</button>
                                </div>
                                <div class="col-6 text-end">
                                    <button @click="resetFilters()" class="btn btn-danger" >Καθαρισμός</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3 mb-3">
                    <Link :href="route('users.create')" class="btn btn-primary">Δημιουργία Χρήστη</Link>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Ρόλος</th>
                        <th>Created at</th>
                        <th>Κατάσταση</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>
                        <td>{{ dayjs(user.created_at).format('DD-MM-YYYY HH:mm:ss') }}</td>
                        <td>
                            <span v-if="user.is_deleted" class="badge bg-danger">Διαγραμμένος</span>
                            <span v-else class="badge bg-success">Ενεργός</span>
                        </td>
                        <td>
                            <Link v-if="!user.is_deleted" :href="route('users.show',user.id)" class="btn btn-primary me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </Link>

                            <Link v-if="!user.is_deleted" :href="route('users.edit',user.id)" class="btn btn-secondary me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                </svg>
                            </Link>

                            <button v-if="user.role != 'Διαχειριστής' && !user.is_deleted" @click="openDeleteModal(user)" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0
                                0 0-1 0v6a.5.5 0 0 0 1 0V6z" /> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" /> </svg>
                            </button>

                            <div v-else-if="user.is_deleted">
                                <button @click="openModalRestoreUser(user)" class="btn btn-dark btn-sm">Επαναφορά</button>
                                <button @click="openModalFinalDeleteUser(user)" class="btn btn-info btn-sm" style="margin-left: 5px;">Οριστική Διαγραφή</button>
                            </div>
                        </td>
                    </tr>
                    <DeleteUser :user="userToDelete" :showModal="showModal" @close="showModal = false" @confirm-delete="deleteUser"></DeleteUser>

                    <RestoreUser :user="userToRestore" :show_restore_modal_user="show_restore_modal_user"
                        @close="show_restore_modal_user = false" @restore-user="restoreUser">
                    </RestoreUser>

                    <FinalDeletedUser :user="userToFinalDelete" :show_final_deleted_modal_user="show_final_deleted_modal_user"
                        @close="show_final_deleted_modal_user =false" @final-delete="finalDeleteUser">
                    </FinalDeletedUser>
                </tbody>
            </table>
            <div class="mt-4">
                <Link v-for="link in users.links" :key="link.label" v-html="link.label" v-bind="link.url ? { href: link.url } : {}"
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
    import { Link, router,usePage } from '@inertiajs/vue3';
    import dayjs from 'dayjs';
    import { ref , reactive } from 'vue';
    import DeleteUser from '@/Pages/users/delete.vue';
    import RestoreUser from '@/Pages/users/restore.vue';
    import FinalDeletedUser from '@/Pages/users/final-deleted.vue';
    import { computed } from 'vue';

    const showModal = ref(false);
    const show_restore_modal_user = ref(false);
    const show_final_deleted_modal_user = ref(false);

    const userToDelete = ref(null);
    const userToRestore = ref(null);
    const userToFinalDelete = ref(null);

    const page = usePage();

    const error = computed(() => page.props.errors.unauthorizedAction);

    const props = defineProps({
        users:Object,
        successMessage: {
            type: String,
            default: ''
        },
    });

    const filters = reactive({
        name: '',
        role: '',
        from_date: '',
        to_date: ''
    });

    function openDeleteModal(user){
        userToDelete.value = user;
        showModal.value = true;
    }

    function deleteUser(user){
        router.delete(`/users/${user.id}`)
        showModal.value = false;
    }

    function openModalRestoreUser(user){
        userToRestore.value = user;
        show_restore_modal_user.value = true;
    }

    function openModalFinalDeleteUser(user){
        userToFinalDelete.value = user;
        show_final_deleted_modal_user.value = true;
    }

    function restoreUser(user){
        router.get(`/user/${user.id}/restore`)
        show_restore_modal_user.value = true;
    }

    function finalDeleteUser(user){
        router.get(`/user/${user.id}/final_deleted`)
        show_final_deleted_modal_user.value = true;
    }

    function applyFilters() {
        router.get('/users', filters, {
            preserveState: true,
            replace: true
        });
    }

    function resetFilters() {
        filters.name = '';
        filters.role = '';
        filters.from_date = '';
        filters.to_date = '';
        applyFilters();
    }
</script>
