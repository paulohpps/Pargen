<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    pagamentos: Object,
    receitas: Object,
    lucro_total: String,
})

let route = new URL(document.location.href);

function filtrarApartir(data) {
    route.searchParams.set('inicio', data.target.value);
    router.visit(route.href)
}

function filtrarAte(data) {
    route.searchParams.set('ate', data.target.value);
    router.visit(route.href)
}

</script>
<template>
    <DashboardLayout titulo="Lançamentos" categoriaPagina="relatorio" pagina="analise_financeira">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Análise financeira</h2>

            </div>
            <div class="card-body">
                <div class="input-group mb-3 d-flex justify-content-between">
                    <div>
                        <div class="mb-2">
                            <label for="inicio" class="form-label">A partir de:</label>
                            <input @change="filtrarApartir" :value="route.searchParams.get('inicio')" type="date"
                                id="inicio" class="form-control" placeholder="Pesquisar" aria-label="Pesquisar"
                                aria-describedby="button-addon2">
                        </div>
                        <div>
                            <label for="ate" class="form-label">Até:</label>
                            <input @change="filtrarAte" :value="route.searchParams.get('ate')" type="date" id="ate"
                                class="form-control" placeholder="Pesquisar" aria-label="Pesquisar"
                                aria-describedby="button-addon2">
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <label for="tipo" class="form-label">Recebimentos</label>
                            <input type="text" id="tipo" disabled class="form-control" :value="'R$' + receitas.total_geral">
                        </div>
                        <div class="mb-2">
                            <label for="tipo" class="form-label">Pagamentos</label>
                            <input type="text" id="tipo" disabled class="form-control"
                                :value="'R$' + pagamentos.total_geral">
                        </div>
                        <div class="mb-2">
                            <label for="tipo" class="form-label">Lucro Bruto </label>
                            <input type="text" id="tipo" disabled class="form-control" :value="'R$' + lucro_total">
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="w-50">
                        <h4>Recebimentos</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Impacto %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in receitas.categorias">
                                    <td>{{ categoria.nome }}</td>
                                    <td>R${{ categoria.total }}</td>
                                    <td>{{ categoria.impacto }}%</td>
                                </tr>
                                <tr v-if="!receitas.categorias">
                                    <td colspan="3" class="text-center">Nenhum registro encontrado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="w-50 ms-3">
                        <h4>Pagamentos</h4>
                        <table class="table table-hover ">
                            <thead>
                                <tr>
                                    <th scope="col">Tipo Despesa</th>
                                    <th scope="col">Valor Total</th>
                                    <th scope="col">Impacto %</th>
                                </tr>
                            </thead>
                            <tbody v-for="categoria in pagamentos.categorias">
                                <tr>
                                    <td>{{ categoria.nome }}</td>
                                    <td>R${{ categoria.total_categoria }}</td>
                                    <td>{{ categoria.impacto }}%</td>
                                </tr>
                                <tr v-for="sub in categoria.subcategorias">
                                    <td><i class="fa-solid fa-arrow-turn-up fa-rotate-90 me-2"></i>{{ sub.nome }}</td>
                                    <td>R${{ sub.valor }}</td>
                                    <td>{{ sub.impacto }}%</td>
                                </tr>
                            </tbody>
                            <tbody v-if="pagamentos.categorias.length === 0">
                                <tr>
                                    <td colspan="3" class="text-center">Nenhum registro encontrado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
