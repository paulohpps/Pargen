<script setup>
import { ref, onMounted, getCurrentInstance } from 'vue';
import { Modal } from 'bootstrap';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    receitaId: Number,
})

let modalEl = ref(null)
let modal = null
let emit = null;

onMounted(() => {
    const instance = getCurrentInstance()
    emit = instance.emit

    modal = new Modal(modalEl.value, {
        keyboard: false,
        backdrop: 'static',
    });
    modal.show();
})

function closeModal() {
    modal.hide()
    emit('close-modal')
}

function submitExcluirPagamento() {
    router.visit(`/dashboard/financeiro/receitas/${props.receitaId}/excluir/`)
}

</script>
<template>
    <div>
        <div class="modal fade" ref="modalEl" id="excluirModal" tabindex="-1" aria-labelledby="excluirModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="excluirModalLabel">Realmente Deseja Excluir essa receita?</h1>
                        <button type="button" @click="closeModal()" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="submitExcluirPagamento(), closeModal()">
                        <div class="modal-body grid">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                @click="closeModal()">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 10px;
}
</style>
