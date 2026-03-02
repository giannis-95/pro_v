<template>
    <div>
        <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Διαγραφή Χρήστη</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Είσαι σίγουρος ότι θέλεις να αφαιρέσεις τον χρήστη <strong>{{ user?.name }}</strong>;
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Ακύρωση</button>
                        <button class="btn btn-danger" @click="$emit('confirm-delete', user)">Διαγραφή</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        user: Object
    });

    defineEmits(['confirm-delete']);
</script>

<style>
    #deleteUserModal .modal-content {
        background: transparent; /* αφαιρεί λευκό background */
        border: none;            /* αφαιρεί πλαίσιο */
        box-shadow: none;        /* αφαιρεί τυχόν σκιά */
    }
</style>

