<template>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm custom-navbar fixed-top">
        <div class="" style="display: flex; width: 100%; justify-content: center; align-items: center">
            
            <ul class="user-options" style="width: 33%; display: flex; list-style-type: none; padding-left: 20px; margin: 0;">
                <LocaleSwitcher />
            </ul>
            
            <a width="33%" height="90px" href="/">
                <img width="100%" height="90px" src="/images/logos/logoP3DAW2.svg" alt="logoMarcaImputfy">
            </a>
            
            <ul class="user-options" style="width: 33%; display: flex; justify-content: right !important; list-style-type: none; padding-right: 20px; margin: 0;">
                <template v-if="!user?.name">
                    <li class="nav-item" style="margin-right: 20px;">
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
                    <ul class="dropdown-menu dropdown-menu-end despliegue-opts">
                        <li v-if="user.roles[0]?.name == 'admin'"><router-link
                                class="dropdown-item dropdown-item-custom" to="/admin">Gestión</router-link>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item dropdown-item-custom" href="javascript:void(0)"
                                @click="logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { computed, ref } from "vue";
import LocaleSwitcher from "@/components/LocaleSwitcher.vue";

const store = useStore();
const user = computed(() => store.getters["auth/user"])
const { processing, logout } = useAuth();
const isMenuOpen = ref(false);
</script>

<style scoped>
.width-33 {
    width: 33% !important;
}

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

.dropdown-item-custom:hover {
    background-color: #04744d !important;
    color: white !important;
}

@media (max-width: 768px) {
 .user-options a{
    font-size: 16px !important;
 }

 .despliegue-opts a{
    font-size: 14px !important;
 }
}
</style>
