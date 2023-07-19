<script setup>
import { defineProps, ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormError from '@/Componentes/Forms/FormError.vue';
import Mask from '@/Componentes/Helper/InputMask';
import { Modal } from 'bootstrap';

let elEncargos = ref(null);
let elValorVencimento = ref(null);
let elCPF = ref(null);

onMounted(() => {
    Mask.valor(elValorVencimento.value);
    Mask.valor(elEncargos.value);
    Mask.cpf(elCPF.value);
})

const form = useForm({
    nome: '',
    cpf: '',
    cargo: '',
    valor_vencimento: '',
    encargos: '',
})

function submitNovoFuncionario() {
    form.post("/dashboard/funcionarios/criar"
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
                    <h1 class="modal-title fs-5" id="adicionarModalLabel">Novo Funcionario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitNovoFuncionario">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="inputUsername" class="form-label">Nome</label>
                            <input type="text" class="form-control" v-model="form.nome" id="inputUsername"
                                aria-describedby="emailHelp" required>
                            <FormError :error="form.errors.nome" />
                        </div>
                        <div class="mb-3">
                            <label for="inputTipoUsuario" class="form-label">CPF</label>
                            <input ref="elCPF" type="text" class="form-control" v-model="form.cpf" id="inputUsername"
                                aria-describedby="emailHelp" required>

                            <FormError :error="form.errors.cpf" />
                        </div>
                        <div class="mb-3">
                            <label for="inputSenha" class="form-label">Cargo</label>
                            <input type="text" class="form-control" v-model="form.cargo" id="inputSenha" required>
                            <FormError :error="form.errors.cargo" />
                        </div>
                        <div class="mb-3">
                            <label for="inputSenhaConfirmacao" class="form-label">Valor Vencimento</label>
                            <input ref="elValorVencimento" type="text" class="form-control" v-model="form.valor_vencimento"
                                id="inputSenhaConfirmacao" required>
                            <FormError :error="form.errors.valor_vencimento" />
                        </div>
                        <div class="mb-3">
                            <label for="inputSenhaConfirmacao" class="form-label">Encargos</label>
                            <input ref="elEncargos" type="text" class="form-control" v-model="form.encargos"
                                id="inputSenhaConfirmacao" required>
                            <FormError :error="form.errors.encargos" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="form.reset()">Fechar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
