<template>
    <AuthenticatedLayout>
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col text-center">
                    <h4>Οι Ειδοποιήσεις μου</h4>
                </div>
            </div>
            <div v-if="successMessage" class="alert alert-success">
                {{ successMessage }}
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Τίτλος</th>
                        <th>Μύνημα</th>
                        <th>Ημερομηνία Δημιουργίας</th>
                        <th>Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="notification in notifications.data" :key="notification.id">
                        <td>{{ notification.data.title }}</td>
                        <td>{{ notification.data.message }}</td>
                        <td>{{ notification.data.created_at }}</td>
                        <td>
                            <button @click="openModal(notification)" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0
                                0 0-1 0v6a.5.5 0 0 0 1 0V6z" /> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" /> </svg>
                            </button>
                        </td>
                    </tr>

                    <DeleteNotification @confirm-delete="deleteNotification" :notification="delete_notification"></DeleteNotification>
                </tbody>
            </table>

            <div class="mt-4">
                <Link v-for="link in notifications.links" :key="link.label" v-html="link.label" v-bind="link.url ? { href: link.url } : {}"
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
    import { Link ,router } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import { Modal } from 'bootstrap';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import DeleteNotification from '@/Pages/notifications/delete.vue';

    defineProps({
        notifications:{
            type: Object,
            required: true
        },
        successMessage:{
            type: String,
            default: ''
        }
    });

    const delete_notification = ref(null);

    function openModal(notification){
        delete_notification.value = notification
        const modal = new Modal(document.getElementById('deleteNotification'));
        modal.show();
    }

    function deleteNotification(notification){
        const delete_notification_modal = document.getElementById('deleteNotification');
        const delete_ntofication_modal_instance = Modal.getInstance(delete_notification_modal) || new Modal(delete_notification_modal);
        delete_ntofication_modal_instance.hide();

       router.delete(route('notifications.destroy',{ notification:notification.id }));
    }
</script>
