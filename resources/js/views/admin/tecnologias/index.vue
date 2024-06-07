<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las tecnologias</h5>
                        <div>
                            <RouterLink :to="{ name: 'tecnologias.create' }" class="btn btn-success">Nueva tecnologia
                            </RouterLink>
                        </div>
                    </div>

                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center" width="200">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(tecnologia, index) in tecnologias ">
                                <td class="text-center">{{ tecnologia.id }}</td>
                                <td class="text-center">{{ tecnologia.nombre }}</td>
                                <td class="text-center">
                                    <RouterLink :to="{ name: 'tecnologias.edit', params: { id: tecnologia.id } }"
                                        class="btn btn-warning mr-1">Editar</RouterLink>
                                    <button class="btn btn-danger"
                                        @click="deletetecnologia(tecnologia.id, index)">Eliminar</button>
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
const tecnologias = ref();
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/tecnologias')
        .then(response => {
            tecnologias.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error fetching tecnologias:", error);
        });
});

const deletetecnologia = (id, index) => {
    swal({
        title: '¿Quieres eliminar la tecnologia?',
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
            axios.delete('/api/tecnologias/' + id)
                .then(response => {
                    tecnologias.value.splice(index, 1);
                    swal({
                        icon: 'success',
                        title: 'Se ha eliminado la tecnologia exitosamente.'
                    });
                })
                .catch(error => {
                    swal({
                        icon: 'error',
                        title: 'Error al eliminar la tecnologia.'
                    });
                    console.error("Error deleting tecnologias:", error);
                });
        }
    });
};
</script>