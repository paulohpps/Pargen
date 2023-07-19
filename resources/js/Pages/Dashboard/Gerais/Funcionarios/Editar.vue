<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import '../../../../../css/Dashboard/funcionarios/form.css';
import Mask from '@/Componentes/Helper/InputMask';
import FormError from '@/Componentes/Forms/FormError.vue';

const props = defineProps({
    funcionario: Object,
});

let elEncargos = ref(null);
let elValorVencimento = ref(null);
let elCPF = ref(null);

onMounted(() => {
    Mask.valor(elValorVencimento.value);
    Mask.valor(elEncargos.value);
    Mask.cpf(elCPF.value);
})

const form = useForm({
    nome: props.funcionario.nome,
    cpf: props.funcionario.cpf,
    cargo: props.funcionario.cargo,
    encargos: props.funcionario.encargos,
    valor_vencimento: props.funcionario.valor_vencimento,
});

function submitEditarFuncionario() {
    form.post(`/dashboard/funcionarios/${props.funcionario.id}/salvar/`);
}

</script>

<template>
    <DashboardLayout titulo="Editar Funcionario" categoriaPagina="geral" pagina="funcionarios">
        <button class="btn btn-primary m-2" @click="router.visit('/dashboard/funcionarios')">
            <i class="fa-solid fa-arrow-left fa-sm me-1"></i>Voltar</button>
        <div class="card shadow mt-1 m-2">
            <div class="card-header">
                <h2>Editar Funcionario</h2>
            </div>
            <form @submit.prevent="submitEditarFuncionario()">
                <div class="card-body FuncionarioForm">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" v-model="form.nome" name="nome" id="nome"
                            placeholder="Pedro Henrique">
                        <label for="nome">Nome</label>
                        <FormError :error="form.errors.nome" />
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" ref="elCPF" class="form-control" disabled v-model="form.cpf" name="cpf"
                            id="cpf" placeholder="000.000.000-00">
                        <label for="cpf">CPF</label>
                        <FormError :error="form.errors.cpf" />
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" v-model="form.cargo" name="cargo" id="cargo"
                            placeholder="Recepcionista">
                        <label for="cargo">Cargo</label>
                        <FormError :error="form.errors.cargo" />
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" ref="elValorVencimento" class="form-control" v-model="form.valor_vencimento"
                            name="valorVencimento" id="floatingInput" placeholder="2000,00">
                        <label for="floatingInput">Valor Vencimento</label>
                        <FormError :error="form.errors.valor_vencimento" />
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" ref="elEncargos" class="form-control" v-model="form.encargos" name="encargos"
                            id="floatingInput" placeholder="500,00">
                        <label for="floatingInput">Encargos</label>
                        <FormError :error="form.errors.encargos" />
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>

        </div>
    </DashboardLayout>
</template>
