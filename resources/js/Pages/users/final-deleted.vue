<template>
    <div>
        <div class="modal fade" id="finalDeleteUserModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Οριστική Διαγραφή Χρήστη</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Είσαι σίγουρος ότι θέλεις να διαγράψεται οριστικά τον χρήστη <strong>{{ user?.name}}</strong> από την εφαρμογή;
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ακύρωση</button>
                        <button type="submit" class="btn btn-danger" @click="$emit('final-delete', user)">Οριστική Διαγραφή</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        user: Object,
    });

    const emit = defineEmits(['final-delete']);
</script>


<style>
    #finalDeleteUserModal .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }
</style>

