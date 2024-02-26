<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las tareas</h5>
                        <div>
                            <router-link class="btn btn-success" :to="{name:'tasks.create'}">Nueva Tarea</router-link>
                        </div>
                    </div>


                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Name</th>
                                <th>description</th>
                                <th>date_open</th>
                                <th>date_close</th>
                                <th class="text-center" width="200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(task, index) in tasks">
                                <td class="text-center">{{ task.id }}</td>
                                <td>{{ task.name }}</td>
                                <td>{{ task.description }}</td>
                                <td>{{ task.date_open }}</td>
                                <th>{{ task.date_close }}</th>
                                <td class="text-center">
                                    <router-link class="btn btn-warning mr-1" :to="{name:'tasks.edit'}">Edit</router-link>
                                    <button @click="deleteTask(task.id, index)" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import axios from "axios";
import { ref, inject, onMounted } from "vue";
const tasks = ref();
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/tasks')
        .then(response => {
            tasks.value = response.data;

        })
});

const deleteTask = (id, index) => {
    swal({
        title: 'Quieres eliminar la tarea?',
        text: 'Esta acción no es reversible!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: '#ef4444',
        timer: 20000,
        timerProgressBar: true,
        reverseButtons: true
    })
        .then(result => {
            if (result.isConfirmed) {
                axios.delete('/api/tasks/' + id)
                        tasks.value.splice(index, 1);
                        swal({
                            icon: 'success',
                            title: 'Tarea eliminada correctamente'
                        });
                    }).catch(error => {
                        swal({
                            icon: 'error',
                            title: 'Error al eliminar la tarea'
                        });
                    })
            }
        })


}
</script>


<style></style>
=======
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete('/api/tasks/' + id)
                .then(response => {
