<script setup >
import { useForm } from '@inertiajs/vue3';
import FormError from '@/Componentes/Forms/FormError.vue';

const props = defineProps({
    tiposUsuario: Array,
});

const form = useForm({
    username: '',
    password: '',
    password_confirmation: '',
    tipo_usuario: 0,
})

function submitNovoUsuario() {
    form.post("/dashboard/usuarios/criar"
        , {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
}
</script>
<template>
    <div class="modal fade" id="adicionarModal" tabindex="-1" aria-labelledby="adicionarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="adicionarModalLabel">Novo Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitNovoUsuario">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="inputUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" v-model="form.username" id="inputUsername"
                                aria-describedby="emailHelp" required>
                            <FormError :error="form.errors.nome" />
                        </div>
                        <div class="mb-3">
                            <label for="inputTipoUsuario" class="form-label">Tipo de Usuario</label>
                            <select v-model="form.tipo_usuario" class="form-select" id="inputTipoUsuario" required>
                                <option v-for="(tipoUsuario, index) in tiposUsuario" :key="index" :value="index">{{
                                    tipoUsuario }}</option>
                            </select>

                            <FormError :error="form.errors.tipo_usuario" />
                        </div>
                        <div class="mb-3">
                            <label for="inputSenha" class="form-label">Senha</label>
                            <input type="password" class="form-control" v-model="form.password" id="inputSenha" required>
                            <FormError :error="form.errors.password" />
                        </div>
                        <div class="mb-3">
                            <label for="inputSenhaConfirmacao" class="form-label">Confirme a senha</label>
                            <input type="password" class="form-control" v-model="form.password_confirmation"
                                id="inputSenhaConfirmacao" required>
                            <FormError :error="form.errors.password_confirmation" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="form.reset()">Fechar</button>
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
