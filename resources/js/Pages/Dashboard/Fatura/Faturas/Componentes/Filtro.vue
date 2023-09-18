<script setup>
import { useForm } from '@inertiajs/vue3';
import SelectAjax from '@/Componentes/Forms/SelectAjax.vue';

const form = useForm({
    cliente_id: parseInt(new URL(document.URL).searchParams.get('cliente_id') ?? 0),
    status: parseInt(new URL(document.URL).searchParams.get('status') ?? 0),
});

function submitFiltrarFaturas() {
    form.get('/dashboard/fatura/faturas');
}

function optionSelected(option) {
    form.cliente_id = option.id;
}

</script>
<template>
    <form @submit.prevent="submitFiltrarFaturas">
        <div class="d-flex">
            <div class="m-2">
                <p>Cliente:</p>
                <SelectAjax @optionSelected="optionSelected" class="seletor" href="/dashboard/clientes/pesquisar" preBusca
                    placeholder="Selecione um cliente" :modelValue="form.cliente_id" />
            </div>
            <div class="m-2">
                <p>Status:</p>
                <select v-model="form.status" class="form-control seletor2">
                    <option :value="0">Aberto</option>
                    <option :value="1">Paga</option>
                    <option :value="2">Cancelado</option>
                    <option :value="3">Atrasada</option>
                    <option :value="4">Parcialmente Paga</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary m-2 mt-5" style="width: 150px;">Filtrar</button>
            </div>
        </div>
    </form>
</template>

<style scoped>
.seletor {
    width: 450px;
}

.seletor2 {
    width: 200px;
}
</style>
