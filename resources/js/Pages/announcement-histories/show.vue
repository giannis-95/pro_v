<template>
    <AuthenticatedLayout>
        <div class="container mt-2">
            <div class="row text-center">
                <h3>Προβολή Ιστορικού Ανακοίνωσης</h3>
            </div>
            <hr>
            <div class="row text-end">
                <div class="col">
                    <Link class="btn btn-primary">Πίσω</LinK>
                </div>
            </div>
            <div class="form-group row mb-3 mt-3">
                <label class="col-sm-2 col-form-label">Τίτλος:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" disabled>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Μάθημα:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" disabled>
                </div>
            </div>
                <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Καθηγητής:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" disabled>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Αρχείο:</label>
                <div class="col-sm-10">
                    <div>
                        <a>Κατέβασμα αρχείου</a>
                    </div>
                    <div class="col-sm-10">
                        <p>Δεν υπάρχει αρχείο</p>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Μήνυμα:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="4" disabled></textarea>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';
</script>
