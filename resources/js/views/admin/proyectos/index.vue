<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todos los proyectos</h5>
                        <div>
                            <RouterLink :to="{name:'proyectos.create'}" class="btn btn-success">Nuevo proyecto</RouterLink>
                        </div>
                    </div>

                   
             
                    <table  class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>titulo</th>
                                <th>descripcion</th>
                                <th>ID jefe del proyecto</th>
                                <th class="text-center" width="200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            <tr  v-for="(proyecto,index) in proyectos ">
                                <td class="text-center">{{ proyecto.id }}</td>
                                <td  >{{ proyecto.titulo }}</td>
                                <td  class="descripcion">{{ proyecto.descripcion }}</td>
                                <td >{{ proyecto.idUser }}</td>
                                <td class="text-center">
                                    <RouterLink :to="{ name: 'proyectos.edit', params: { id: proyecto.id } }" class="btn btn-warning mr-1">Edit</RouterLink>
                                    <button class="btn btn-danger" @click="deleteProyecto(proyecto.id,index)">Delete</button>
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
const proyectos = ref();
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/proyectos')
        .then(response => {
            proyectos.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error fetching proyectos:", error);
        });
});

const deleteProyecto = (id, index) => {
    swal({
        title: '¿Quieres eliminar el proyecto?',
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
            axios.delete('/api/proyectos/' + id)
                .then(response => {
                    proyectos.value.splice(index, 1);
                    swal({
                        icon: 'success',
                        title: 'Se ha eliminado el proyecto exitosamente.'
                    });
                })
                .catch(error => {
                    swal({
                        icon: 'error',
                        title: 'Error al eliminar el proyecto.'
                    });
                    console.error("Error deleting proyecto:", error);
                });
        }
    });
};
</script>



<style>
.descripcion {
    max-width: 500px;
}
</style>
