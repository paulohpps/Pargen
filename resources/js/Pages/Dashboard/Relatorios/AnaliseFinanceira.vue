<script setup>
import AnaliseFinanceiraHeader from './Componentes/AnaliseFinanceiraHeader.vue'


</script>
<template>
    <AnaliseFinanceiraHeader>
        <div class="input-group mb-3">
            <div>
                <label for="basic-url" class="form-label">A partir de:</label>
                <input type="date" id="basic-url" class="form-control" placeholder="Pesquisar" aria-label="Pesquisar"
                    aria-describedby="button-addon2">
            </div>
            <div class="ms-2">
                <label for="basic-url2" class="form-label">Até:</label>
                <input type="date" id="basic-url2" class="form-control" placeholder="Pesquisar" aria-label="Pesquisar"
                    aria-describedby="button-addon2">
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
    </AnaliseFinanceiraHeader>
</template>
