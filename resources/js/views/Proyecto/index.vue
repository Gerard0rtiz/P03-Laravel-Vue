<template>
    <div
        class="relative items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="mx-auto sm:px-6 lg:px-8" style="width: 100%;">
            <div class="flex justify-center pt-8 sm:text-gray-600 dark:text-gray-400 text-sm">
            </div>
            <div class="container mt-5">
            </div>
        </div>
        <div class="mx-auto sm:px-6 lg:px-8 container" style="width: 100%;">
            <div>
                <h2 class="mt-8 titles-seccion">Imputación de horas de proyecto:</h2>
                <div class="d-flex justify-content-between align sm:text-gray-600 dark:text-gray-400 text-sm">
                    <h1 class="project-title" style="text-transform: uppercase;">{{ proyectoTitulo }}</h1>
                    <router-link class="nav-link btn-pulse btn btn-goback"
                        style="padding: 12px 25px; font-size: 18px; color: #053b28;" to="/">❮ VOLVER</router-link>
                </div>
            </div>

            <div class="container mt-5 card imp-section" style="background-color: #ede8db; margin: 0px !important;">
                <div class="filtrosTabla">
                    <input type="text" class="form-control border rounded mb-3" placeholder="Filtrar por empleado"
                        v-model="filtroNombre" style="width: 300px; margin-left: 12px; background-color: #f0efec;">
                    <input type="text" class="form-control border rounded mb-3" placeholder="Filtrar por fecha"
                        v-model="filtroFecha" style="width: 300px; margin-left: 12px; background-color: #f0efec;">
                </div>
                <div class="container table-container" style="display: flex !important;">
                    <table class="table table-hover table-sm" style="width: 100%;">
                        <thead class="text-light">
                            <tr>
                                <th class="text-center"
                                    style="border-top-left-radius: 15px; background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">
                                    EMPLEADO
                                </th>
                                <th class="text-center"
                                    style="background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">FECHA
                                </th>
                                <th class="text-center"
                                    style="background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">HORAS
                                </th>
                                <th class="text-center"
                                    style="border-top-right-radius: 15px; background-color: #053b28; color: #FFF; width: 25%; font-size: 18px;">
                                    DESCRIPCIÓN
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(imputacion) in imputacionesFiltradas" :key="imputacion.id">
                                <td v-if="imputacion.idProyecto == proyectoId" class="text-center">{{
                        imputacion.user.name }}</td>
                                <td v-if="imputacion.idProyecto == proyectoId" class="text-center">{{
                        imputacion.fechaImputacion }}</td>
                                <td v-if="imputacion.idProyecto == proyectoId" class="text-center">{{
                        imputacion.horasRealizadas }}</td>
                                <td v-if="imputacion.idProyecto == proyectoId" class="descripcion text-center"
                                    @click="showPopup(imputacion.descripcion)">{{
                        imputacion.descripcion }}</td>
                            </tr>
                            <tr v-if="imputacionesFiltradas.idProyecto != proyectoId">
                                <td colspan="4" class="text-center" style="font-size: 18px; color: #053b28;">
                                    No se han encontrado más imputaciones
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div v-if="showDescriptionPopup" class="popup" @click.self="closePopup">
                        <div class="popup-content">
                            <span class="close" @click="closePopup">&times;</span>
                            <p>{{ descriptionContent }}</p>
                        </div>
                    </div>
                </div>
                <div class="container" style="padding-top: 60px; ">
                    <form @submit.prevent="addImputacion()" class="row g-3">
                        <div class="col-md-3">
                            <label>FECHA:</label>
                            <input type="date" class="form-control border rounded" v-model="imputacion.fechaImputacion"
                                style="background-color: #f0efec;">
                        </div>
                        <div class="col-md-3">
                            <label>HORAS REALIZADAS:</label>
                            <input type="number" max="12" min="0" class="form-control border rounded"
                                v-model="imputacion.horasRealizadas" style="background-color: #f0efec;">
                        </div>
                        <div class="col-md-6">
                            <label>DESCRIPCIÓN:</label>
                            <textarea class="form-control border rounded" v-model="imputacion.descripcion"
                                maxlength="400"
                                style="max-height: 100px; min-height: 100px; background-color: #f0efec;"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn save-imput"
                                style="display: flex; align-items: center; background-color: #053b28; color: #FFF; font-weight: 700; font-size: 16px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="icon-save-imputacion" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2z" />
                                    <path
                                        d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z" />
                                </svg>
                                <p style="font-weight: 300;">Guardar</p>
                            </button>
                        </div>
                    </form>
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

import axios from "axios";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import { ref, computed, onMounted } from "vue";



const store = useStore();
const user = computed(() => store.getters["auth/user"]);
const imputaciones = ref([]);
const strError = ref(null);
const strSuccess = ref(null);
const route = useRoute();
const imputacion = ref({});
const filtroNombre = ref('');
const filtroFecha = ref('');
imputacion.value.idUser = user.value.id;
const proyectoId = route.params.id;
imputacion.value.idProyecto = proyectoId;
const proyectoTitulo = route.params.titulo;

