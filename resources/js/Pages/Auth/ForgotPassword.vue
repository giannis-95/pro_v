<template>
    <GuestLayout>
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <form @submit.prevent="submit">
            <div>
                <label for="email" value="Email">Email</label>
                <input type="email" class="block w-full form-control" v-model="form.email" required autofocus autocomplete="username"/>
                <p v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</p>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="btn btn-secondary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Email Password Reset Link</button>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
