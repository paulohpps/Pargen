<script setup>
import Grafico from './Grafico.vue';

</script>
<template>
    <div class="card shadow mt-3 w-100">
        <div class="card-body">
            <div class="d-flex justify-content-around">
                <Grafico titulo="Serviços nos ultimos 6 meses" url="/dashboard/relatorios/servicos" />
                <Grafico titulo="Faturamento nos ultimos 6 meses" url="/dashboard/relatorios/servicos/faturamento" />
            </div>
        </div>
    </div>
</template>
