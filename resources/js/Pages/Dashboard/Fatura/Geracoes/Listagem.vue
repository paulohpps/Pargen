<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Link } from '@inertiajs/vue3';
import Paginacao from '../../../../Componentes/Paginacao.vue';

const props = defineProps({
    servicos: Array,
    analises: Array,
    categorias: Array,
});
</script>
<template>
    <DashboardLayout titulo="Faturas" categoriaPagina="fatura" pagina="faturar">

        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Serviços a faturar</h2>
                <Link href="/dashboard/fatura/faturar" class="btn btn-primary ms-2"> Faturar Serviços </Link>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data de coleta</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Analise</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Categoria Cliente</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="servico in servicos.data">
                            <td>{{ servico.collect_date }}</td>
                            <td>{{ servico.pet }}</td>
                            <td>{{ servico.analises.map(analise => analise.name).join(', ') }}</td>
                            <td>{{ servico.cliente.name }}</td>
                            <td>{{ categorias[servico.cliente.cliente_categoria[0]?.categoria] ?? 'Nenhuma categoria cadastrada' }}</td>
                            <td>{{ servico.analises.reduce((acumulador, analise) => acumulador + analise.price, 0) }}</td>
                        </tr>
                        <tr v-if="servicos.data.length === 0">
                            <td colspan="9" class="text-center">Nenhum serviço a faturar</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Paginacao :links="servicos.links" />
        </div>
    </DashboardLayout>
</template>
