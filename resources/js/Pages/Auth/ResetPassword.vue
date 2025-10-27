<template>
    <GuestLayout>
        <h4 style="margin-bottom: 20px;">Reset Password</h4>

        <form @submit.prevent="submit">
            <div>
                <label for="email">Email</label>

                <input
                    id="email"
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
                <label for="password">Password</label>

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
                <label for="password_confirmation">Confirm Password</label>

                <input
                    id="password_confirmation"
                    type="password"
                    class="block w-full form-control"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <label class="mt-2" :message="form.errors.password_confirmation"></label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="btn btn-secondary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Reset Password</button>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
