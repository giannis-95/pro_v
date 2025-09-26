<template>
    <div>
        <div tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Διαγραφή Χρήστη</h5>
                        <button type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        Είσαι σίγουρος ότι θέλεις να διαγράψεις το μάθημα ;
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary">Ακύρωση</button>
                        <button type="submit" class="btn btn-danger">Διαγραφή</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop"></div>
    </div>
</template>

<script setup>

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
