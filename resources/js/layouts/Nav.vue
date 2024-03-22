<template>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm custom-navbar">
        <div class="container">
            <router-link to="/" class="navbar-brand">DAW 2</router-link>
            <a class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mt-2 mt-lg-0 me-auto mb-2 mb-lg-0">
                    <LocaleSwitcher />
                </ul>
                <img width="20%" src="/images/logos/logoP3DAW2.svg" alt="logoMarcaImputfy">
                <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                    <template v-if="!user?.name">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/login">{{ $t('login') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/register">{{ $t('register') }}</router-link>
                        </li>
                    </template>
                    <li v-if="user?.name" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Hola, {{ user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li v-if="user.roles[0]?.name == 'admin'"><router-link class="dropdown-item"
                                    to="/admin">Gestión</router-link>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" @click="logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { computed } from "vue";
import LocaleSwitcher from "@/components/LocaleSwitcher.vue";

const store = useStore();
const user = computed(() => store.getters["auth/user"])
const { processing, logout } = useAuth();
</script>
<style scoped>
.navbar.custom-navbar {
    background-color: #053b28;
    font-size: 20px;
    height: 100px;
    font-family: 'Nunito', sans-serif;
}

.navbar.custom-navbar .nav-link {
    color: white !important;
    font-size: 20px;
}

.navbar.custom-navbar .navbar-brand {
    font-size: 20px;
    color: white !important;
}
</style>
