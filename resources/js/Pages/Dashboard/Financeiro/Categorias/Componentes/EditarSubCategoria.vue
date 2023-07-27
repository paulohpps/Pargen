<script setup>
import { ref, onMounted , getCurrentInstance} from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormError from '@/Componentes/Forms/FormError.vue';
import { Modal } from 'bootstrap';

const props = defineProps({
    subCategoriaId: Number,
    nome: String,
})

const form = useForm({
    nome: props.nome,
})

let emit = null;

function submitEditarSubCategoria() {
    form.post(`/dashboard/financeiro/categorias/subcategorias/${props.subCategoriaId}/editar`
        , {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                closeModal();
            },
        });
}

let modalEl = ref(null)
let modal = null;
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

</script>
<template>
    <div class="modal fade" id="EditarModal" ref="modalEl" tabindex="-1" aria-labelledby="EditarModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="adicionarModalLabel">Editar SubCategoria</h1>
                    <button @click="closeModal()" type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitEditarSubCategoria">
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
