<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
</script>
<template>
    <DashboardLayout titulo="DRE Mensal" categoriaPagina="dre" pagina="dre-mensal">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Análise financeira mensal</h2>
            </div>
            <div class="card-body overflow-auto">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col" v-for="(a, index) in Array(30)">{{ index }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-nowrap" scope=" row">Categoria teste</th>
                            <td class="text-nowrap" v-for="(a, index) in Array(30)">R${{ index * 30 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardLayout>
</template>
