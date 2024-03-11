<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade un fichaje nuevo</h5>
            </div>

            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>

            <form @submit.prevent="addFichaje()">
                <div class="form-group mb-2">
                    <label>ID de usuario</label><span class="text-danger"> *</span>
                    <input v-model="fichaje.idUser" type="text" class="form-control" placeholder="ID de usuario">
                </div>

                <div class="form-group mb-2">
                    <label>Fecha de fichaje</label><span class="text-danger"> *</span>
                    <input v-model="fichaje.fechaFichaje" type="date" class="form-control" placeholder="Fecha de fichaje">
                </div>

                <div class="form-group mb-2">
                    <label>Hora de entrada</label><span class="text-danger"> *</span>
                    <input type="time" v-model="fichaje.horaEntrada" class="form-control" placeholder="Hora de entrada"/>
                </div>

                <div class="form-gorup mb-2">
                    <label>Hora de salida</label><span class="text-danger">*</span>
                    <input v-model="fichaje.horaSalida" type="time" class="form-control" placeholder="Hora de salida">
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Crear fichaje</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";

const fichaje = ref({});
const strError = ref(null);
const strSuccess = ref(null);

function addFichaje() {
  axios
    .post('/api/fichajes', fichaje.value)
    .then(response => {
      console.log(response);
      strSuccess.value = response.data.success;
      strError.value = null;
    })
    .catch(error => {
      console.log(error);
      strSuccess.value = null;
      strError.value = error.response.data.message;
    });
}
</script>
<style></style>