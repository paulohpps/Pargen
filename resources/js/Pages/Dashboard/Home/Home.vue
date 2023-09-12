<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Graficos from './Components/Graficos.vue';

</script>
<template>
    <DashboardLayout titulo="Home">
        <div class="card shadow mt-3 w-100">
            <div class="card-header">
                <h1 class="card-title">Laboratorio Pargen - Home</h1>
            </div>
            <div class="card-body">
                <Graficos />
            </div>
        </div>
    </DashboardLayout>
</template>
