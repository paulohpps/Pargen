<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import axios from 'axios';
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';


const data = {
    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
        'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    datasets: [
        {
            label: 'Análise Clínica em Pets',
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            data: [10, 30, 20, 40, 25, 35, 15, 5, 25, 15, 35, 10],
            fill: false,
        },
        {
            label: 'Controle de Qualidade em Aviário',
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            data: [5, 15, 25, 20, 30, 10, 35, 15, 5, 25, 15, 35],
            fill: false,
        },
        {
            label: 'Diagnóstico Molecular em Pets',
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            data: [20, 10, 30, 15, 5, 25, 15, 35, 10, 30, 20, 40],
            fill: false,
        }
    ]
};

const config = {
    type: 'line',
    data: data,
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Evolução financeira'
            }
        },
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Mês'
                }
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: 'Valores'
                }
            }
        }
    }
};

let chart = ref(null);
let chart_2 = ref(null);

onMounted(async () => {
    new Chart(chart.value, config);
    new Chart(chart_2.value, config);
})
</script>
<template>
    <DashboardLayout titulo="Evolução financeira" categoriaPagina="relatorio" pagina="evolucao_financeira">

        <canvas ref="chart" height="80"></canvas>
        <canvas ref="chart_2" height="80"></canvas>
    </DashboardLayout>
</template>
<style></style>
