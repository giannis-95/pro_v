<template>
   <div class="modal fade" id="deleteNotification" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Διαγραφή Ειδοποιήσης</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Είσαι σίγουρος ότι θέλεις να διαγράψεις την ειδοποιήση με τίτλο : <strong>{{ notification?.title }}</strong>;
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Ακύρωση</button>
                    <button class="btn btn-danger" @click="$emit('confirm-delete', notification)">Διαγραφή</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        notification:{
            type:Object,
            required:true
        }
    });

    const emit = defineEmits(['confirm-delete']);
</script>

<style>
    #deleteNotification .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }
</style>
