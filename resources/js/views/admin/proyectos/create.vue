<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade un proyecto nuevo</h5>
            </div>

            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>

            <form @submit.prevent="addProyecto()">
                <div class="form-group mb-2">
                    <label>Título</label><span class="text-danger"> *</span>
                    <input v-model="proyecto.titulo" type="text" class="form-control" placeholder="Título proyecto">
                </div>

                <div class="form-group mb-2">
                    <label>Descripción</label><span class="text-danger"> *</span>
                    <textarea v-model="proyecto.descripcion" class="form-control" rows="3" placeholder="Descripción"></textarea>
                </div>

                <div class="form-gorup mb-2">
                    <label>ID jefe de proyecto</label><span class="text-danger">*</span>
                    <input v-model="proyecto.idUser" type="text" class="form-control" placeholder="ID jefe del proyecto">
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Crear proyecto</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";

const proyecto = ref({});
const strError = ref(null);
const strSuccess = ref(null);

function addProyecto() {
  axios
    .post('/api/proyectos', proyecto.value)
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