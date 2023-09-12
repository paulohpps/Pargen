<script setup>
import axios from 'axios';
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';


const props = defineProps({
    titulo: String,
    url: String
})
let chart = ref(null);
onMounted(async () => {
    let response = await axios.get(props.url);
    new Chart(chart.value, {
        type: 'bar',
        data: {
            labels: translate(response.data),
            datasets: [
                {
                    label: props.titulo,
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    data: response.data.map(item => item.total)
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

function translate(array) {
    let meses = [];
    array.forEach(item => {
        switch (item.month) {
            case 1:
                meses.push('Janeiro');
                break;
            case 2:
                meses.push('Fevereiro');
                break;
            case 3:
                meses.push('Março');
                break;
            case 4:
                meses.push('Abril');
                break;
            case 5:
                meses.push('Maio');
                break;
            case 6:
                meses.push('Junho');
                break;
            case 7:
                meses.push('Julho');
                break;
            case 8:
                meses.push('Agosto');
                break;
            case 9:
                meses.push('Setembro');
                break;
            case 10:
                meses.push('Outubro');
                break;
            case 11:
                meses.push('Novembro');
                break;
            case 12:
                meses.push('Dezembro');
                break;
        }
    });
    return meses;
}


</script>
<template>
    <div class="grafico">
        <canvas ref="chart"></canvas>
    </div>
</template>
<style>
.grafico {
    width: 50%;
    height: 50%;
}
</style>
