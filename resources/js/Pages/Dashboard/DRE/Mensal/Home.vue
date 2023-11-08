<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const props = defineProps({
    categorias: Array,
    receitas: Array,
    ano: Number,
    mes: Number,
    resultados_final: Array,
})

</script>
<template>
    <DashboardLayout titulo="DRE Mensal" categoriaPagina="dre" pagina="dre-mensal">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">DRE Mensal</h2>
            </div>
            <div class="card-body overflow-auto">
                <div class="mb-3">
                    <form class="d-flex">
                        <div class="me-3">
                            <label for="ano" class="form-label">Mês:</label>
                            <input type="number" min="1" max="12" required :value="mes" id="ano" name="mes"
                                class="form-control" style="width: 265px;" placeholder="Digite o mês que deseja buscar">
                        </div>
                        <div>
                            <label for="ano" class="form-label">Ano:</label>
                            <input type="number" min="2020" max="2030" required :value="ano" name="ano" id="ano"
                                class="form-control" style="width: 265px;" placeholder="Digite o ano que deseja buscar">
                        </div>
                        <div class="ms-3 mt-2">
                            <button type="submit" class="btn btn-primary mt-4">Buscar</button>
                        </div>
                    </form>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col" v-for="(a, index) in Array(31)">{{ index + 1 }}</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-nowrap">RECEITAS</th>
                            <td class="text-nowrap" v-for=" dia in Array(31)">-</td>
                        </tr>
                    </tbody>
                    <tbody v-for="receita in receitas">

                        <tr>
                            <th class="text-nowrap" scope=" row">
                                <i class="fa-solid fa-arrow-turn-up fa-rotate-90 me-2"></i>{{ receita.nome }}
                            </th>
                            <td class="text-nowrap" v-for="dia in receita.dias">R${{ dia.valor_total }}</td>
                            <td class="text-nowrap">R${{ Object.values(receita.dias).reduce((total, dia) => total + dia.valor_total, 0).toFixed(2) }}</td>

                        </tr>
                    </tbody>
                    <br/>
                    <tbody v-for="categoria in categorias">
                        <tr>
                            <th class="text-nowrap" scope=" row">{{ categoria.nome }}</th>
                            <td class="text-nowrap" v-for="valores in categoria.valores_por_dia">R${{ valores }}</td>
                            <td class="text-nowrap">R${{ Number(Object.values(categoria.valores_por_dia).reduce((total, numero) => total + numero, 0)).toFixed(2) }}</td>
                        </tr>

                        <tr v-for="subcategoria in categoria.subcategorias">
                            <th class="text-nowrap" scope=" row">
                                <i class="fa-solid fa-arrow-turn-up fa-rotate-90 me-2"></i>{{
                                    subcategoria.nome
                                }}
                            </th>
                            <td class="text-nowrap" v-for="valores in subcategoria.valores_por_dia">R${{ valores }}</td>
                            <td class="text-nowrap">R${{ Number(Object.values(subcategoria.valores_por_dia).reduce((total, numero) => total + numero, 0)).toFixed(2) }}</td>
                        </tr>


                    </tbody>
                    <br/>
                    <tbody>
                        <tr>
                            <th class="text-nowrap">RESULTADO FINAL</th>
                            <td class="text-nowrap" v-for="valor in resultados_final"> R${{ valor.toFixed(2) }}</td>
                            <td class="text-nowrap">R${{ Number(Object.values(resultados_final).reduce((total, numero) => total + numero, 0)).toFixed(2) }}</td>
                        </tr>
                    </tbody>
                    <tbody v-if="categorias.length === 0">
                        <tr>
                            <td colspan="33" class="text-center">Nenhum dado encontrado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardLayout>
</template>
