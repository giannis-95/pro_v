<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <label>Email</label>

                <input
                    type="email"
                    class="block w-full form-control"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <label class="mt-2" :message="form.errors.email"></label>
            </div>

            <div class="mt-4">
                <label>Password</label>

                <input
                    type="password"
                    class="block w-full form-control"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <label class="mt-2" :message="form.errors.password"></label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Forgot your password?
                </Link>

                <button type="submit" class="btn btn-secondary ms-4" :class="{ 'opacity-25': form.processing }":disabled="form.processing">Log in</button>
            </div>
        </form>
    </GuestLayout>
</template>
