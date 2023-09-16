<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Paginacao from '../../../../Componentes/Paginacao.vue';


const props = defineProps({
    servicos: Array,
    categorias_analise: Array,
    categorias_cliente: Array,
    fatura_status: Array,
});

</script>
<template>
    <DashboardLayout titulo="Serviços" categoriaPagina="lancamentos" pagina="servicos">
        <div class="card shadow tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="card-title">Serviços</h2>
                    <h6>{{ servicos.total }} resultados</h6>
                </div>
                <div>
                    <label for="">V</label>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data Coleta</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Analise</th>
                            <th scope="col">N° Amostra</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Valor Unit.</th>
                            <th scope="col">Categoria Analise</th>
                            <th scope="col">Tipo Cliente</th>
                            <th scope="col">N° Fatura</th>
                            <th scope="col">Data Vencimento</th>
                            <th scope="col">Data Recebimento</th>
                            <th scope="col">Status Fatura</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="servico in servicos.data">
                            <td>{{ servico.collect_date }}</td>
                            <td>{{ servico.pet }}</td>
                            <td>{{ servico.analises.map(analise => analise.name).join(', ') }}</td>
                            <td>{{ servico.request_number }}</td>
                            <td>{{ servico?.cliente?.name }}</td>
                            <td>R${{ servico.analises.reduce((accumulator, analise) => {
                                return accumulator + analise.price;
                            }, 0) }}</td>
                            <td>{{ servico.analises.map(analise =>
                                categorias_analise[analise?.categoria_analise?.categoria]).join(', ') || 'Nenhuma categoria'
                            }}</td>
                            <td>{{ categorias_cliente[servico.cliente?.cliente_categoria?.categoria] ?? 'Não cadastrado' }}
                            </td>
                            <td>{{ servico.fatura_id ?? 'Não Faturado' }}</td>
                            <td>{{ servico?.fatura?.data_vencimento ?? '-' }}</td>
                            <td>{{ servico?.fatura?.data_recebimento ?? '-' }}</td>
                            <td>{{ fatura_status[servico?.fatura?.status] ?? '-' }}</td>
                        </tr>
                        <tr v-if="servicos.data.length === 0">
                            <td colspan="8" class="text-center">Nenhum Serviço Cadastrado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Paginacao :links="servicos.links" />
        </div>
    </DashboardLayout>
</template>
