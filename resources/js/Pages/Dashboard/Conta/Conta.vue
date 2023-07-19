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
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="email" disabled class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" :value="usuario.username">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nova senha</label>
                        <input type="password" v-model="form.senha" class="form-control" id="exampleInputPassword1">
                        <FormError :error="form.errors.senha" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirme sua nova senha</label>
                        <input type="password" v-model="form.senha_confirmation" class="form-control"
                            id="exampleInputPassword1">
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
