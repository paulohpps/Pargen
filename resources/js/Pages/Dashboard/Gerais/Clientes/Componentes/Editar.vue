<script setup>

import { useForm } from '@inertiajs/vue3';
import { Modal } from 'bootstrap';
import { defineProps, ref, onMounted, getCurrentInstance } from 'vue';

const props = defineProps({
    cliente: Object,
    categorias: Array,
});
let modal;
let modalEl = ref(null);
let emit = null;

const form = useForm({
    categoria: props.cliente.cliente_categoria[0]?.categoria,
    usuario_id: props.cliente.id,
});

onMounted(() => {
    const instance = getCurrentInstance()
    emit = instance.emit
    modal = new Modal(modalEl.value, {
        keyboard: false,
        backdrop: 'static',
    });
    modal.show();
})

function submitEditar() {
    form.post("/dashboard/clientes/editar/categoria", {
        onSuccess: () => {
            closeModal();
        },
    });
}

function closeModal() {
    modal.hide();
    emit('close-modal')

}
</script>
<template>
    <div class="modal fade" id="" ref="modalEl" tabindex="-1" aria-labelledby="adicionarSubcategoriaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="adicionarSubcategoriaLabel">Editar Categoria do cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" @click="closeModal"
                        aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitEditar">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control" :value="cliente.name" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoria Cliente</label>
                            <select class="form-select" v-model="form.categoria">
                                <option :value="index" v-for="(categoria, index) in categorias">
                                    {{ categoria }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
