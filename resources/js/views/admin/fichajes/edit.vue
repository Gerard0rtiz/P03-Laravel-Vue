<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualizar fichaje</h5>
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
                    <input type="text" class="form-control" rows="3" v-model="fichaje.idUser" placeholder="ID de usuario"/>
                </div>

                <div class="form-group mb-2">
                    <label>Fecha del fichaje</label><span class="text-danger"> *</span>
                    <input type="date" class="form-control" v-model="fichaje.fechaFichaje" placeholder="Fecha de fichaje">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Hora de entrada</label><span class="text-danger"> *</span>
                    <input type="time" class="form-control" rows="3" v-model="fichaje.horaEntrada" placeholder="Hora de entrada"/>
                </div>

                <div class="form-group mb-2">
                    <label>Hora de salida</label><span class="text-danger">*</span>
                    <input class="form-control" type="time" v-model="fichaje.horaSalida" placeholder="Hora de salida" />
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar fichaje</button>
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

const fichaje = reactive({
    id: route.params.id,
    idUser: '',
    fechaFichaje: '',
    horaEntrada: '',
    horaSalida: ''
});

const errors = reactive({
    name: ''
});

onMounted(() => {
    axios.get('/api/fichajes/' + route.params.id)
    .then(response => {
        fichaje.id = response.data.id;
        fichaje.idUser = response.data.idUser;
        fichaje.fechaFichaje = response.data.fechaFichaje;
        fichaje.horaEntrada = response.data.horaEntrada;
        fichaje.horaSalida = response.data.horaSalida;
    })
    .catch(function(error) {
        console.log(error);
    });
})

const submitForm = async () => {
    try {
        await axios.put(`/api/fichajes/update/${fichaje.id}`, fichaje);

        strSuccess.value = 'Fichaje actualizado exitosamente';

        router.push({ name: 'fichajes.index' });
    } catch (error) {
        console.error("Error updating fichaje:", error);

        strError.value = 'Error al actualizar el fichaje';
    }
};
</script>

<style></style>