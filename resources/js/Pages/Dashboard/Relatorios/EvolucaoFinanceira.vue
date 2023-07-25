<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import EvolucaoReceitas from './Components/EvolucaoReceitas.vue';
import EvolucaoPagamentos from './Components/EvolucaoPagamentos.vue';

const props = defineProps({
    evolucao_receita: Object,
    categorias_analise: Object,
    evolucao_pagamentos: Object,
})

</script>
<template>
    <DashboardLayout titulo="Evolução financeira" categoriaPagina="relatorio" pagina="evolucao_financeira">
        <div class="card w-100" style="background-color: transparent;">
            <div class="card-body">
                <h5 class="card-title">Evolução financeira</h5>
                <form style="width: 180px;">
                    <input type="number" name="ano" required class="form-control" placeholder="Ano" min="2020" max="2030" />
                </form>
            </div>
        </div>
        <EvolucaoReceitas :evolucao_receita="evolucao_receita" :categorias="categorias_analise" />
        <EvolucaoPagamentos :evolucao_pagamentos="evolucao_pagamentos"  />
    </DashboardLayout>
</template>
<style></style>
