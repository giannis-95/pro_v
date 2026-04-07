<template>
    <AuthenticatedLayout>
        <div class="container">
            <div class="row text-center mt-4">
                <h3>Ιστορικό Χρηστών</h3>
            </div>
            <hr>
            <div class="row text-end">
                <div class="col">
                    <Link :href="route('users.index')" class="btn btn-primary">Πίσω</Link>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <button type="button" class="btn btn-primary" @click="user_history_filter =! user_history_filter">
                        {{ user_history_filter ? 'Κλείσιμο Φίλτρων' : 'Φίλτρα' }}
                    </button>
                    <filterUsers v-if="user_history_filter" @search="searchFilterUserHistory" @reset="resetFilterUserHistory">
                        <template #statusUser="{ filters }">
                            <div class="row mt-4">
                                <div class="col">
                                    <div class="row">
                                        <label class="col-3 col-form-label">Κατάσταση Χρήστη:</label>
                                        <div class="col-9">
                                            <select class="form-control" v-model="filters.status">
                                                <option value="">Επιλεξτε Κατάσταση...</option>
                                                <option value="Ενεργός">Ενεργός</option>
                                                <option value="Μη Ενεργός">Μη Ενεργός</option>
                                                <option value="Διεγεγραμένος">Διεγεγραμένος</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </filterUsers>
                    <Link class="btn btn-secondary ml-2">Εκτύπωση Excel</Link>
                    <Link class="btn btn-danger ml-2">Εκτύπωση Pdf</Link>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Όνομα</th>
                        <th>Email</th>
                        <th>Ρόλος</th>
                        <th>Ημερομηνία δημιουργίας</th>
                        <th>Ημερομηνία Επεξεργασίας</th>
                        <th>Κατάσταση</th>
                        <th>Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user_history in user_histories.data" :key="user_history.id">
                        <td>{{ user_history.id }}</td>
                        <td>{{ user_history.name }}</td>
                        <td>{{ user_history.email }}</td>
                        <td>{{ user_history.role }}</td>
                        <td>{{ dayjs(user_history.created_at).format('DD-MM-YYYY HH:mm:ss') }}</td>
                        <td>{{ dayjs(user_history.updated_at).format('DD-MM-YYYY HH:mm:ss') }}</td>
                        <td>
                            <span v-if="user_history.status == 'Ενεργός'" class="badge bg-success">{{ user_history.status }}</span>
                            <span v-else-if="user_history.status == 'Μη Ενεργός'" class="badge bg-info">{{ user_history.status }}</span>
                            <span v-else class="badge bg-danger">{{ user_history.status }}</span>
                        </td>
                        <td>
                            <Link :href="route('user-histories.show',user_history.id)" class="btn btn-primary me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="user_histories?.lenght === 0">
                        <td colspan="5" style="text-align: center;">Δεν υπάρχει Ιστορικό χρηστών</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <Link v-for="link in user_histories.links" :key="link.label" v-html="link.label" v-bind="link.url ? { href: link.url } : {}"
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
    import filterUsers from '@/Pages/filters/filterUsers.vue';
    import { ref } from 'vue';

    defineProps({
        user_histories:Object,
        required:true
    });

    const user_history_filter = ref(false);
    const showFilters = ref(null);

    function searchFilterUserHistory(filters){
        router.get(`/user-histories`,filters,{
            preserveState: true,
            replace: true,
            onFinish: () => showFilters.value = false
        });
    }

    function resetFilterUserHistory(){
        router.get(`/user-histories`,{},{
            onFinish: () => showFilters.value = false
        });
    }
</script>
