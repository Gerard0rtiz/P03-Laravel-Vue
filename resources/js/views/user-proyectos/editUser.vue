<template>
    <div class="d-flex" style="margin-top: 120px; width: 40%; justify-content: center; text-transform: uppercase">
        <h1>{{ proyecto.titulo }}</h1>
    </div>
    <div class="d-flex" style="margin-top: 50px; width: 100%; justify-content: center">
        <div class="card" style="width: 70%;">
            <table>
                <thead>
                    <tr>
                        <th>ID del usuario</th>
                        <th>Nombre del usuario</th>
                        <th>ID del proyecto</th>
                        <th width="200px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(usuario, index) in proyecto.users" :key="index">
                        <td>{{ usuario.id }}</td>
                        <td>{{ usuario.name }}</td>
                        <td>{{ usuario.pivot.idProyecto }}</td>
                        <td>
                            <button class="btn btn-danger" @click="eliminarUsuario(proyecto.id, usuario.id)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-top: 30px;">
                <form @submit.prevent="agregarUsuario">
                    <p><strong>ID del usuario:</strong></p> 
                    <input v-model="nuevoUsuarioId" style="margin-right: 20px;" type="number" min="0">
                    <button type="submit" class="btn" style="background-color: #053b28; color: white">Añadir usuario</button>
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
  axios.delete(`/api/proyectos/${proyectoId}/usuarios/${usuarioId}`)
    .then(response => {
      obtenerUsuariosProyecto();
      console.log("Usuario eliminado exitosamente");
    })
    .catch(error => {
      console.error("Error al eliminar usuario:", error);
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
    buttons: false
  });
};

const mostrarPopupError = () => {
  swal({
    title: 'Error',
    text: 'No se ha podido asignar el usuario al proyecto',
    icon: 'error',
    buttons: {
      confirm: 'Ok'
    }
  });
};
</script>
