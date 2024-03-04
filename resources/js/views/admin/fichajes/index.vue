<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todos los fichajes</h5>
                        <div>
                            <RouterLink :to="{titulo:'fichaje.create'}" class="btn btn-success">Nuevo fichaje</RouterLink>
                        </div>
                    </div>


                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Fecha fichaje</th>
                                <th>Horas entrada</th>
                                <th>Hora salida</th>
                                <th class="text-center" width="200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(fichaje,index) in fichajes">
                                <td class="text-center">{{ fichaje.id }}</td>
                                <td>{{ fichaje.fechaFichaje}}</td>
                                <td>{{ fichaje.horaEntrada}}</td>
                                <td>{{ fichaje.horaSalida}}</td>
                                <td class="text-center">
                                    <RouterLink :to="{titulo:'fichaje.update'}" @click="updateFichaje(fichaje.id,index)" class="btn btn-warning mr-1">Edit</RouterLink>
                                    <button class="btn btn-danger" @click="deleteFichaje(fichaje.id,index)">Delete</button>
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
const fichajes = ref();
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/fichajes')
        .then(response => {
            fichajes.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error fetching fichajes:", error);
        });
});

const deleteFichaje = (id, index) => {
    swal({
        title: '¿Quieres eliminar el fichaje?',
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
            axios.delete('/api/fichajes/' + id)
                .then(response => {
                    fichajes.value.splice(index, 1);
                    swal({
                        icon: 'success',
                        title: 'Se ha eliminado el fichaje exitosamente.'
                    });
                })
                .catch(error => {
                    swal({
                        icon: 'error',
                        title: 'Error al eliminar el fichaje.'
                    });
                    console.error("Error deleting fichaje:", error);
                });
        }
    });
};
</script>


<style></style>
