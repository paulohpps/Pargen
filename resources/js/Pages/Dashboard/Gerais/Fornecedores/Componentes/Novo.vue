<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormError from '@/Componentes/Forms/FormError.vue';
import { Modal } from 'bootstrap';

const form = useForm({
    razao_social: '',
    telefone: '',
    email: '',
    cnpj: '',
    endereco: '',
    contato: '',
})

function submitNovoLancamento() {
    form.post("/dashboard/fornecedores/criar"
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
                    <h1 class="modal-title fs-5" id="adicionarModalLabel">Novo Fornecedor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitNovoLancamento">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="razao_social" class="form-label">Razão Social</label>
                            <input type="text" class="form-control" v-model="form.razao_social" id="razao_social"
                                aria-describedby="emailHelp" required>
                            <FormError :error="form.errors.razao_social" />
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" v-model="form.telefone" id="telefone"
                                aria-describedby="emailHelp" required>
                            <FormError :error="form.errors.telefone" />
                        </div>
                        <div class="mb-3">
                            <label for="contato" class="form-label">Contato</label>
                            <input type="text" class="form-control" v-model="form.contato" id="contato"
                                aria-describedby="emailHelp" required>
                            <FormError :error="form.errors.contato" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" v-model="form.email" id="email" required>
                            <FormError :error="form.errors.email" />
                        </div>
                        <div class="mb-3">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="text" class="form-control" v-model="form.cnpj" id="cnpj" required>
                            <FormError :error="form.errors.cnpj" />
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" v-model="form.endereco" id="endereco"
                                required>
                            <FormError :error="form.errors.endereco" />
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
