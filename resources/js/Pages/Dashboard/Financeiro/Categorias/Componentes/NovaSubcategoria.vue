<script setup>
import { ref, onMounted, getCurrentInstance } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormError from '@/Componentes/Forms/FormError.vue';
import { Modal } from 'bootstrap';

const props = defineProps({
    categoriaId: Object,
});

const form = useForm({
    nome: '',
    categoria_id: props.categoriaId,
})



function submitNovaSubcategoria() {
    form.post(`/dashboard/financeiro/categorias/${props.categoriaId}/subcategorias/criar`
        , {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                closeModal();
            },
        });
}
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
    modal.hide();
    emit('close-modal')
}

</script>
<template>
    <div class="modal fade" :id="`adicionarSubcategoriaModal`" ref="modalEl" tabindex="-1"
        aria-labelledby="adicionarSubcategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="adicionarSubcategoriaLabel">Nova Subcategoria</h1>
                    <button type="button" class="btn-close" @click="closeModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitNovaSubcategoria">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input id="nome" type="text" class="form-control" v-model="form.nome" required>
                            <FormError :error="form.errors.nome" />
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
