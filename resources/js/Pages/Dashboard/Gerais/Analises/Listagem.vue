<script setup>
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Paginacao from '../../../../Componentes/Paginacao.vue';
import Categoria from './Componentes/Categoria.vue';

const props = defineProps({
    analises: Array,
    categorias: Array,
});

let showEditar = ref(false);
let analise;

function editar(id) {
    analise = props.analises.data.find((analise) => analise.id === id);
    showEditar.value = true;
}

</script>
<template>
    <DashboardLayout titulo="Analises" categoriaPagina="geral" pagina="analises">
        <div class="card shadow tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Analises</h2>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Categoria Receita</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="analise in analises.data">
                            <td>{{ analise.name }}</td>
                            <td>R$ {{ analise.price }}</td>
                            <td>{{ categorias[analise.categoria_analise?.categoria] ?? 'Nenhuma Categoria Selecionada'
                            }}</td>
                            <td>
                                <button class="btn btn-primary" @click="editar(analise.id)">
                                    Selecionar Categoria
                                </button>
                            </td>
                        </tr>
                        <tr v-if="analises.data.length === 0">
                            <td colspan="8" class="text-center">Nenhuma analise cadastrada</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Paginacao :links="analises.links" />
            <Categoria :categorias="categorias" v-if="showEditar" :analise="analise"
                @close-modal="showEditar = !showEditar" />
        </div>
    </DashboardLayout>
</template>
