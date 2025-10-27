<template>
    <div>
        <div class="modal" :class="{ show: show_restore_modal_user }" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Επαναφορά Χρήστη</h5>
                        <button type="button" class="btn-close" @click="$emit('close')"></button>
                    </div>
                    <div class="modal-body">
                        Είσαι σίγουρος ότι θέλεις να επαναφέρεις τον χρήστη <strong>{{ user?.name}}</strong> από την εφαρμογή ;
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="$emit('close')">Ακύρωση</button>
                        <button type="submit" class="btn btn-primary" @click="$emit('restore-user', user)">Επαναφορά</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="show_restore_modal_user" class="modal-backdrop"></div>
    </div>
</template>

<script setup>
    const props = defineProps({
        user: Object,
        show_restore_modal_user: Boolean
    });

    const emit = defineEmits(['close', 'restore-user']);
</script>


<style scoped>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1050;
  display: none;
  width: 100%;
  height: 100%;
  overflow: hidden;
  outline: 0;
  background-color: rgba(0,0,0,0.5);
}

.modal.show {
  display: block;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1040;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
}
</style>

