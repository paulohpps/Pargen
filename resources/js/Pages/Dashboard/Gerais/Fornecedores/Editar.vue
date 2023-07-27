<script setup>
import { router, useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const props = defineProps({
    fornecedor: Array,
});
const form = useForm({
    razao_social: props.fornecedor.razao_social,
    telefone: props.fornecedor.telefone,
    email: props.fornecedor.email,
    cnpj: props.fornecedor.cnpj,
    endereco: props.fornecedor.endereco,
    contato: props.fornecedor.contato,
})

function salvarFuncionario() {
    form.post(`/dashboard/fornecedores/${props.fornecedor.id}/salvar`)
}
</script>

<template>
    <DashboardLayout titulo="Editar Fornecedor" categoriaPagina="geral" pagina="fornecedores">
        <button class="btn btn-primary m-2" @click="router.visit('/dashboard/fornecedores')">
            <i class="fa-solid fa-arrow-left fa-sm me-1"></i>Voltar</button>
        <div class="card shadow mt-1 m-2">
            <div class="card-header">
                <h2>Editar Fornecedor</h2>
            </div>
            <form @submit.prevent="salvarFuncionario">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="razao_social" class="form-label">Razão Social</label>
                        <input type="text" class="form-control" v-model="form.razao_social" id="razao_social"
                            aria-describedby="emailHelp" required>
                        <FormError :error="form.errors.razao_social" />
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" v-model="form.telefone" id="telefone"
                            aria-describedby="emailHelp">
                        <FormError :error="form.errors.telefone" />
                    </div>
                    <div class="mb-3">
                        <label for="contato" class="form-label">Contato</label>
                        <input type="text" class="form-control" v-model="form.contato" id="contato"
                            aria-describedby="emailHelp">
                        <FormError :error="form.errors.contato" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" v-model="form.email" id="email">
                        <FormError :error="form.errors.email" />
                    </div>
                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" class="form-control" v-model="form.cnpj" id="cnpj" required>
                        <FormError :error="form.errors.cnpj" />
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" v-model="form.endereco" id="endereco">
                        <FormError :error="form.errors.endereco" />
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>

        </div>
    </DashboardLayout>
</template>
