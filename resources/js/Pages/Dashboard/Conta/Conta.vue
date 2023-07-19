<script setup>
import { useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import FormError from '@/Componentes/Forms/FormError.vue';

const props = defineProps({
    usuario: Object,
});

const form = useForm({
    senha: '',
    senha_confirmation: '',
});

function submitEditarConta() {
    form.post('/dashboard/conta/alterar-senha');
}

</script>
<template>
    <DashboardLayout titulo="Minha conta">
        <div class="card shadow mt-3">
            <div class="card-header">
                <h2>Olá {{ usuario.username }}</h2>
            </div>

            <form @submit.prevent="submitEditarConta">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="email" disabled class="form-control" id="username"
                            aria-describedby="emailHelp" :value="usuario.username">
                    </div>
                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova senha</label>
                        <input type="password" v-model="form.senha" class="form-control" id="nova_senha">
                        <FormError :error="form.errors.senha" />
                    </div>
                    <div class="mb-3">
                        <label for="nova_senha_confirmacao" class="form-label">Confirme sua nova senha</label>
                        <input type="password" v-model="form.senha_confirmation" class="form-control"
                            id="nova_senha_confirmacao">
                        <FormError :error="form.errors.senha_confirmation" />
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <p class="text-muted">Última alteração: {{ usuario.updated_at }}</p>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>

    </DashboardLayout>
</template>
