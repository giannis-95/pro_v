<template>
    <div>
        <div class="modal fade" id="addStudents" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Προσθήκη Φοιτητών</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <select class="form-control" v-model="selected_students" multiple>
                                    <option value="" disabled>Επιλέξτε Φοιτητές...</option>
                                    <option v-for="student in students" :key="student.id" :value="student.id">{{ student.user_name_email }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Κλείσιμο</button>
                        <button type="submit" class="btn btn-danger" @click="$emit('confirm-add-students',selected_students)">Προσθήκη</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';

    defineProps({
        students:{
            type: Object,
            required:true
        },
    })

    const emit = defineEmits(['confirm-add-students']);
    const selected_students = ref([]);
</script>

<style >
    #addStudents .modal-content {
        background: transparent; /* αφαιρεί λευκό background */
        border: none;            /* αφαιρεί πλαίσιο */
        box-shadow: none;        /* αφαιρεί τυχόν σκιά */
    }
</style>