function addImputacion() {
    axios.post('/api/imputaciones', imputacion.value)
        .then(response => {
            console.log(response);
            strSuccess.value = response.data.success;
            strError.value = null;
            //actualizar tabla al imputar
            getImputaciones();
            //Vaciar formulario
            imputacion.value = {};
            imputacion.value.idUser = user.value.id;
            imputacion.value.idProyecto = proyectoId;
        })
        .catch(error => {
            console.log(error);
            strSuccess.value = null;
            strError.value = error.response.data.message;
        });
}

function getImputaciones() {
    axios.get('/api/imputaciones')
        .then(response => {
            imputaciones.value = response.data;
            imputaciones.value.sort((a, b) => {
                return new Date(b.fechaImputacion) - new Date(a.fechaImputacion);
            });
        })
        .catch(error => {
            console.error("Error al obtener imputaciones:", error);
        });
}


onMounted(() => {
    window.scrollTo(0, 0);
    getImputaciones();
});

const imputacionesFiltradas = computed(() => {
    return imputaciones.value.filter(imputacion => {
        const nombreMatch = imputacion.user.name.toLowerCase().includes(filtroNombre.value.toLowerCase());
        const fechaMatch = imputacion.fechaImputacion.includes(filtroFecha.value);
        return nombreMatch && fechaMatch;
    });
});

</script>

<script>
export default {
    data() {
        return {
            showDescriptionPopup: false,
            descriptionContent: ''
        };
    },
    methods: {
        showPopup(content) {
            this.descriptionContent = content;
            this.showDescriptionPopup = true;
        },
        closePopup() {
            this.showDescriptionPopup = false;
            this.descriptionContent = '';
        }
    }
};
</script>

