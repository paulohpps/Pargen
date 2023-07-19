<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';


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
                            <input type="date" id="inicio" class="form-control" placeholder="Pesquisar"
                                aria-label="Pesquisar" aria-describedby="button-addon2">
                        </div>
                        <div>
                            <label for="ate" class="form-label">Até:</label>
                            <input type="date" id="ate" class="form-control" placeholder="Pesquisar" aria-label="Pesquisar"
                                aria-describedby="button-addon2">
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <label for="tipo" class="form-label">Recebimentos</label>
                            <input type="text" id="tipo" disabled class="form-control" value="35000">
                        </div>
                        <div class="mb-2">
                            <label for="tipo" class="form-label">Pagamentos</label>
                            <input type="text" id="tipo" disabled class="form-control" value="35000">
                        </div>
                        <div class="mb-2">
                            <label for="tipo" class="form-label">Lucro Bruto </label>
                            <input type="text" id="tipo" disabled class="form-control" value="35000">
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
                                    <th scope="col">Valor Total</th>
                                    <th scope="col">Impacto %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoria legal</td>
                                    <td>10000</td>
                                    <td>30%</td>
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
                            <tbody>
                                <tr>
                                    <td>Categoria legal</td>
                                    <td>10000</td>
                                    <td>30%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
