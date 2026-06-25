<template>
    <div class="card mb-4">
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
                                <label class="col-3 col-form-label">Email:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" v-model="filters.email">
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
    </div>
</template>

<script setup>
    import { reactive } from 'vue';

    const emit = defineEmits(['search','reset']);

    const filters = reactive({
        name:'',
        email:'',
        date_from:'',
        date_to:''
    });

    function searchFilterUser(){
        emit('search',{...filters});
    }

    function resetFilterUser(){
        filters.name = '';
        filters.email = '';
        filters.date_from = '';
        filters.date_to = '';
        emit('reset');
    }
</script>
