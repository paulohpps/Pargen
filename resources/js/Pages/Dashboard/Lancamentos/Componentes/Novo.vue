<script setup>
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { Modal } from 'bootstrap';
import { ref, onMounted } from 'vue';
import FormError from '@/Componentes/Forms/FormError.vue';

const form = useForm({
    tipo_pagamento: 1,
    descricao: null,
    valor: null,
    vencimento: null,
    status: 1,
    repetir_parcelas: false,
    numero_parcelas: 0,
    fornecedor_id: 0,
    funcionario_id: 0,
    pago_para: "",
    pagamento_lancamento_id: 0,
})

function submitNovoFornecedor() {
    form.post("/dashboard/lancamentos/criar"
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

let fornecedores = ref([]);
let funcionarios = ref([]);
let pagamentos = ref([]);

onMounted(async () => {
    modal = new Modal(modalEl.value, {
        keyboard: false,
        backdrop: 'static',
    });

    fornecedores = await axios.get('/dashboard/fornecedores/consultar')
    funcionarios = await axios.get('/dashboard/funcionarios/consultar')
    pagamentos = await axios.get('/dashboard/financeiro/pagamentos/consultar')

    form.fornecedor_id = fornecedores.data[0]?.id;
    form.funcionario_id = funcionarios.data[0]?.id;
    form.pagamento_lancamento_id = pagamentos.data[0]?.id;

})

function closeModal() {
    modal.hide();
}

function resetParcelas() {
    if (!form.repetir_parcelas) {
        form.parcelas = 0;
    }
}
</script>
<template>
    <div class="modal fade modal-lg" id="adicionarModal" ref="modalEl" tabindex="-1" aria-labelledby="adicionarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="adicionarModalLabel">Novo Lançamento</h1>
                    <button type="button" class="btn-close" @click="form.reset()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitNovoFornecedor">
                    <div class="modal-body d-flex justify-content-around">
                        <div class="w-50">

                            <div class="mb-3">
                                <label for="inputTipoUsuario" class="form-label">Tipo</label>
                                <select class="form-select" v-model="form.tipo_pagamento">
                                    <option :value="1">Fornecedor</option>
                                    <option :value="2">Funcionarios</option>
                                    <option :value="3">Pagamentos</option>
                                </select>
                                <FormError :error="form.errors.contato" />
                            </div>
                            <div class="mb-3">
                                <label for="inputNome" class="form-label">Pago para: </label>
                                <select v-if="form.tipo_pagamento === 1" class="form-select" v-model="form.fornecedor_id">
                                    <option v-for="fornecedor in fornecedores.data" :value="fornecedor.id">
                                        {{
                                            fornecedor.razao_social
                                        }}
                                    </option>
                                </select>
                                <select v-else-if="form.tipo_pagamento === 2" class="form-select"
                                    v-model="form.funcionario_id">
                                    <option v-for="funcionario in funcionarios.data" :value="funcionario.id">
                                        {{
                                            funcionario.nome
                                        }}
                                    </option>
                                </select>
                                <input v-else-if="form.tipo_pagamento === 3" class="form-control"
                                    v-model="form.pago_para"/>
                                <FormError :error="form.errors.nome" />
                            </div>
                            <div class="mb-3">
                                <label for="inputSenha" class="form-label">Pagamento:</label>
                                <select class="form-select" v-model="form.pagamento_lancamento_id">
                                    <option v-for="pagamento in pagamentos.data" :value="pagamento.id">
                                        {{
                                            pagamento.descricao
                                        }}
                                    </option>
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="inputObservacao" class="form-label">Observação (Opcional)</label>
                                <textarea class="form-control" v-model="form.descricao" style="height: 124px;"
                                    id="inputObservacao" />
                                <FormError :error="form.errors.email" />
                            </div>
                        </div>
                        <div class="w-50 ms-2">
                            <div class="mb-3">
                                <label for="valor" class="form-label">Valor</label>
                                <input type="text" class="form-control" v-model="form.valor" id="valor" required>
                                <FormError :error="form.errors.cnpj" />
                            </div>
                            <div class="mb-3">
                                <label for="vencimento" class="form-label">Vencimento</label>
                                <input type="date" class="form-control" v-model="form.vencimento" id="vencimento" required>
                                <FormError :error="form.errors.endereco" />
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" v-model="form.status">
                                    <option value="Aberto">Aberto</option>
                                    <option value="Pago">Pago</option>
                                    <option value="Atrasado">Atrasado</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                                <FormError :error="form.errors.endereco" />
                            </div>
                            <div class="mb-3">
                                <label for="repetir_parcelas" class="form-label">Repetir Parcelas?</label>
                                <select class="form-select" id="repetir_parcelas" @change="resetParcelas"
                                    v-model="form.repetir_parcelas">
                                    <option :value="false">Não</option>
                                    <option :value="true">Sim</option>
                                </select>
                                <FormError :error="form.errors.endereco" />
                            </div>
                            <div class="mb-3" v-if="form.repetir_parcelas">
                                <label for="quantidade_parcelas" class="form-label">Quantidade de Parcelas</label>
                                <input type="number" class="form-control" v-model="form.numero_parcelas"
                                    id="quantidade_parcelas" required>
                                <FormError :error="form.errors.numero_parcelas" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
