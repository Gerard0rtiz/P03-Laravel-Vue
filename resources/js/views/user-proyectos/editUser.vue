<template>
    <div class="d-flex" style="margin-top: 150px; width: 40%; justify-content: center; text-transform: uppercase">
        <h1><strong>{{ proyecto.titulo }}</strong></h1>
    </div>
    <div class="d-flex" style="margin-top: 20px; width: 100%; justify-content: center">
        <div class="card" style="width: 70%;">
            <table class="table table-hover table-sm" style="font-size: 18px; width: 100%;">
                <thead class="text-light">
                    <tr>
                        <th class="text-center" style="border-top-left-radius: 15px; background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">ID del usuario</th>
                        <th class="text-center" style="background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">Nombre del usuario</th>
                        <th class="text-center" style="background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">ID del proyecto</th>
                        <th class="text-center" style="border-top-right-radius: 15px; background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;" width="200px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(usuario, index) in proyecto.users" :key="index">
                        <td style="padding: 10px" class="text-center">{{ usuario.id }}</td>
                        <td style="padding: 10px" class="text-center">{{ usuario.name }}</td>
                        <td style="padding: 10px" class="text-center">{{ usuario.pivot.idProyecto }}</td>
                        <td style="padding: 10px" class="text-center">
                            <button class="btn btn-danger" style="font-size: 15px;" @click="eliminarUsuario(proyecto.id, usuario.id)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-top: 30px;">
                <form @submit.prevent="agregarUsuario">
                    <p style="font-size: 18px;"><strong>ID del usuario:</strong></p> 
                    <input class="inp-num" v-model="nuevoUsuarioId" type="number" min="0">
                    <button class="btn-users"type="submit">Añadir usuario</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, inject, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
const swal = inject('$swal');

const proyecto = ref({});
const route = useRoute();
const nuevoUsuarioId = ref('');

onMounted(() => {
    obtenerUsuariosProyecto();
});

const obtenerUsuariosProyecto = () => {
    axios.get(`/api/proyectos/${route.params.id}/usuarios`)
        .then(response => {
            proyecto.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error al obtener usuarios asignados al proyecto:", error);
        });
}

const eliminarUsuario = (proyectoId, usuarioId) => {
    swal.fire({
        title: "¿Estás seguro?",
        text: "Una vez eliminado, no podrás recuperar este usuario!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/api/proyectos/${proyectoId}/usuarios/${usuarioId}`)
                .then(response => {
                    obtenerUsuariosProyecto();
                    console.log("Usuario eliminado exitosamente");
                    swal.fire("¡Éxito!", "Usuario eliminado correctamente.", "success");
                })
                .catch(error => {
                    console.error("Error al eliminar usuario:", error);
                    swal.fire("Error", "No se pudo eliminar el usuario.", "error");
                });
        }
    });
}

const agregarUsuario = () => {
    axios.post(`/api/proyectos/${proyecto.value.id}/usuarios/${nuevoUsuarioId.value}`)
        .then(response => {
            obtenerUsuariosProyecto();
            console.log("Usuario asignado exitosamente");
            nuevoUsuarioId.value = '';
            mostrarPopupExitoso();
        })
        .catch(error => {
            console.error("Error al asignar usuario:", error);
            mostrarPopupError();
        });
}

const mostrarPopupExitoso = () => {
    swal({
        title: '¡Éxito!',
        text: 'Usuario asignado al proyecto correctamente',
        icon: 'success',
        timer: 2000,
        showCancelButton: false,
        showConfirmButton: false
    });
};

const mostrarPopupError = () => {
    swal({
        title: 'Error',
        text: 'No se ha podido asignar el usuario al proyecto',
        icon: 'error',
    });
};
</script>

<style>
body{
    font-family: 'Nunito', sans-serif !important; 
}
.table-container {
    overflow-y: auto;
    max-height: 300px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    position: sticky;
    top: 0;
}

.inp-num{
    margin-right: 20px; 
    border:solid 1px #9a9b9c; 
    border-radius: 5px;
    padding: 10px;
    font-size: 18px;
}

.btn-users{
    font-size: 18px; 
    border: none; 
    border-radius: 5px; 
    padding: 10px 15px; 
    background-color: #053b28; 
    color: white;
}
</style>