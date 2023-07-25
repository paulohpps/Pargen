<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';

const props = defineProps({
    evolucao_pagamentos: Object
})

const dataLabels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

function mapMesesValores(categoriaData) {
    const valoresMeses = dataLabels.map((mes, index) => categoriaData || 0);
    return valoresMeses;
}

console.log(props.evolucao_pagamentos)

const datasets = Object.keys(props.evolucao_pagamentos).map((pagamento, index) => {
    const categoriaData = pagamento.meses

    const data = mapMesesValores(categoriaData);
    return {
        label: props.evolucao_pagamentos.map((categoria, index) => { return categoria.nome; }),

        data: props.evolucao_pagamentos.map((categoria, index) => { return categoria.meses[index]; }),
        fill: false,
    };
});

console.log(datasets[0].data)

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
                text: 'Gráfico de Linhas com Três Categorias'
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
    <canvas ref="chart" height="80"></canvas>
</template>
