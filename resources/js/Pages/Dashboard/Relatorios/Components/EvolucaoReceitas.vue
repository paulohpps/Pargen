<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';

const props = defineProps({
    evolucao_receita: Object,
    categorias: Object,
})


const dataLabels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

function mapMesesValores(categoriaData) {
    const valoresMeses = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ,0 ,0];
    categoriaData.forEach((data) => {
        const mes = parseInt(data.month);
        valoresMeses[mes - 1] = data.total;
    });
    return valoresMeses;
}

const datasets = Object.keys(props.evolucao_receita).map((categoria, index) => {
    const categoriaData = props.evolucao_receita[categoria];
    const data = mapMesesValores(categoriaData);
    return {
        label: props.categorias[categoria],

        data: data,
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
                text: 'Evolução de Receitas por Categoria'
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
