<template>
    <div>
        <AuthenticatedLayout>
            <form @submit.prevent="submit" method="POST">
                <div class="container mt-2">
                    <div class="row text-center">
                        <h3>Δημιουργία Χρήστη</h3>
                    </div>
                    <hr>
                    <div v-if="create_user.hasErrors" class="alert alert-danger">
                        <ul class="mb-0">
                            <li v-for="(errorMessages, field) in create_user.errors" :key="field">
                                {{ errorMessages }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" v-model="create_user.name">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" v-model="create_user.email">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" v-model="create_user.password">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" v-model="create_user.password_confirmation">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <button type="submit" class="btn btn-primary me-2">Δημιουργία</button>
                            <Link :href="route('users.index')" class="btn btn-danger">Ακύρωση</Link>
                        </div>
                    </div>
                </div>
            </form>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link,useForm } from '@inertiajs/vue3';

    const create_user = useForm({
        name:'',
        email:'',
        password:'',
        password_confirmation:''
    });

    const props = defineProps({
        errorMessage: {
            type: String,
            default: ''
        }
    });

    function submit() {
        create_user.post(route('users.store'));
    }
</script>
