<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Link } from '@inertiajs/vue3';
import Paginacao from '../../../../Componentes/Paginacao.vue';

const props = defineProps({
    faturas: Array,
    status: Array,
});
</script>
<template>
    <DashboardLayout titulo="Faturas" categoriaPagina="fatura" pagina="Baixa de faturas">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Faturas Emitidas para baixa</h2>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data de Emissão</th>
                            <th scope="col">Data de Vencimento</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Status</th>
                            <th scope="col">Açoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fatura in faturas.data">
                            <td>{{ fatura.data_emissao }}</td>
                            <td>{{ fatura.data_vencimento }}</td>
                            <td>R$ {{ fatura.valor }}</td>
                            <td>{{ status[fatura.status] }}</td>
                            <td>
                                <div class="d-flex">
                                    <Link v-if="fatura.status === 0" :href="`/dashboard/fatura/faturas/${fatura.id}/baixa`"
                                        class="btn btn-primary btn-sm">Baixa</Link>
                                    <a :href="`/dashboard/fatura/faturas/${fatura.id}/download`"
                                        class="btn btn-primary btn-sm ms-2">Download</a>
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
