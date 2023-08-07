<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';

const props = defineProps({
    evolucao_pagamentos: Object
})

const dataLabels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

const datasets = props.evolucao_pagamentos.map((pagamento, index) => {
    let dados = Array.from({ length: 12 }, (_, mes) => {
        return pagamento.meses[mes + 1] || 0;
    });
    
    return {
        label: pagamento.nome,

        data: dados,
        fill: false,
    };
});

if (!datasets.length) {
    datasets.push({
        label: 'Sem dados',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        fill: false,
    })
}

const config = {
    type: 'line',
    data: {
        labels: dataLabels,
        datasets: datasets,
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Evolução de Pagamentos por Categoria'
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Mês'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Valores R$'
                }
            }
        }
    }
};


let chart = ref(null);

onMounted(async () => {
    new Chart(chart.value, config);
})
</script>
<template>
    <canvas ref="chart" height="70"></canvas>
</template>
