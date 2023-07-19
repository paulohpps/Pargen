<script setup>
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Link } from '@inertiajs/vue3';
import Novo from './Componentes/Novo.vue';
import Excluir from './Componentes/Excluir.vue';
import Paginacao from '@/Componentes/Paginacao.vue';


const props = defineProps({
    receitas: Array,
    categorias: Array,
});

let showModalExcluir = ref(false)
let receitaId = ref(null)
function openModalExcluir(id) {
    showModalExcluir.value = true
    receitaId.value = id
}
</script>
<template>
    <DashboardLayout titulo="Pagamentos" categoriaPagina="financeiro" pagina="receitas">
        <div class="card shadow tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Receitas</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adicionarModal">
                    Adicionar
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col">Categoria da receita</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="receita in receitas.data">
                            <td>{{ receita.descricao }}</td>
                            <td>{{ receita.categoria.nome }} - {{ receita.subcategoria.nome }}</td>
                            <td>
                                <div class="d-flex">
                                    <Link :href="`/dashboard/financeiro/receitas/${receita.id}/editar`"
                                        class="btn btn-primary ms-2"> Editar </Link>
                                    <button type="button" class="btn btn-danger ms-2"
                                        @click="openModalExcluir(receita.id)">Excluir</button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="receitas.data.length === 0">
                            <td colspan="8" class="text-center">Nenhuma receita cadastrada</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Novo :categorias="categorias" />
            <Excluir v-if="showModalExcluir" :receitaId="receitaId" @close-modal="showModalExcluir = false" />
            <Paginacao :links="receitas.links" />
        </div>
    </DashboardLayout>
</template>
