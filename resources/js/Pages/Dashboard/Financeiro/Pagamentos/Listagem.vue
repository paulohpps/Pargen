<script setup>
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Link } from '@inertiajs/vue3';
import Novo from './Componentes/Novo.vue';
import Excluir from './Componentes/Excluir.vue';
import Paginacao from '../../../../Componentes/Paginacao.vue';


const props = defineProps({
    pagamentos: Array,
    categorias: Array,
});

let showModalExcluir = ref(false)
let pagamentoId = ref(null)
function openModalExcluir(id) {
    showModalExcluir.value = true
    pagamentoId.value = id
}
</script>
<template>
    <DashboardLayout titulo="Pagamentos" categoriaPagina="financeiro" pagina="pagamentos">
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
                            <th scope="col">Descrição</th>
                            <th scope="col">Categoria de Pagamento</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pagamento in pagamentos.data">
                            <td>{{ pagamento.descricao }}</td>
                            <td>{{ pagamento.categoria.nome }} - {{ pagamento.subcategoria.nome }}</td>
                            <td>
                                <div class="d-flex">
                                    <Link :href="`/dashboard/financeiro/pagamentos/${pagamento.id}/editar`"
                                        class="btn btn-primary ms-2"> Editar </Link>
                                    <button type="button" class="btn btn-danger ms-2"
                                        @click="openModalExcluir(pagamento.id)">Excluir</button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="pagamentos.data.length === 0">
                            <td colspan="8" class="text-center">Nenhum pagamento cadastrado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Novo :categorias="categorias" />
            <Excluir v-if="showModalExcluir" :pagamentoId="pagamentoId" @close-modal="showModalExcluir = false" />
            <Paginacao :links="pagamentos.links" />
        </div>
    </DashboardLayout>
</template>
