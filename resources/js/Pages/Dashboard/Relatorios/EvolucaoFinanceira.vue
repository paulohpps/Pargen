<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import axios from 'axios';
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';


let values = [
    {
        "total": 95,
        "month": "1",
        "month_name": "january"
    },
    {
        "total": 247,
        "month": "2",
        "month_name": "february"
    },
    {
        "total": 311,
        "month": "3",
        "month_name": "march"
    },
    {
        "total": 311,
        "month": "4",
        "month_name": "april"
    },
    {
        "total": 295,
        "month": "5",
        "month_name": "may"
    }
]

let chart = ref(null);

onMounted(async () => {
    new Chart(chart.value, {
        type: 'line',
        data: {
            labels: values.map(item => item.month_name),
            datasets: [
                {
                    label: "teste",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    data: values.map(item => item.total)
                }
            ]
        }
    });
})
</script>
<template>
    <DashboardLayout titulo="Evolução financeira" categoriaPagina="relatorio" pagina="evolucao_financeira">
        <p>Teste</p>
        <canvas ref="chart"></canvas>
    </DashboardLayout>
</template>
