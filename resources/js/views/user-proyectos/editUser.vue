<template>
    <div class="mx-auto sm:px-6 lg:px-8 container" style="margin-bottom: 100px;">
        <h2 class="titles-seccion">Edición de empleados de proyectos:</h2>
        <div class="d-flex" style="text-transform: uppercase; justify-content: space-between;">
            <h1 class="title-usrEdit">{{ proyecto.titulo }}</h1>
            <router-link class="nav-link btn-pulse btn btn-goback"
                style="padding: 12px 25px; font-size: 18px; color: #053b28;" to="/">❮
                VOLVER</router-link>
        </div>
        <div class="d-flex" style="margin: 0px; width: 100%; justify-content: center">
            <div class="card usr-editor" style="width: 100%; background-color: #ede8db;">
                <table class="table table-hover table-sm" style="font-size: 18px; width: 100%;">
                    <thead class="text-light">
                        <tr>
                            <th class="text-center"
                                style="border-top-left-radius: 15px; background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">
                                ID del usuario</th>
                            <th class="text-center"
                                style="background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">Nombre del
                                usuario</th>
                            <th class="text-center"
                                style="background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">ID del
                                proyecto
                            </th>
                            <th class="text-center"
                                style="border-top-right-radius: 15px; background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;"
                                width="200px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(usuario, index) in proyecto.users" :key="index">
                            <td style="background-color: #f0efec; padding: 10px" class="text-center">{{ usuario.id }}
                            </td>
                            <td style="background-color: #f0efec; padding: 10px" class="text-center">{{ usuario.name }}
                            </td>
                            <td style="background-color: #f0efec; padding: 10px" class="text-center">{{
                usuario.pivot.idProyecto }}</td>
                            <td style="background-color: #f0efec; padding: 10px" class="text-center">
                                <button class="btn btn-danger btn-delete" style="font-size: 15px;"
                                    @click="eliminarUsuario(proyecto.id, usuario.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path
                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top: 30px;">
                    <form @submit.prevent="agregarUsuario">
                        <p style="font-size: 18px;"><strong>ID del usuario:</strong></p>
                        <input class="inp-num" v-model="nuevoUsuarioId" @input="buscarNombreEmpleado(nuevoUsuarioId)"
                            type="number" min="0" style="background-color: #f0efec;">
                        <button class="btn-users" type="submit">Añadir usuario</button>
                    </form>
                    <div v-if="nombreEmpleado && nombreEmpleado.name">
                        <p class="name-user-display"><strong>Nombre del empleado: {{ nombreEmpleado.name }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footerImputfy">
            <div>Términos y condiciones</div>
            <div>Copyright Imputfy 2024</div>
        </div>
    </footer>
</template>

<script setup>
import { ref, inject, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
const swal = inject('$swal');

const proyecto = ref({});
const route = useRoute();
const nuevoUsuarioId = ref('');
const nombreEmpleado = ref('');

onMounted(() => {
    window.scrollTo(0, 0);
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

const buscarNombreEmpleado = async (id) => {
    if (id) {
        try {
            const response = await axios.get(`/api/user/${id}`);
            nombreEmpleado.value = { name: response.data.name };
        } catch (error) {
            console.error("Error al buscar el nombre del empleado:", error);
            nombreEmpleado.value = '';
        }
    } else {
        nombreEmpleado.value = '';
    }
};

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
.name-user-display{
    font-size: 18px;
    padding-top: 20px;
}

.titles-seccion {
    background-color: #ede8db;
    margin-top: 150px !important;
    width: 470px;
    padding: 10px;
    margin-bottom: 0px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.title-usrEdit {
    margin-bottom: 0px;
    background-color: #ede8db;
    border-top-right-radius: 8px;
    padding: 10px;
}

.usr-editor {
    border-top-left-radius: 0px !important;
    border: none;
}

@media (max-width: 1000px) {
    th.text-center {
        font-size: 16px !important;
    }

}

@media (max-width: 770px) {
    th.text-center {
        font-size: 13px !important;
    }

}

@media (max-width: 560px) {
    th.text-center {
        font-size: 12px !important;
    }

}

@media (max-width: 530px) {
    th.text-center {
        font-size: 15px !important;
    }

    td.text-center {
        font-size: 15px;
    }

    .inp-num {
        width: 150px;
    }

    .btn-delete {
        font-size: 13px !important;
    }

    .btn-users {
        font-size: 16px !important;
    }

    .titles-seccion {
        font-size: 22px;
        width: 375px;
    }
}

body {
    font-family: 'Nunito', sans-serif !important;
    background-color: #f5f5f5 !important;
}

footer {
    background-color: #053b28;
    color: #fcfcfc;
}

.footerImputfy {
    max-width: 70%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    height: 50px;
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

.inp-num {
    margin-right: 20px;
    border: solid 1px #9a9b9c;
    border-radius: 5px;
    padding: 10px;
    font-size: 18px;
}

.btn-users {
    font-size: 18px;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    background-color: #053b28;
    color: white;
}

.min-h-screen {
    min-height: 100vh
}

.bg-gray-100 {
    --bg-opacity: 1;
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--bg-opacity))
}

.pt-8 {
    padding-top: 2rem
}

.text-gray-600 {
    --text-opacity: 1;
    color: #718096;
    color: rgba(113, 128, 150, var(--text-opacity))
}

.dark\:text-gray-400 {
    --text-opacity: 1;
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--text-opacity))
}

.text-sm {
    font-size: .875rem
}

.btn-delete:hover {
    background-color: #ee4141 !important;
    box-shadow: none;
    border: none;
}

.btn-goback {
    transition: transform 0.3s ease;
    display: flex;
    align-items: center;
}

.btn-goback:hover {
    transform: scale(0.95);
}

.btn-users:hover {
    background-color: #04744d !important;
}
</style>