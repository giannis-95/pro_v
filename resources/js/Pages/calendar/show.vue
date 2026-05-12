<template>
    <div class="modal fade" id="announcementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Προβολή Ανακοίνωσης</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row mb-3 mt-3">
                        <label class="col-sm-2 col-form-label">Τίτλος:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" :value="announcement?.title" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Μάθημα:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" :value="announcement?.course?.title" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Καθηγητής:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" :value="announcement?.user?.name" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Αρχείο:</label>
                        <div class="col-sm-10 mt-1">
                            <div v-if="announcement?.file">
                                <a :href="route('announcements.download-file', announcement.id)">Κατέβασμα αρχείου</a>
                            </div>
                            <div class="col-sm-10" v-else>
                                <p>Δεν υπάρχει αρχείο</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Κλεισιμο</button>
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
</script>

<style>
    #announcementModal .modal-content{
        background:white;
        border-radius:10px;
    }
</style>
