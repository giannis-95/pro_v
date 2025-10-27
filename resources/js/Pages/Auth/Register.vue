<template>
    <GuestLayout>
        <h1>Register</h1>

        <form @submit.prevent="submit">
            <p v-if="form.errors.status" class="text-red-600 text-sm mt-1">{{ form.errors.status }}</p>
            <div>
                <label>Name</label>

                <input
                    type="text"
                    class="block w-full form-control"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <label class="mt-2" :message="form.errors.name"></label>
            </div>

            <div class="mt-4">
                <label>Email</label>

                <input
                    type="email"
                    class="block w-full form-control"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <label class="mt-2" :message="form.errors.email"></label>
            </div>

            <div class="mt-4">
                <label>Password</label>

                <input
                    id="password"
                    type="password"
                    class="block w-full form-control"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <label class="mt-2" :message="form.errors.password"></label>
            </div>

            <div class="mt-4">
                <label>Confirm Password</label>

                <input
                    type="password"
                    class="block w-full form-control"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <label class="mt-2" :message="form.errors.password_confirmation"></label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link :href="route('login')" class="rounded-md text-sm text-gray-600 underline
                    hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Already registered?</Link>

                <button class="btn btn-secondary ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Register</button>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    status: ''
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
