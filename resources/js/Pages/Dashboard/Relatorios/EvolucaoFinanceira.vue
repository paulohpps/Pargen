<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import EvolucaoReceitas from './Components/EvolucaoReceitas.vue';
import EvolucaoPagamentos from './Components/EvolucaoPagamentos.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    evolucao_receita: Object,
    categorias_analise: Object,
    evolucao_pagamentos: Object,
})


let route = new URL(document.location.href);

let ano = route.searchParams.get('ano') ?? new Date().getFullYear();

function filtrarAno() {
    route.searchParams.set('ano', ano);
    router.visit(route.href)
}

</script>
<template>
    <DashboardLayout titulo="Evolução financeira" categoriaPagina="relatorio" pagina="evolucao_financeira">
        <div class="card w-100" style="background-color: transparent;">
            <div class="card-body">
                <h5 class="card-title">Evolução financeira</h5>
                <form @submit.prevent="filtrarAno" style="width: 180px;">
                    <input type="number" v-model="ano" name="ano" required class="form-control" placeholder="Ano" min="2020"
                        max="2030" />
                </form>
            </div>
        </div>
        <EvolucaoReceitas :evolucao_receita="evolucao_receita" :categorias="categorias_analise" />
        <EvolucaoPagamentos :evolucao_pagamentos="evolucao_pagamentos" />
    </DashboardLayout>
</template>
<style></style>
