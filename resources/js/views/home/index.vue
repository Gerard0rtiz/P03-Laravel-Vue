<template>
    <div class="relative items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0"
        style="margin-top: 100px;">
        <div class="mx-auto sm:px-6 lg:px-8" style="width: 100%;">
            <div class="flex justify-center pt-8 sm:text-gray-600 dark:text-gray-400 text-sm">
                <h1 style="font-weight: 600; text-transform: uppercase;">{{ $t('welcome_starter_title') }}</h1>
            </div>
            <div v-if="user.id" class="container mt-5">
                <div id="fichajes-section" class="card" style="display: flex; align-items: center;">
                    <div class="card-body">
                        <ClockComponent class="text-center"
                            style="font-family: 'Nunito', sans-serif; background-color: #053b28; padding: 8px 20px; border-radius: 25px;" />
                    </div>
                    <div id="btns-fichaje" class="card-body"
                        style="display: flex; align-items: center; justify-content: space-around; width: 400px;">
                        <button class="btn-pulse" @click="EntradaFichaje()" :disabled="entradaDisabled"
                            :class="{ 'btn': true, 'btn-primary': true, 'btn-secondary': entradaDisabled }"
                            style="padding: 12px 25px; font-size: 18px; background-color: #053b28;">Entrar</button>
                        <button class="btn-pulse" @click="SalidaFichaje()" :disabled="salidaDisabled"
                            :class="{ 'btn': true, 'btn-danger': true, 'btn-gris': salidaDisabled }"
                            style="padding: 12px 25px; font-size: 18px;">Salir</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto sm:px-6 lg:px-8" style="width: 100%;">
            <div class="flex justify-center pt-8 sm:text-gray-600 dark:text-gray-400 text-sm">
                <h1 style="font-weight: 600; text-transform: uppercase;">{{ $t('imp_horas_proyectos') }}</h1>
            </div>
            <div class="d-flex justify-content-center" v-if="!user.id">
                <h2>Debe iniciar sesión para hacer uso de la aplicación</h2>
            </div>
            <div v-if="user.id" class="container mt-5 card">

                <div class="container" style="display: flex !important; justify-content: center; flex-wrap: wrap;">

                    <div  v-for="(proyecto, index) in proyectos" class="shadow btn-pulse col-3"
                        style="margin: 6px; border-radius: 20px; width: 24% !important; padding: 0;">
                        <RouterLink
                            :to="{ name: 'Proyecto.index', params: { id: proyecto.id, titulo: proyecto.titulo } }"
                            class="btn btn-light d-flex flex-column align-items-center justify-content-center"
                            :style="{ 'padding': '15px 25px', 'border-radius': '16px', 'width': '100%', 'height': '300px', 'background-image': 'url(' + (index % 2 === 0 ? '/images/bkg-proyectos/fondo1.jpeg' : '/images/bkg-proyectos/fondo2.jpeg') + ')', 'background-size': 'cover', 'background-position': 'center' }">
                            <h2
                                style="background-color: #053b28; padding: 5px 10px; border-radius: 15px; color: white; text-transform: uppercase; font-size: 25px;">
                                {{ proyecto.titulo }}</h2>
                            <p
                                style="background-color: #053b28; padding: 5px 10px; border-radius: 15px; color: white; font-size: 16px;">
                                {{ proyecto.descripcion }}</p>
                            <Router-link v-if="user.roles[0]?.name == 'admin' || proyecto.idUser == user.id" :to="{ name: 'EditarUsuarios', params: { id: proyecto.id } }">
                                <button  class="btn btn-warning">Editar Usuarios</button>
                            </Router-link>
                        </RouterLink>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { useStore } from "vuex";
import ClockComponent from '@/components/ClockComponent.vue';
import { ref, inject, computed, onMounted } from "vue";

