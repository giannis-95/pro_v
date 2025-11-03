<template>
    <AuthenticatedLayout>
        <div>
            <div class="container mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="course in courses.data" :key="course.id">
                            <td>
                                <Link href="route('course.unregistration_course', course.id)" class="btn btn-danger" disabled>Απεγραφή</Link>
                            </td>
                            <td>{{ course.title }}</td>
                            <td>
                                <img v-if="course.image" :src="`/storage/${course?.image}`" height="70" width="70" />
                            </td>
                            <td>{{ dayjs(course.created_at).format("DD-MM-YYYY HH:mm:ss") }}</td>
                        </tr>

                        <tr v-if="courses?.length === 0">
                            <td colspan="5" style="text-align: center;">Δεν υπάρχουν μαθήματα</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                    <Link v-for="link in courses.links" :key="link.label" v-html="link.label" v-bind="link.url ? { href: link.url } : {}"
                        :class="[
                            'btn me-2',
                            link.active ? 'btn-primary fw-bold' : 'btn-light',
                            !link.url && 'disabled'
                        ]"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';
    import dayjs from 'dayjs';

    const props = defineProps({
        courses: Object,
    });
</script>
