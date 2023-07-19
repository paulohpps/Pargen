<script setup >
import { ref, onMounted, getCurrentInstance } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormError from '@/Componentes/Forms/FormError.vue';
import { Modal } from 'bootstrap';
import axios from 'axios';

const props = defineProps({
    tiposUsuario: Array,
    userId: Number,
})

const form = useForm({
    username: '',
    password: '',
    password_confirmation: '',
    tipo_usuario: 0,
})

let modalEl = ref(null)
let modal = null
let emit = null;

onMounted(() => {
    const instance = getCurrentInstance()
    emit = instance.emit

    modal = new Modal(modalEl.value, {
        keyboard: false,
        backdrop: 'static',
    });
    modal.show();

    axios.get(`/dashboard/usuarios/${props.userId}`)
        .then(response => {
            form.username = response.data.username
            form.tipo_usuario = response.data.tipo_usuario
        })
})

function closeModal() {
    modal.hide()
    emit('close-modal')
}

function submitEditarUsuario() {
    form.post(`/dashboard/usuarios/editar/${props.userId}`, {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    })
}

</script>
<template>
    <div>
    <div class="modal fade" ref="modalEl" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarModalLabel">Editar Usuário</h1>
                    <button type="button" @click="closeModal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitEditarUsuario(), closeModal()">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" v-model="form.username" id="username"
                                aria-describedby="emailHelp" required>
                            <FormError :error="form.errors.nome" />
                        </div>
                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                            <select v-model="form.tipo_usuario" class="form-select" id="tipo_usuario" required>
                                <option v-for="(tipoUsuario, index) in tiposUsuario"
                                :key="index"
                                :value="index">
                                    {{tipoUsuario }}
                            </option>
                            </select>

                            <FormError :error="form.errors.tipo_usuario" />
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" v-model="form.password" id="senha" required>
                            <FormError :error="form.errors.password" />
                        </div>
                        <div class="mb-3">
                            <label for="senha_confirmacao" class="form-label">Confirme a senha</label>
                            <input type="password" class="form-control" v-model="form.password_confirmation"
                                id="senha_confirmacao" required>
                            <FormError :error="form.errors.password_confirmation" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            @click="form.reset(), closeModal()">Fechar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>
