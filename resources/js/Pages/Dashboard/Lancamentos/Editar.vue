<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import '../../../../css/Dashboard/funcionarios/form.css';
import FormError from '@/Componentes/Forms/FormError.vue';

const props = defineProps({
    lancamento: Object,
});

const form = useForm({
    descricao: props.lancamento.descricao,
    valor: props.lancamento.valor,
    vencimento: props.lancamento.vencimento,
    status: props.lancamento.status,
});

onMounted(() => {
    form.vencimento = YYYYMMDDFormat(props.lancamento.vencimento);
});

const YYYYMMDDFormat = (dateString) => {
    const [day, month, year] = dateString.split("/");
    return `${year}-${month}-${day}`;
};

function submitEditarLancamento() {
    form.post(`/dashboard/lancamentos/${props.lancamento.id}/salvar`);
}

</script>

<template>
    <DashboardLayout titulo="Editar Lançamento" categoriaPagina="lancamentos" pagina="lancamentos">
        <button class="btn btn-primary m-2" @click="router.visit('/dashboard/lancamentos')">
            <i class="fa-solid fa-arrow-left fa-sm me-1"></i>Voltar</button>
        <div class="card shadow mt-1 m-2">
            <div class="card-header">
                <h2>Editar Lançamento</h2>
            </div>
            <form @submit.prevent="submitEditarLancamento()">
                <div class="card-body FuncionarioForm">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" v-model="form.descricao" id="inputObservacao" />
                        <label for="descricao">Observação</label>
                        <FormError :error="form.errors.descricao" />
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" disabled v-model="form.valor" name="valor" id="valor">
                        <label for="valor">Valor</label>
                        <FormError :error="form.errors.valor" />
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" v-model="form.vencimento" name="vencimento" id="vencimento">
                        <label for="cargo">Vencimento</label>
                        <FormError :error="form.errors.vencimento" />
                    </div>
                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select class="form-select" id="status" v-model="form.status">
                            <option value="Aberto">Aberto</option>
                            <option value="Pago">Pago</option>
                            <option value="Atrasado">Atrasado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                        <FormError :error="form.errors.status" />
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>

        </div>
    </DashboardLayout>
</template>
