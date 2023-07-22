<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    fatura: Array,
});

const form = useForm({
    fatura_id: props.fatura.id,
    valorBaixar: props.fatura.valor - props.fatura.valor_pago   ,
});

const submitBaixarFatura = () => {
    form.post('/dashboard/fatura/faturas/baixar');
}

</script>
<template>
    <DashboardLayout titulo="Faturas" categoriaPagina="fatura" pagina="faturas">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Baixa da Fatura</h2>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h4>Informações Fatura</h4>
                    <div class="d-flex">
                        <div>
                            <label for="numero">Número da Fatura</label>
                            <input class="form-control" name="numero" type="text" disabled v-model="fatura.id">
                        </div>
                        <div class="ms-3">
                            <label for="data">Data Vencimento</label>
                            <input class="form-control" name="data" type="text" disabled v-model="fatura.data_vencimento">
                        </div>
                        <div class="ms-3">
                            <label for="data">Valor Total (R$)</label>
                            <input class="form-control" name="data" type="text" disabled v-model="fatura.valor">
                        </div>
                    </div>
                    <div style="width: 64%;">
                        <label for="cliente">Cliente</label>
                        <input class="form-control" name="cliente" type="text" disabled v-model="fatura.servicos[0].cliente.name">
                    </div>
                </div>
                <h4>Baixa</h4>
                <form  @submit.prevent="submitBaixarFatura">
                    <label for="valorBaixar">Valor da Baixa</label>
                    <div class="d-flex">
                        <input type="number" min="0" :max="fatura.valor - fatura.valor_pago" v-model="form.valorBaixar" class="form-control w-25" name="valorBaixar" id="valorBaixar">
                        <button type="submit" class="btn btn-primary ms-3">Baixar</button>
                    </div>
                </form>
            </div>
        </div>
    </DashboardLayout>
</template>
