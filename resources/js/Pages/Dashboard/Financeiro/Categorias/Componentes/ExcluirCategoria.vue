<script setup >
import { defineProps, ref, onMounted, getCurrentInstance } from 'vue';
import { Modal } from 'bootstrap';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    categoriaId: Number,
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

function submitExcluirCategoria() {
    router.visit(`/dashboard/financeiro/categorias/${props.categoriaId}/excluir`)
}

</script>
<template>
    <div>
    <div class="modal fade" ref="modalEl" id="excluirCatModal" tabindex="-1" aria-labelledby="excluirModalCatLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="excluirModalCatLabel">Deseja Excluir a Categoria e suas Subcategorias?</h1>
                    <button type="button" @click="closeModal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitExcluirCategoria(), closeModal()">
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
