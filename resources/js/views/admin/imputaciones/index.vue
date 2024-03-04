<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todos las imputaciones</h5>
                        <div>
                            <RouterLink :to="{titulo:'imputacion.create'}" class="btn btn-success">Nueva imputacion</RouterLink>
                        </div>
                    </div>


                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Fecha imputacion</th>
                                <th>Horas realizadas</th>
                                <th>Descripcion</th>
                                <th class="text-center" width="200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(imputacion,index) in imputaciones">
                                <td class="text-center">{{ imputacion.id }}</td>
                                <td>{{ imputacion.fechaImputacion}}</td>
                                <td>{{ imputacion.horasRealizadas}}</td>
                                <td>{{ imputacion.descripcion}}</td>
                                <td class="text-center">
                                    <RouterLink :to="{titulo:'Imputacion.update'}" @click="updateImputacion(imputacion.id,index)" class="btn btn-warning mr-1">Edit</RouterLink>
                                    <button class="btn btn-danger" @click="deleteImputacion(imputacion.id,index)">Delete</button>
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
const imputaciones = ref();
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/imputaciones')
        .then(response => {
            imputaciones.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error fetching imputaciones:", error);
        });
});

const deleteImputacion = (id, index) => {
    swal({
        title: '¿Quieres eliminar la imputacion?',
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
            axios.delete('/api/imputaciones/' + id)
                .then(response => {
                    imputaciones.value.splice(index, 1);
                    swal({
                        icon: 'success',
                        title: 'Se ha eliminado la imputacion exitosamente.'
                    });
                })
                .catch(error => {
                    swal({
                        icon: 'error',
                        title: 'Error al eliminar la imputacion.'
                    });
                    console.error("Error deleting imputacion:", error);
                });
        }
    });
};
</script>


<style></style>
