<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Link } from '@inertiajs/vue3';
import Paginacao from '../../../../Componentes/Paginacao.vue';
import Filtro from './Componentes/Filtro.vue';

const props = defineProps({
    faturas: Array,
    status: Array,
});
</script>
<template>
    <DashboardLayout titulo="Faturas" categoriaPagina="fatura" pagina="faturas">

        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between w-100 align-items-center">
                <h2 class="card-title">Faturas Emitidas</h2>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <Filtro></Filtro>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Data de Vencimento</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Valor Total</th>
                            <th scope="col">Valor Pago</th>
                            <th scope="col">Status</th>
                            <th scope="col">Açoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fatura in faturas.data">
                            <th scope="row">{{ fatura.id }}</th>
                            <td>{{ fatura.data_vencimento }}</td>
                            <td>{{ fatura.cliente?.name }}</td>
                            <td>R${{ fatura.valor }}</td>
                            <td>R${{ fatura.valor_pago ?? '0,00' }}</td>
                            <td>{{ status[fatura.status] }}</td>
                            <td>
                                <div class="d-flex">
                                    <Link :href="`/dashboard/fatura/faturas/${fatura.id}/servicos`"
                                        class="btn btn-primary btn-sm me-2">
                                    Serviços
                                    </Link>
                                    <Link v-if="fatura.status !== 1" :href="`/dashboard/fatura/faturas/${fatura.id}/baixa`"
                                        class="btn btn-primary btn-sm me-2">Baixa
                                    </Link>
                                    <a :href="`/dashboard/fatura/faturas/${fatura.id}/download`"
                                        class="btn btn-primary btn-sm me-2">
                                        Download Fatura
                                    </a>
                                    <a :href="`/dashboard/fatura/faturas/${fatura.id}/recibo`"
                                        class="btn btn-primary btn-sm me-2">Download Recibo
                                    </a>
                                    <a v-if="fatura.status === 3 || fatura.status === 0"
                                        :href="`/dashboard/fatura/faturas/${fatura.id}/cancelar`"
                                        class="btn btn-danger btn-sm">
                                        Apagar Fatura
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="faturas.data.length == 0">
                            <td colspan="9" class="text-center">Nenhum fatura emitida</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Paginacao :links="faturas.links" />
        </div>
    </DashboardLayout>
</template>
