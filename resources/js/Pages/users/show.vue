<template>
    <div>
        <AuthenticatedLayout>
            <div class="container mt-2">
                <div class="row text-center">
                    <h3>Προβολή Χρήστη</h3>
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" :value="user.name" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" :value="user.email" disabled>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <Link :href="route('users.index')" class="btn btn-primary">Επιστροφή</Link>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        user: Object
    });
</script>
