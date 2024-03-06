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

                <div class="form-gorup mb-2">
                    <label>ID jefe de proyecto</label><span class="text-danger">*</span>
                    <input class="form-control" type="text" v-model="proyecto.idUser" placeholder="ID jefe del proyecto" />
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar proyecto</button>


            </form>
        </div>
    </div>
</template>


<script setup>
import useProyectos from "@/composables/proyectos";
import { ref, onMounted, reactive, watchEffect } from "vue";
import { useForm, useField } from "vee-validate";
import { useRoute } from "vue-router";
import * as yup from 'yup';
import { es } from 'yup-locales';
import { setLocale } from 'yup';

const schema = yup.object({
    titulo: yup.string().required().label('Título'),
})

const { validate, errors } = useForm({ validationSchema: schema })

setLocale(es);

const strSuccess = ref();
const strError = ref();


const { value: titulo } = useField('titulo', null, { initialValue: '' });
const { value: descripcion } = useField('descripcion', null, { initialValue: '' });
const { value: idUser } = useField('idUser', null, { initialValue: '' });
const { proyecto: proyectoData, getProyecto, updateProyecto, validationErrors, isLoading } = useProyectos()
const proyecto = reactive({
    titulo,
    descripcion,
    idUser
})
const route = useRoute()
function submitForm() {
    validate().then(form => { if (form.valid) updateProyecto(proyecto) })
}
onMounted(() => {
    getProyecto(route.params.id)
})
watchEffect(() => {
    proyecto.id = proyectoData.value.id
    proyecto.titulo = proyectoData.value.titulo
    proyecto.descripcion = proyectoData.value.descripcion
    proyecto.idUser = proyectoData.value.idUser
})

// function saveProyecto() {
//    validate().then(form => {
//        console.log('validate');
//        if (form.valid) {
//            axios.post('/api/proyectos/update/' + route.params.id, proyecto)
//                .then(response => {
//                    strError.value = ""
//                    strSuccess.value = response.data.success
//                })
//                .catch(function (error) {
//                    strSuccess.value = ""
//                    strError.value = error.response.data.message
//                });
//        }
//    })

// }
</script>
<style></style>