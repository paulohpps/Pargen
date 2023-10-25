<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const props = defineProps({
    categorias: Array,
    ano: Number
})

let ano = new URL(document.URL).searchParams.get('ano') ?? new Date().getFullYear();

</script>
<template>
    <DashboardLayout titulo="DRE Anual" categoriaPagina="dre" pagina="dre-anual">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Análise financeira anual</h2>
            </div>
            <div class="card-body overflow-auto">
                <div class="mb-3">
                    <form>
                        <label for="ano" class="form-label">Ano:</label>
                        <input type="number" min="2020" max="2030" :value="ano" id="ano" name="ano" class="form-control"
                            style="width: 265px;" placeholder="Digite o ano que deseja buscar">
                    </form>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col" v-for="(a, index) in Array(12)">{{ index + 1 }}</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody v-for="categoria in categorias">
                        <tr>
                            <th class="text-nowrap" scope=" row">{{ categoria.nome }}</th>
                            <td class="text-nowrap" v-for="valores in categoria.valores_por_mes">R${{ valores }}</td>
                            <td class="text-nowrap">R${{ Number(Object.values(categoria.valores_por_mes).reduce((total, numero) => total + numero, 0)).toFixed(2) }}</td>
                        </tr>
                        <tr v-for="subcategoria in categoria.subcategorias">
                            <th class="text-nowrap" scope=" row"><i
                                    class="fa-solid fa-arrow-turn-up fa-rotate-90 me-2"></i>{{
                                        subcategoria.nome
                                    }}</th>
                            <td class="text-nowrap" v-for="valores in subcategoria.valores_por_mes">R${{ valores }}</td>
                            <td class="text-nowrap">R${{ Number(Object.values(subcategoria.valores_por_mes).reduce((total, numero) => total + numero, 0)).toFixed(2) }}</td>
                        </tr>
                    </tbody>
                    <tbody v-if="categorias.length === 0">
                        <tr>
                            <td colspan="13" class="text-center">Nenhum dado encontrado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardLayout>
</template>
