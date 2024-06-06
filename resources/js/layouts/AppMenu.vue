
<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<script setup>
import { ref } from 'vue';
import AppMenuItem from './AppMenuItem.vue';
import {useAbility} from '@casl/vue'
const {can} = useAbility();

const vela = "pepe";


const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/admin', permision: 'all'}]
    },
    {
        label: 'GESTIÓN IMPUTFY',
        items: [
            { label: 'Users', icon: 'pi pi-fw pi-id-card', to: '/admin/users', permision: 'user-list' },
            { label: 'Roles', icon: 'pi pi-fw pi-check-square', to: '/admin/roles', permision:'role-list' },
            { label: 'Permisos', icon: 'pi pi-fw pi-bookmark', to: '/admin/permissions', permision:'permission-list' },
            { label: 'Proyectos', icon: 'pi pi-server', to: '/admin/proyectos', permision:'permission-list' },
            { label: 'Imputaciones', icon: 'pi pi-folder-open', to: '/admin/imputaciones', permision:'permission-list' },
            { label: 'Fichajes', icon: 'pi pi-paperclip', to: '/admin/fichajes', permision:'permission-list' },
            { label: 'Skills', icon: 'pi pi-briefcase', to: '/admin/skills', permision:'permission-list' },
            { label: 'Tecnologias', icon: 'pi pi-cog', to: '/admin/tecnologias', permision:'permission-list' }
        ]
    }
]);
</script>


<style lang="scss" scoped></style>
