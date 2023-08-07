<script setup>
import { Link } from '@inertiajs/vue3';
import DashboardLayout from '../../../Layouts/DashboardLayout.vue';
import Novo from './Componentes/Novo.vue';
import Paginacao from '../../../Componentes/Paginacao.vue';

const props = defineProps({
    lancamentos: Array,
});

function processarTipoPagamento(tipo) {
    if (tipo == 1) return "Fornecedor";
    if (tipo == 2) return "Funcionario";
    if (tipo == 3) return "Pagamentos";
}

function processarPagamento(lancamento) {
    if (lancamento.tipo_pagamento == 1) return lancamento.fornecedor?.razao_social;
    if (lancamento.tipo_pagamento == 2) return lancamento.funcionario?.nome;
    if (lancamento.tipo_pagamento == 3) return lancamento.pagamento?.descricao;
}

</script>
<template>
    <DashboardLayout titulo="Pagamentos" categoriaPagina="lancamentos" pagina="pagamentos">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Pagamentos</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adicionarModal">
                    Adicionar
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data de criação</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Pago para:</th>
                            <th scope="col">Descricão</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Vencimento</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="lancamento in lancamentos.data">
                            <td>{{ lancamento.created_at }}</td>
                            <td>{{ processarTipoPagamento(lancamento.tipo_pagamento) }}</td>
                            <td>{{ processarPagamento(lancamento) }}</td>
                            <td>{{ lancamento.descricao }}</td>
                            <td>R$ {{ lancamento.valor }}</td>
                            <td>{{ lancamento.vencimento }}</td>
                            <td>{{ lancamento.status }}</td>
                            <td>
                                <div class="d-flex">
                                    <Link :href="`/dashboard/lancamentos/${lancamento.id}/editar`" class="btn btn-primary ms-2">Editar</Link>
                                    <Link :href="`/dashboard/lancamentos/${lancamento.id}/excluir`" type="button" class="btn btn-danger ms-2">Excluir</Link>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="lancamentos.data.length == 0">
                            <td colspan="9" class="text-center">Nenhum lançamento criado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Paginacao :links="lancamentos.links" />
        </div>
        <Novo />
    </DashboardLayout>
</template>
