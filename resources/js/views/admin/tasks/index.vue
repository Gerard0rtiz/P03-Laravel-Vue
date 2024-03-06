<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las tareas</h5>
                        <div>
                            <RouterLink :to="{name:'tasks.create'}" class="btn btn-success">Nueva tarea</RouterLink>
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
                            <tr v-for="(task,index) in tasks">
                                <td class="text-center">{{ task.id }}</td>
                                <td>{{ task.name }}</td>
                                <td>{{ task.description }}</td>
                                <td>{{ task.date_open }}</td>
                                <th>{{ task.date_close }}</th>
                                <td class="text-center">
                                    <RouterLink :to="{name:'tasks.edit'}" @click="updateTask(task.id,index)" class="btn btn-warning mr-1">Edit</RouterLink>
                                    <button class="btn btn-danger" @click="deleteTask(task.id,index)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error fetching tasks:", error);
        });
});

const deleteTask = (id, index) => {
    swal({
        title: '¿Quieres eliminar la tarea?',
        text: 'Esta acción no se puede revertir.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: '#ef4444',
        timer: 20000,
        timerProgressBar: true,
        reverseButtons: true
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete('/api/tasks/' + id)
                .then(response => {
                    tasks.value.splice(index, 1);
                    swal({
                        icon: 'success',
                        title: 'Se ha eliminado la tarea exitosamente.'
                    });
                })
                .catch(error => {
                    swal({
                        icon: 'error',
                        title: 'Error al eliminar la tarea.'
                    });
                    console.error("Error deleting task:", error);
                });
        }
    });
};
</script>


<style></style>
