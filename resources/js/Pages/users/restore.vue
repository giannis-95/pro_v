<template>
    <div>
        <div class="modal fade" id="restoreUserModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Επαναφορά Χρήστη</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Είσαι σίγουρος ότι θέλεις να επαναφέρεις τον χρήστη <strong>{{ user?.name}}</strong> από την εφαρμογή ;
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ακύρωση</button>
                        <button type="submit" class="btn btn-primary" @click="$emit('restore-user', user)">Επαναφορά</button>
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

    const emit = defineEmits(['restore-user']);
</script>


<style scoped>
    #restoreUserModal .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }
</style>

