<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <DashboardLayout titulo="Lançamentos" categoriaPagina="relatorio" pagina="analise_financeira">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Análise financeira</h2>
                <div class="row">
                    <Link href="#" class="btn btn-primary col-12 mb-2">
                    Recebimentos
                    </Link>
                    <Link href="#" class="btn btn-primary col-12">
                    Pagamentos
                    </Link>
                </div>
            </div>
            <div class="card-body">
                <slot />
            </div>
        </div>
    </DashboardLayout>
</template>
