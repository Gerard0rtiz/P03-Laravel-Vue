<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las skills</h5>
                        <div>
                            <RouterLink :to="{ name: 'skills.create' }" class="btn btn-success">Nueva skill</RouterLink>
                        </div>
                    </div>

                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th class="text-center" width="200">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(skill, index) in skills ">
                                <td class="text-center">{{ skill.id }}</td>
                                <td class="text-center">{{ skill.nombre }}</td>
                                <td class="text-center">
                                    <RouterLink :to="{ name: 'skills.edit', params: { id: skill.id } }"
                                        class="btn btn-warning mr-1">Editar</RouterLink>
                                    <button class="btn btn-danger"
                                        @click="deleteSkill(skill.id, index)">Eliminar</button>
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
const skills = ref();
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/skills')
        .then(response => {
            skills.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error fetching skills:", error);
        });
});

const deleteSkill = (id, index) => {
    swal({
        title: '¿Quieres eliminar la skill?',
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
            axios.delete('/api/skills/' + id)
                .then(response => {
                    skills.value.splice(index, 1);
                    swal({
                        icon: 'success',
                        title: 'Se ha eliminado la skill exitosamente.'
                    });
                })
                .catch(error => {
                    swal({
                        icon: 'error',
                        title: 'Error al eliminar la skill.'
                    });
                    console.error("Error deleting skills:", error);
                });
        }
    });
};
</script>