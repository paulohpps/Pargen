<script setup>
import { usePage } from '@inertiajs/vue3';

</script>
<template>
    <div v-if="usePage().props.mensagem" class="toast-container position-fixed bottom-0 end-0 p-3 ">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">{{ usePage().props.mensagem?.tipo == 'success' ? 'Sucesso' : 'Erro' }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <label :class="usePage().props.mensagem?.class">
                    {{ usePage().props?.mensagem?.conteudo }}
                </label>
            </div>
        </div>
    </div>
</template>
<style>
@keyframes slideIn {
    0% {
        transform: translateY(100%);
    }

    100% {
        transform: translateY(0);
    }
}

.toast {
    animation: slideIn 0.7s ease-in-out;
}
</style>
