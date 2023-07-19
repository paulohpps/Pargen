<script setup>
import { Head, Link } from "@inertiajs/vue3";
import "../../css/Dashboard.css";
import Header from "./Header.vue";
import SidebarMax from "./SidebarMax.vue";
import Notificacoes from "@/Componentes/Helper/Notificacoes.vue";

const props = defineProps({
    titulo: String,
    categoriaPagina: String,
    pagina: String,
});



</script>
<template>
    <div class="d-flex" id="wrapper">

        <Head :title="`Laboratorio Pargen - ${titulo}`" />
        <Header></Header>
        <Notificacoes></Notificacoes>
        <SidebarMax :categoriaPagina="categoriaPagina" :pagina="pagina"></SidebarMax>
    </div>
    <div class="container-custom">
        <slot />
    </div>
</template>
