
<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
</script>
<template>
    <DashboardLayout titulo="DRE Anual" categoriaPagina="dre" pagina="dre-anual">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Análise financeira anual</h2>
            </div>
            <div class="card-body overflow-auto">
                <div class="mb-3">
                    <label for="ano" class="form-label">Ano:</label>
                    <input type="number" min="2020" max="2030" id="ano" class="form-control" style="width: 260px;"
                        placeholder="Digite o ano que deseja buscar">
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col" v-for="(a, index) in Array(12)">{{ index }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-nowrap" scope=" row">Categoria teste</th>
                            <td class="text-nowrap" v-for="(a, index) in Array(12)">R${{ index * 300 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardLayout>
</template>
