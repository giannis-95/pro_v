<template>
   <div class="modal fade" id="deleteAnnouncement" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Διαγραφή Ανακοίνωσης</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Είσαι σίγουρος ότι θέλεις να διαγράψεις την ανακοίνωση <strong>{{ announcement?.title }}</strong>;
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Ακύρωση</button>
                    <button class="btn btn-danger" @click="$emit('confirm-delete', announcement)">Διαγραφή</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        announcement:{
            type:Object,
            required:true
        }
    });

    const emit = defineEmits(['confirm-delete']);
</script>

<style>
    #deleteAnnouncement .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }
</style>
