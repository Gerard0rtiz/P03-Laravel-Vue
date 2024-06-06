<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualizar tecnologia</h5>
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
                    <label>Nombre de tecnologia</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="tecnologia.nombre" placeholder="Nombre de tecnologia">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar tecnologia</button>
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

const tecnologia = reactive({
    id: route.params.id,
    nombre: ''
});

const errors = reactive({
    name: ''
});

onMounted(() => {
    axios.get('/api/tecnologias/' + route.params.id)
    .then(response => {
        tecnologia.id = response.data.id;
        tecnologia.nombre = response.data.nombre;
    })
    .catch(function(error) {
        console.log(error);
    });
})

const submitForm = async () => {
    try {
        await axios.put(`/api/tecnologias/update/${tecnologia.id}`, tecnologia);

        strSuccess.value = 'tecnologia actualizada exitosamente';

        router.push({ name: 'tecnologias.index' });
    } catch (error) {
        console.error("Error updating tecnologia:", error);

        strError.value = 'Error al actualizar la tecnologia';
    }
};
</script>

<style></style>