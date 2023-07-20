<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import SelectAjax from '@/Componentes/Forms/SelectAjax.vue';
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    clientes: Array,
});

const form = useForm({
    servicos: [],
});

let cliente_id = ref(props.clientes[0].id);

watch(() => cliente_id.value, (newValue) => {
    form.servicos = [];
    servicos.value = [];
});

function faturar() {
    form.servicos = servicos.value;
    form.post('/dashboard/fatura/faturar/gerar');
}


function selecionarServico(servico) {
    servicos.value.push(servico);
}

function removerServico(id) {
    servicos.value = servicos.value.filter(servico => servico.id !== id);
}

const servicos = ref([]);
</script>

<template>
    <DashboardLayout titulo="Gerar Fatura" categoriaPagina="fatura" pagina="faturas">
        <div class="card tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Faturar serviços</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="mb-2">Cliente</label>
                    <select v-model="cliente_id" class="form-control">
                        <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                            {{ cliente.name }}
                        </option>

                    </select>
                </div>
                <div class="mb-3">
                    <label class="mb-2">Pet - Tutor</label>
                    <SelectAjax href="/dashboard/servicos/ajax" :cliente_id="cliente_id" placeholder="Selecione um servico" :preBusca="true"
                        @optionSelected="selecionarServico" :servicos="servicos"></SelectAjax>
                </div>
                <div class="d-flex row mt-3">
                    <p class="btn btn-primary col-auto ms-3" v-for="(servico, index) in servicos" :key="index">
                        {{ servico.texto }}
                        <button type="button" @click="removerServico(servico.id)" class="btn-close"></button>
                    </p>
                </div>

            </div>
            <div class="card-footer">
                <button type="button" @click="faturar" class="btn btn-primary">Gerar Fatura</button>
            </div>
        </div>
    </DashboardLayout>
</template>
