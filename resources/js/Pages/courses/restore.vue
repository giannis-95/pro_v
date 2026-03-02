<template>
    <div>
        <div class="modal fade" id="restoreCourseModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Επαναφορά Μαθηματος</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Είσαι σίγουρος ότι θέλεις να επαναφέρεις το μάθημα <strong>{{ course?.title }}</strong> από την εφαρμογή ;
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ακύρωση</button>
                        <button type="submit" class="btn btn-primary" @click="$emit('restore-course',course)">Επαναφορά</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        course:Object,
    });

    const emit = defineEmits(['restore-course']);
</script>

<style>
    #restoreCourseModal .modal-content {
        background: transparent; /* αφαιρεί λευκό background */
        border: none;            /* αφαιρεί πλαίσιο */
        box-shadow: none;        /* αφαιρεί τυχόν σκιά */
    }
</style>
