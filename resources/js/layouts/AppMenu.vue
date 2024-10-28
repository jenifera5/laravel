
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
        label: 'Clients',
        items: [
            { label: 'Gestió Clients', icon: 'pi pi-fw pi pi-user', to: '/admin/clients', permision: 'clients-list' }

        ]
    },
    {
        label: 'Proveidors',
        items: [
            { label: 'Gestió Proveidors', icon: 'pi pi-fw pi pi-user', to: '/admin/proveidors', permision: 'proveidors-list' }

        ]
    },
    {
        label: 'Materials',
        items: [
            { label: 'Gestió Materials', icon: 'pi pi-fw pi pi-box', to: '/admin/materials', permision: 'materials-list' }

        ]
    },
    {
        label: 'Ordres Treball',
        items: [
            { label: 'Gestió ordres treball', icon: 'pi pi-fw pi pi-wrench', to: '/admin/ordreTreballs', permision: 'ordreTreballs-list' },
            { label: 'Gestió albarans', icon: 'pi pi-fw pi-list', to: '/admin/albarans', permision: 'all' },
            { label: 'Nou Albarà', icon: 'pi pi-fw pi-id-card', to: '/admin/albarans/create', permision: 'all' },
        ]
    },

    {
        label: 'Usuaris',
        items: [
            { label: 'Usuaris', icon: 'pi pi-fw pi-id-card', to: '/admin/users', permision: 'user-list' },
            { label: 'Rols', icon: 'pi pi-fw pi-check-square', to: '/admin/roles', permision:'role-list' },
            { label: 'Permisos', icon: 'pi pi-fw pi-bookmark', to: '/admin/permissions', permision:'permission-list' }
        ]
    },
   // {
       // label: 'Ejercicios',
       // items: [
         //   { label: 'Ejercicios', icon: 'pi pi-fw pi-id-card', to: '/admin/exercises', permision: 'exercise-list' },
           // { label: 'Categorias', icon: 'pi pi-fw pi-id-card', to: '/admin/categories', permision: 'category-list' }
         //]
     //},
    // {
    //     label: 'Posts',
    //    items: [
    //         { label: 'Posts', icon: 'pi pi-fw pi-id-card', to: '/admin/posts', permision: 'post-list' }
    //     ]
    //  }
]);
</script>


<style lang="scss" scoped></style>
