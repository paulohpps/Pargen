<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Graficos from './Components/Graficos.vue';

</script>
<template>
    <DashboardLayout titulo="Home">
        <div class="container">
            <h1>Home</h1>
            <Graficos />
        </div>
    </DashboardLayout>
</template>
<style>
.grafico-servicos,
.grafico-faturamento {
    width: 500px;
    height: 500px;
}
</style>
