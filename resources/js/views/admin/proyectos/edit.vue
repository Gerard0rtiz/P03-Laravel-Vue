<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualizar proyecto</h5>
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
                    <label>Título</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="proyecto.titulo" placeholder="Título proyecto">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Descripción</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="proyecto.descripcion"
                        placeholder="Descripción"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>ID jefe de proyecto</label><span class="text-danger">*</span>
                    <input class="form-control" type="text" v-model="proyecto.idUser" placeholder="ID jefe del proyecto" />
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar proyecto</button>
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

const proyecto = reactive({
    id: route.params.id,
    titulo: '',
    descripcion: '',
    idUser: ''
});

const errors = reactive({
    name: ''
});

onMounted(() => {
    axios.get('/api/proyectos/' + route.params.id)
    .then(response => {
        proyecto.id = response.data.id;
        proyecto.titulo = response.data.titulo;
        proyecto.descripcion = response.data.descripcion;
        proyecto.idUser = response.data.idUser;
    })
    .catch(function(error) {
        console.log(error);
    });
})

const submitForm = async () => {
    try {
        await axios.put(`/api/proyectos/update/${proyecto.id}`, proyecto);

        strSuccess.value = 'Proyecto actualizado exitosamente';

        router.push({ name: 'proyectos.index' });
    } catch (error) {
        console.error("Error updating proyecto:", error);

        strError.value = 'Error al actualizar el proyecto';
    }
};
</script>

<style></style>