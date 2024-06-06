<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualizar skill</h5>
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
                    <label>Nombre de skill</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="skill.nombre" placeholder="Nombre de skill">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Nivel de skill</label><span class="text-danger"> *</span>
                    <input type="number" min="1" max="5" class="form-control" v-model="skill.nombre" placeholder="Nombre de skill">
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar skill</button>
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

const skill = reactive({
    id: route.params.id,
    nombre: '',
    nivel: ''
});

const errors = reactive({
    name: ''
});

onMounted(() => {
    axios.get('/api/skills/' + route.params.id)
    .then(response => {
        skill.id = response.data.id;
        skill.nombre = response.data.nombre;
        skill.nivel = response.data.nivel;
    })
    .catch(function(error) {
        console.log(error);
    });
})

const submitForm = async () => {
    try {
        await axios.put(`/api/skills/update/${skill.id}`, skill);

        strSuccess.value = 'Skill actualizada exitosamente';

        router.push({ name: 'skills.index' });
    } catch (error) {
        console.error("Error updating skill:", error);

        strError.value = 'Error al actualizar la skill';
    }
};
</script>

<style></style>