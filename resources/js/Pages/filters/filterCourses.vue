<template>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Φίλτρα</button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 1400px;height: 250px;">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <label class="col-3 col-form-label">Τίτλος Μαθήματος:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" v-model="filters.title">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col col-form-label col-sm-3 col-md-3 col-lg-3">
                            <label>Ημερομηνία Δημιουργίας Μαθήματος</label>
                        </div>
                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <div class="row">
                                <label class="col col-form-label">Από :</label>
                                <div class="col-5">
                                    <input type="date" class="form-control" v-model="filters.date_to">
                                </div>
                                <label class="col col-form-label">Εως :</label>
                                <div class="col-5">
                                    <input type="date" class="form-control" v-model="filters.date_from">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <button @click="filterSearch" class="btn btn-primary">Αναζήτηση</button>
                        </div>
                        <div class="col-6 text-end">
                            <button @click="filterReset" class="btn btn-danger" >Καθαρισμός</button>
                        </div>
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
        title:'',
        date_to:'',
        date_from:''
    });

    function filterSearch(){
       emit('search',{...filters})
    }

    function filterReset(){
        filters.title = '';
        filters.date_from = '';
        filters.date_to = '';
        emit('reset')
    }
</script>
