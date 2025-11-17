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
    email: localStorage.getItem('rememberedEmail') || '',
    password: localStorage.getItem('rememberedPassword') || '',
    remember: !!localStorage.getItem('rememberedEmail')
});

const submit = () => {
    if(form.remember){
        localStorage.setItem('rememberedEmail', form.email);
        localStorage.setItem('rememberedPassword', form.password);
    }else{
        localStorage.removeItem('rememberedEmail');
        localStorage.removeItem('rememberedPassword');
    }

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

        <div v-if="errorStatus" class="mb-4 text-sm font-medium text-red-600">
            {{ errorStatus }}
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

              <p v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</p>
            </div>

            <div class="mt-4">
                <input type="checkbox" id="remember" v-model="form.remember">
                <label>Remember Me</label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Forgot your password?
                </Link>

                <button type="submit" class="btn btn-secondary ms-4 me-3" :class="{ 'opacity-25': form.processing }":disabled="form.processing">Log in</button>
                <Link :href="route('register')" class="btn btn-primary">Register</Link>
            </div>
        </form>
    </GuestLayout>
</template>
