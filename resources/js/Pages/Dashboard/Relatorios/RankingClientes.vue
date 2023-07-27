<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';


const props = defineProps({
    clientes: Array,
    ano: Number,
    mes: Number
})

let chart = ref(null);
onMounted(async () => {
    new Chart(chart.value, {
        type: 'bar',
        data: {
            labels: props.clientes.map(item => item.nome),
            datasets: [
                {
                    label: "Ranking Clientes",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    data: props.clientes.map(item => item.total)
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    onClick: null
                }
            }
        }
    });
})

</script>
<template>
    <DashboardLayout titulo="Ranking cliente" categoriaPagina="relatorio" pagina="ranking_cliente">
        <h1>Ranking Clientes</h1>
        <form class="d-flex">
            <div class="mb-2">
                <label for="inicio" class="form-label">Mês:</label>
                <input type="number" id="inicio" min="1" max="12" :value="mes" name="mes" class="form-control" required
                    aria-label="Pesquisar" aria-describedby="button-addon2">
            </div>
            <div class="ms-3">
                <label for="ate" class="form-label">Ano:</label>
                <div class="d-flex">
                    <input type="number" name="ano" min="2022" max="2030" :value="ano" id="ate" class="form-control"
                        required aria-label="Pesquisar" aria-describedby="button-addon2">
                    <button class="btn btn-primary ms-3">Pesquisar</button>
                </div>
            </div>
        </form>
        <canvas ref="chart"></canvas>
    </DashboardLayout>
</template>
