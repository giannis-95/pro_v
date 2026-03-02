<template>
    <div>
        <div class="modal fade" id="finalDeletedCourse" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Οριστική Διαγραφή Μαθήματος</h5>
                        <button type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        Είσαι σίγουρος ότι θέλεις να διαγράψεται οριστικά το μάθημα <strong>{{ course?.title }}</strong> από την εφαρμογή;
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary">Ακύρωση</button>
                        <button type="submit" class="btn btn-danger" @click="$emit('final-delete-course',course)">Οριστική Διαγραφή</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        course: Object,
    });

    const emit = defineEmits(['final-delete-course']);
</script>

<style >
    #finalDeletedCourse .modal-content {
        background: transparent; /* αφαιρεί λευκό background */
        border: none;            /* αφαιρεί πλαίσιο */
        box-shadow: none;        /* αφαιρεί τυχόν σκιά */
    }
</style>
