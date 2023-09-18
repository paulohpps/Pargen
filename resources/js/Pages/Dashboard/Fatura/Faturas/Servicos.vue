<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const props = defineProps({
    fatura: Array,
});
</script>
<template>
    <DashboardLayout titulo="Faturas" categoriaPagina="fatura" pagina="faturas">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Serviços da Fatura {{ fatura.id }}</h2>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data Coleta</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Analise</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="servico in fatura.servicos">
                            <td>{{ servico.collect_date }}</td>
                            <td>{{ servico.pet }}</td>
                            <td>{{ servico.analises.map(analise => analise?.name).join(', ') }}</td>
                            <td>{{ fatura.cliente?.name }}</td>
                            <td>R$ {{ servico.analises.reduce((accumulator, analise) => {
                                return accumulator + analise.price;
                            }, 0) }}</td>
                        </tr>
                        <tr v-if="fatura.servicos === 0">
                            <td colspan="8" class="text-center">Nenhum Serviço Cadastrado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardLayout>
</template>
