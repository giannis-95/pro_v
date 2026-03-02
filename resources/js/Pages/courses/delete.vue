<template>
    <div>
        <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Διαγραφή Μαθηματος</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Είσαι σίγουρος ότι θέλεις να διαγράψεις το μάθημα {{ course?.title }};
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"data-bs-dismiss="modal">Ακύρωση</button>
                        <button type="submit" class="btn btn-danger" @click="$emit('confirm-delete',course)">Διαγραφή</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop" v-if="showModal"></div>
    </div>
</template>

<script setup>
    const props = defineProps({
        course:Object,
    });

    const emit = defineEmits(['close','confirm-delete']);
</script>


<style>
    #deleteCourseModal .modal-content {
        background: transparent; /* αφαιρεί λευκό background */
        border: none;            /* αφαιρεί πλαίσιο */
        box-shadow: none;        /* αφαιρεί τυχόν σκιά */
    }
</style>