const store = useStore();
const user = computed(() => store.getters["auth/user"]);
const fichaje = ref({});
const proyectos = ref([]);
const entradaDisabled = ref(true);
const salidaDisabled = ref(true);
const swal = inject('$swal');



//Al iniciar la vista, verifica las cookies y establece los estados de los botones
onMounted(() => {
    axios.get('/api/proyectos')
        .then(response => {
            proyectos.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error fetching proyectos", error);
        })

    checkUserCookies();
    checkSalidaFichaje();
});

// Función para verificar las cookies de usuario
function checkUserCookies() {
    const idUser = getCookie("idUser");
    if (idUser) {
        entradaDisabled.value = true;
        salidaDisabled.value = false;
    } else {
        entradaDisabled.value = false;
        salidaDisabled.value = true;
    }
}

// Función para verificar las cookies de salida de fichaje
function checkSalidaFichaje() {
    const horaSalida = getCookie("horaSalida");
    if (horaSalida) {
        entradaDisabled.value = false;
        salidaDisabled.value = true;
    }
}

// Función para guardar las cookies de entrada al fichar
function saveEntradaCookies() {
    const now = new Date();
    const fechaFichaje = `${now.getFullYear()}-${now.getMonth() + 1}-${now.getDate()}`;
    const horaEntrada = `${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;
    const idUser = user.value.id;

    setCookie("fechaFichaje", fechaFichaje, 1); // Cookie expira en 1 día
    setCookie("horaEntrada", horaEntrada, 1);
    setCookie("idUser", idUser, 1);
}

// Función para fichar entrada
function EntradaFichaje() {
    if (user.value.id) {
        saveEntradaCookies();
        entradaDisabled.value = true;
        salidaDisabled.value = false;
        swal({
            icon: 'success',
            title: 'Ha fichado correctamente'
        });
    } else {
        console.log("Error: debes iniciar sesión");
    }
}

// Función para fichar salida
function SalidaFichaje() {
    if (user.value.id) {
        const now = new Date();
        const horaSalida = now.toLocaleTimeString('en-US', { hour12: false });

        fichaje.value.idUser = parseInt(getCookie("idUser"), 10);
        fichaje.value.fechaFichaje = getCookie("fechaFichaje");
        fichaje.value.horaEntrada = getCookie("horaEntrada");
        fichaje.value.horaSalida = horaSalida

        axios.post('/api/fichajes', fichaje.value)
            .then(response => {
                console.log(response);
            })
            .catch(error => {
                console.log(error);
            });

        // Eliminar cookies al salir
        document.cookie = "fechaFichaje=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "horaEntrada=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "idUser=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "horaSalida=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

        salidaDisabled.value = true;
        entradaDisabled.value = false; // Habilitar el botón de entrada
        swal({
            icon: 'success',
            title: 'Ha salido correctamente'
        });
    } else {
        console.log("Error: debes iniciar sesión");
    }
}

//Función para setear cookies
function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

//Función para obtener toda la info de las cookies cuando se vuelva a entrar a la web
function getCookie(name) {
    const cookieName = name + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');
    for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cookieName) === 0) {
            return cookie.substring(cookieName.length, cookie.length);
        }
    }
    return "";
}
</script>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    components: {
        ClockComponent
    }
});
</script>

<style scoped>
/*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
html {
    line-height: 1.15;
    -webkit-text-size-adjust: 100%
}

body {
    margin: 0
}

h1,
h2,
p,
button {
    font-family: 'Nunito', sans-serif !important;
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
    box-shadow: 10px 10px 14px 2px rgba(0, 0, 0, 0.75) !important;
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

.btn-pulse {
    transition: transform 0.3s ease, box-shadow 0.4s ease;
    ;
    box-shadow: 4px 4px 4px 2px rgba(0, 0, 0, 0.75) !important;
}

.btn-pulse:active {
    transform: scale(0.95);
    box-shadow: 4px 4px 4px 2px rgba(0, 0, 0, 0) !important;
}
</style>
