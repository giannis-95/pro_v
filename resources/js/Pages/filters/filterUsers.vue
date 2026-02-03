<template>
    <div class="row">
        <div class="col mt-3 mb-3">
            <div class="container mt-4">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <label class="col-3 col-form-label">Όνομα Χρήστη:</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="filters.name">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <label class="col-3 col-form-label">Ρόλος Χρήστη:</label>
                            <div class="col-9">
                                <select class="form-control" v-model="filters.role">
                                    <option value="">Επιλεξτε Ρόλο...</option>
                                    <option value="Φοιτητής">Φοιτητής</option>
                                    <option value="Καθηγητής">Καθηγητής</option>
                                    <option value="Διαχειριστής">Διαχειριστής</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col col-form-label col-sm-3 col-md-3 col-lg-3">
                        <label>Ημερομηνία Δημιουργίας Χρήστη</label>
                    </div>
                    <div class="col-sm-9 col-md-9 col-lg-9">
                        <div class="row">
                            <label class="col col-form-label">Από :</label>
                            <div class="col-5">
                                <input type="date" class="form-control" v-model="filters.date_from">
                            </div>
                            <label class="col col-form-label">Εως :</label>
                            <div class="col-5">
                                <input type="date" class="form-control" v-model="filters.date_to">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <button @click="searchFilterUser" class="btn btn-primary">Αναζήτηση</button>
                    </div>
                    <div class="col-6 text-end">
                        <button @click="resetFilterUser" class="btn btn-danger" >Καθαρισμός</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive } from 'vue';

    const emit = defineEmits(['search','reset']);

    const filters = reactive({
        name:'',
        role:'',
        date_to:'',
        date_from:''
    });

    function searchFilterUser(){
        emit('search',{...filters});
    }

    function resetFilterUser(){
        filters.name = '';
        filters.role = '';
        filters.date_from = '';
        filters.date_to = '';
        emit('reset');
    }
</script>
