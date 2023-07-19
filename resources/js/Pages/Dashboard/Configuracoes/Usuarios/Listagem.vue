<script setup>
import { ref, defineProps } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Editar from './Componentes/Editar.vue';
import Novo from './Componentes/Novo.vue';
import Excluir from './Componentes/Excluir.vue';

const props = defineProps({
    usuarios: Array,
    tiposUsuario: Array,
});

let showModal = ref(false)
let showModalExcluir = ref(false)
let userId = ref(null)

function openModal(id) {
    showModal.value = true
    userId.value = id
}

function openModalExcluir(id) {
    showModalExcluir.value = true
    userId.value = id
}

</script>
<template>
    <DashboardLayout titulo="Usuarios" categoriaPagina="administracao" pagina="usuarios">
        <div class="card mt-3 shadow tabela w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Usuários</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adicionarModal">
                    Adicionar
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Tipo Usuario</th>
                            <th scope="col">Data de Cadastro</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="usuario in usuarios">
                            <td>{{ usuario.username }}</td>
                            <td>{{ tiposUsuario[usuario.tipo_usuario] }}</td>
                            <td>{{ usuario.created_at }}</td>
                            <td>
                                <button class="btn btn-primary" @click="openModal(usuario.id)" data-bs-toggle="modal"
                                    data-bs-target="#editarModal">Editar</button>
                                <button class="btn btn-danger ms-2" @click="openModalExcluir(usuario.id)">Excluir</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <Novo :tiposUsuario="tiposUsuario" />
            <Editar v-if="showModal" :userId="userId" :tiposUsuario="tiposUsuario" @close-modal="showModal = false" />
            <Excluir v-if="showModalExcluir" :userId="userId" @close-modal="showModalExcluir = false" />

        </div>
    </DashboardLayout>
</template>
