<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormError from '@/Componentes/Forms/FormError.vue';
import { Modal } from 'bootstrap';

const form = useForm({
    nome: '',
})

function submitNovaDespesa() {
    form.post("/dashboard/financeiro/categorias/criar"
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
    modal = new Modal(modalEl.value, {
        keyboard: false,
        backdrop: 'static',
    });
})
function closeModal() {
    modal.hide();
}

</script>
<template>
    <div class="modal fade" id="adicionarModal" ref="modalEl" tabindex="-1" aria-labelledby="adicionarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="adicionarModalLabel">Nova Categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitNovaDespesa">
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