<style scoped>
.titles-seccion {
    background-color: #ede8db;
    width: 455px;
    padding: 10px;
    margin-bottom: 0px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.icon-save-imputacion {
    fill: white;
    margin-right: 10px;
}

.project-title {
    margin-bottom: 0px;
    background-color: #ede8db;
    border-top-right-radius: 8px;
    padding: 10px;
}

.imp-section {
    border-top-left-radius: 0px;
}

.filtrosTabla {
    display: flex;
}

td {
    font-size: 16px;
    background-color: #f0efec;
}

thead th {
    position: sticky;
    top: 0;
    z-index: 2;
}

@media (max-width: 1000px) {
    th.text-center {
        font-size: 16px !important;
    }

    .filtrosTabla {
        display: grid;
        justify-content: center;
    }
}

@media (max-width: 770px) {
    th.text-center {
        font-size: 12px !important;
    }

    td {
        height: 75px !important;
    }

    .descripcion {
        height: 75px !important;
        max-height: 75px !important;
        display: block !important;
        overflow: hidden !important;
        position: relative !important;
    }

    .descripcion::after {
        content: "+";
        position: absolute;
        bottom: 0;
        right: 0;
        background: rgba(5, 59, 40, 0.75);
        color: #f1f1f1;
        padding: 3px 5px;
        margin-right: 7px;
        margin-bottom: 4px;
        border-radius: 8px;
        cursor: pointer;
    }
}

@media (max-width: 560px) {
    th.text-center {
        font-size: 12px !important;
    }

    .titles-seccion {
        font-size: 22px;
        width: 370px;
    }
}

.popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
    width: 80%;
    text-align: center;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
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

body {
    font-family: 'Nunito', sans-serif !important;
}

div {
    font-family: 'Nunito', sans-serif !important;
}

input {
    font-size: large;
    font-family: 'Nunito', sans-serif !important;
}

textarea {
    font-size: large;
    font-family: 'Nunito', sans-serif !important;
}

label {
    font-weight: 700;
    font-size: 18px
}

/*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
html {
    line-height: 1.15;
    -webkit-text-size-adjust: 100%
}

body {
    margin: 0
}

a {
    background-color: transparent
}

[hidden] {
    display: none
}

html {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
    line-height: 1.5
}

*,
:after,
:before {
    box-sizing: border-box;
    border: 0 solid #e2e8f0
}

a {
    color: inherit;
    text-decoration: inherit
}

svg,
video {
    display: block;
    vertical-align: middle
}

video {
    max-width: 100%;
    height: auto
}

.bg-white {
    --bg-opacity: 1;
    background-color: #fff;
    background-color: rgba(255, 255, 255, var(--bg-opacity))
}

.bg-gray-100 {
    --bg-opacity: 1;
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--bg-opacity))
}

.border-gray-200 {
    --border-opacity: 1;
    border-color: #edf2f7;
    border-color: rgba(237, 242, 247, var(--border-opacity))
}

.border-t {
    border-top-width: 1px
}

.flex {
    display: flex
}

.grid {
    display: grid
}

.hidden {
    display: none
}

.items-center {
    align-items: center
}

.justify-center {
    justify-content: center
}

.font-semibold {
    font-weight: 600
}

.h-5 {
    height: 1.25rem
}

.h-8 {
    height: 2rem
}

.h-16 {
    height: 4rem
}

.text-sm {
    font-size: .875rem
}

.text-lg {
    font-size: 1.125rem
}

.leading-7 {
    line-height: 1.75rem
}

.mx-auto {
    margin-left: auto;
    margin-right: auto
}

.ml-1 {
    margin-left: .25rem
}

.mt-2 {
    margin-top: .5rem
}

.mr-2 {
    margin-right: .5rem
}

.ml-2 {
    margin-left: .5rem
}

.mt-4 {
    margin-top: 1rem
}

.ml-4 {
    margin-left: 1rem
}

.mt-8 {
    margin-top: 2rem
}

.ml-12 {
    margin-left: 3rem
}

.-mt-px {
    margin-top: -1px
}

.max-w-6xl {
    max-width: 72rem
}

.min-h-screen {
    min-height: 100vh
}

.overflow-hidden {
    overflow: hidden
}

.p-6 {
    padding: 1.5rem
}

.py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem
}

.px-6 {
    padding-left: 1.5rem;
    padding-right: 1.5rem
}

.pt-8 {
    padding-top: 2rem
}

.fixed {
    position: fixed
}

.relative {
    position: relative
}

.top-0 {
    top: 0
}

.right-0 {
    right: 0
}

.shadow {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
}

.text-center {
    text-align: center
}

.text-gray-200 {
    --text-opacity: 1;
    color: #edf2f7;
    color: rgba(237, 242, 247, var(--text-opacity))
}

.text-gray-300 {
    --text-opacity: 1;
    color: #e2e8f0;
    color: rgba(226, 232, 240, var(--text-opacity))
}

.text-gray-400 {
    --text-opacity: 1;
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--text-opacity))
}

.text-gray-500 {
    --text-opacity: 1;
    color: #a0aec0;
    color: rgba(160, 174, 192, var(--text-opacity))
}

.text-gray-600 {
    --text-opacity: 1;
    color: #718096;
    color: rgba(113, 128, 150, var(--text-opacity))
}

.text-gray-700 {
    --text-opacity: 1;
    color: #4a5568;
    color: rgba(74, 85, 104, var(--text-opacity))
}

.text-gray-900 {
    --text-opacity: 1;
    color: #1a202c;
    color: rgba(26, 32, 44, var(--text-opacity))
}

.btn-gris {
    background-color: #6c757d;
    border-color: #6c757d;
    cursor: not-allowed;
}

.underline {
    text-decoration: underline
}

.antialiased {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale
}

.w-5 {
    width: 1.25rem
}

.w-8 {
    width: 2rem
}

.w-auto {
    width: auto
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr))
}

@media (min-width:640px) {
    .sm\:rounded-lg {
        border-radius: .5rem
    }

    .sm\:block {
        display: block
    }

    .sm\:items-center {
        align-items: center
    }

    .sm\:justify-start {
        justify-content: flex-start
    }

    .sm\:justify-between {
        justify-content: space-between
    }

    .sm\:h-20 {
        height: 5rem
    }

    .sm\:ml-0 {
        margin-left: 0
    }

    .sm\:px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem
    }

    .sm\:pt-0 {
        padding-top: 0
    }

    .sm\:text-left {
        text-align: left
    }

    .sm\:text-right {
        text-align: right
    }
}

@media (min-width:768px) {
    .md\:border-t-0 {
        border-top-width: 0
    }

    .md\:border-l {
        border-left-width: 1px
    }

    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr))
    }
}

@media (min-width:1024px) {
    .lg\:px-8 {
        padding-left: 2rem;
        padding-right: 2rem
    }
}

@media (prefers-color-scheme:dark) {
    .dark\:bg-gray-800 {
        --bg-opacity: 1;
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--bg-opacity))
    }

    .dark\:bg-gray-900 {
        --bg-opacity: 1;
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--bg-opacity))
    }

    .dark\:border-gray-700 {
        --border-opacity: 1;
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--border-opacity))
    }

    .dark\:text-white {
        --text-opacity: 1;
        color: #fff;
        color: rgba(255, 255, 255, var(--text-opacity))
    }

    .dark\:text-gray-400 {
        --text-opacity: 1;
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--text-opacity))
    }

    .dark\:text-gray-500 {
        --tw-text-opacity: 1;
        color: #6b7280;
        color: rgba(107, 114, 128, var(--tw-text-opacity))
    }
}

.save-imput {
    padding: 10px 20px;
}

.save-imput:hover {
    background-color: #04744d !important;
}

.btn-goback {
    transition: transform 0.3s ease;
}

.btn-goback:hover {
    transform: scale(0.95);
}
</style>
