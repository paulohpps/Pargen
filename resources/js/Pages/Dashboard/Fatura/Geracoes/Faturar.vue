<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref } from 'vue';
import FormError from '@/Componentes/Forms/FormError.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    clientes: Array,
    chave_pix: String,
    data_inicial: String,
    data_final: String,
});

const form = useForm({
    servicos: [],
    cliente_id: props.clientes[0]?.id,
    vencimento: '',
    chave_pix: props.chave_pix,
    observacao: '',
});

const servicos = ref([]);

let form_filtro = {
    data_inicial: props.data_inicial,
    data_final: props.data_final,
};

async function atualizarServicos() {
    let response = await axios.get(`/dashboard/servicos/ajax?cliente_id=${form.cliente_id}&data_inicial=${form_filtro.data_inicial}&data_final=${form_filtro.data_final}`);
    servicos.value = response.data;
    form.servicos = servicos.value;
}
atualizarServicos();

function faturar() {
    if (servicos.value.length === 0) {
        form.errors.servicos = 'Selecione pelo menos um serviço';
        return;
    }
    form.post('/dashboard/fatura/faturar/gerar');
}

async function selecionarCliente() {
    form.servicos = [];
    servicos.value = [];
    await atualizarServicos();
}

function checkServico(event, id) {
    if (event.target.checked) {
        form.servicos.push(servicos.value.find(p => p.id == id));
    } else {
        form.servicos = form.servicos.filter(p => p.id != id);
    }
}

</script>

<template>
    <DashboardLayout titulo="Gerar Fatura" categoriaPagina="fatura" pagina="faturar">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Faturar serviços</h2>
            </div>
            <form @submit.prevent="faturar">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="w-50">
                            <div class="mb-3">
                                <label class="mb-2">Cliente</label>
                                <select v-model="form.cliente_id" @change="selecionarCliente" class="form-control">
                                    <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                                        {{ cliente.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="ms-3">
                            <label class="mb-2">Chave pix</label>
                            <input type="text" class="form-control" v-model="form.chave_pix" required
                                placeholder="Chave pix" />
                        </div>
                        <div class="ms-3">
                            <label class="mb-2">Vencimento</label>
                            <input type="date" class="form-control" v-model="form.vencimento" required />
                        </div>
                    </div>
                    <div>
                        <div class="d-flex">
                            <div class="mb-3">
                                <label class="mb-2">Data Inicial</label>
                                <input type="date" class="form-control" v-model="form_filtro.data_inicial"
                                    @input="atualizarServicos" />
                            </div>
                            <div class="mb-3 ms-3">
                                <label class="mb-2">Data Final</label>
                                <input type="date" class="form-control" v-model="form_filtro.data_final"
                                    @input="atualizarServicos" />
                            </div>
                            <div class="mb-3 ms-3 w-100">
                                <label class="mb-2">Observação</label>
                                <input type="text" class="form-control" v-model="form.observacao" />
                            </div>
                        </div>
                        <h3>Serviços não faturados de {{ clientes.find(p => p.id == form.cliente_id).name }}</h3>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Selecionar</th>
                                    <th scope="col">Pet</th>
                                    <th scope="col">Tutor</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Coletado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="servico in servicos">
                                    <th scope="row"><input class="form-check-input" type="checkbox"
                                            @change="checkServico($event, servico.id)" checked="true" /></th>
                                    <td>{{ servico.pet }}</td>
                                    <td>{{ servico.tutor }}</td>
                                    <td>{{ servico.status }}</td>
                                    <td>{{ servico.collected ? "Sim" : "Não" }}</td>
                                </tr>
                                <tr v-if="servicos.length === 0">
                                    <td class="text-center" colspan="5">Esse cliente não contem nenhum servico não faturado
                                        no periodo selecionado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <FormError :error="form.errors.servicos" />
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Gerar Fatura</button>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>
