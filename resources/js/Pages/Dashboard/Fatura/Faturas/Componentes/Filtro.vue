<script setup>
import { defineProps } from 'vue';
import SelectAjax from '@/Componentes/Forms/SelectAjax.vue';

const props = defineProps({
    clientes: Array,
    status: Array,
});

let options = [
    { value: 0, text: 'Todos' },
    { value: 1, text: 'Aberto' },
    { value: 2, text: 'Pago' },
    { value: 3, text: 'Cancelado' },
];

</script>
<template>
    <SelectAjax href="/dashboard/clientes/pesquisar" pre placeholder="Selecione um cliente" />
</template>
