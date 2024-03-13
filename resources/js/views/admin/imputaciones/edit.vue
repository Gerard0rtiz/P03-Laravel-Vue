<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualizar imputacion</h5>
            </div>

            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>

            <form @submit.prevent="submitForm">
                <div class="form-group mb-2">
                    <label>ID de usuario</label><span class="text-danger"> *</span>
                    <input v-model="imputacion.idUser" type="text" class="form-control" placeholder="ID de usuario">
                </div>

                <div class="form-group mb-2">
                    <label>ID de proyecto</label><span class="text-danger"> *</span>
                    <input v-model="imputacion.idProyecto" type="text" class="form-control" placeholder="ID de proyecto">
                </div>
                
                <div class="form-group mb-2">
                    <label>Fecha de imputacion</label><span class="text-danger"> *</span>
                    <input v-model="imputacion.fechaImputacion" type="date" class="form-control" placeholder="Fecha de imputacion">
                </div>

                <div class="form-group mb-2">
                    <label>Horas realizadas</label><span class="text-danger"> *</span>
                    <input v-model="imputacion.horasRealizadas" type="float" class="form-control" placeholder="Horas Realizadas">
                </div>

                <div class="form-gorup mb-2">
                    <label>Descripción</label><span class="text-danger">*</span>
                    <textarea v-model="imputacion.descripcion" type="text" class="form-control" rows="3" placeholder="Descripción"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar imputacion</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, reactive, onMounted } from "vue";
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const strSuccess = ref('');
const strError = ref('');

const imputacion = reactive({
    id: route.params.id,
    idUser: '',
    idProyecto: '',
    fechaImputacion: '',
    horasRealizadas: '',
    descripcion: '',
});

const errors = reactive({
    name: ''
});

onMounted(() => {
    axios.get('/api/imputaciones/' + route.params.id)
    .then(response => {
        imputacion.id = response.data.id;
        imputacion.idUser = response.data.idUser;
        imputacion.idProyecto = response.data.idProyecto;
        imputacion.fechaImputacion = response.data.fechaImputacion;
        imputacion.horasRealizadas = response.data.horasRealizadas;
        imputacion.descripcion = response.data.descripcion;
    })
    .catch(function(error) {
        console.log(error);
    });
})

const submitForm = async () => {
    try {
        await axios.put(`/api/imputaciones/update/${imputacion.id}`, imputacion);

        strSuccess.value = 'Imputacion actualizado exitosamente';

        router.push({ name: 'imputaciones.index' });
    } catch (error) {
        console.error("Error updating imputacion:", error);

        strError.value = 'Error al actualizar el imputacion';
    }
};
</script>

<style></style>