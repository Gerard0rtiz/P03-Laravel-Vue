<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade una skill nueva</h5>
            </div>

            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>

            <form @submit.prevent="addSkill()">
                <div class="form-group mb-2">
                    <label>Nombre de skill</label><span class="text-danger"> *</span>
                    <input v-model="skill.nombre" type="text" class="form-control" placeholder="Nombre skill">
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Crear skill</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";

const skill = ref({});
const strError = ref(null);
const strSuccess = ref(null);

function addSkill() {
  axios
    .post('/api/skills', skill.value)
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