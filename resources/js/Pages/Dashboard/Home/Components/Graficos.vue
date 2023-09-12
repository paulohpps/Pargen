<script setup>
import Grafico from './Grafico.vue';

</script>
<template>
    <div class="d-flex justify-content-around">
        <Grafico titulo="Serviços nos ultimos 6 meses" url="/dashboard/relatorios/servicos" />
        <Grafico titulo="Faturamento nos ultimos 6 meses" url="/dashboard/relatorios/servicos/faturamento" />
    </div>
</template>
