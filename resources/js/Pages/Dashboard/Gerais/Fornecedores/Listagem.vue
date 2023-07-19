<script setup>
import { defineProps, ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Novo from './Componentes/Novo.vue';
import Excluir from './Componentes/Excluir.vue';
import { Link } from '@inertiajs/vue3';
import Paginacao from '../../../../Componentes/Paginacao.vue';


const props = defineProps({
    fornecedores: Array,
});
let showModalExcluir = ref(false)
let funcionarioId = ref(null)
function openModalExcluir(id) {
    showModalExcluir.value = true
    funcionarioId.value = id
}
</script>
<template>
    <DashboardLayout titulo="Fornecedores" categoriaPagina="geral" pagina="fornecedores">
        <div class="card shadow tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Fornecedores</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adicionarModal">
                    Adicionar
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Razão Social</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Email</th>
                            <th scope="col">CNPJ</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Contato</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fornecedor in fornecedores.data">
                            <td>{{ fornecedor.razao_social }}</td>
                            <td>{{ fornecedor.telefone }}</td>
                            <td>{{ fornecedor.email }}</td>
                            <td>{{ fornecedor.cnpj }}</td>
                            <td>{{ fornecedor.endereco }}</td>
                            <td>{{ fornecedor.contato }}</td>
                            <td>
                                <div class="d-flex">
                                    <Link :href="`/dashboard/fornecedores/${fornecedor.id}/editar`"
                                        class="btn btn-primary ms-2">
                                    Editar</Link>
                                    <button class="btn btn-danger ms-2"
                                        @click="openModalExcluir(fornecedor.id)">Excluir</button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="fornecedores.data.length === 0">
                            <td colspan="8" class="text-center">Nenhum fornecedor cadastrado</td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <!-- Modal -->
            <Novo />
            <Excluir v-if="showModalExcluir" :funcionarioId="funcionarioId" @close-modal="showModalExcluir = false" />
            <Paginacao :links="fornecedores.links" />
        </div>
    </DashboardLayout>
</template>
