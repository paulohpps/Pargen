<script setup>
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Novo from './Componentes/Novo.vue';
import Excluir from './Componentes/Excluir.vue';
import { Link } from '@inertiajs/vue3';
import Paginacao from '@/Componentes/Paginacao.vue';

const props = defineProps({
    funcionarios: Array,
});

let showModalExcluir = ref(false)
let funcionarioId = ref(null)

function openModalExcluir(id) {
    showModalExcluir.value = true
    funcionarioId.value = id
}

</script>
<template>
    <DashboardLayout titulo="Funcionarios" categoriaPagina="geral" pagina="funcionarios">
        <div class="card shadow tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Funcionarios</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adicionarModal">
                    Adicionar
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Valor Encargos</th>
                            <th scope="col">Valor Vencimento</th>
                            <th scope="col">Custo Total</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="funcionario in funcionarios.data">
                            <td>{{ funcionario.nome }}</td>
                            <td>{{ funcionario.cargo }}</td>
                            <td>{{ funcionario.cpf }}</td>
                            <td>R$ {{ funcionario.encargos }}</td>
                            <td>R$ {{ funcionario.valor_vencimento }}</td>
                            <td>R$ {{ funcionario.custo_total }}</td>
                            <td>
                                <div class="d-flex">
                                    <Link :href="`/dashboard/funcionarios/${funcionario.id}/editar/`"
                                        class="btn btn-primary ms-2">Editar</Link>
                                    <button class="btn btn-danger ms-2"
                                        @click="openModalExcluir(funcionario.id)">Excluir</button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="funcionarios.data.length === 0">
                            <td colspan="8" class="text-center">Nenhum funcionario cadastrado</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <Novo />
            <Excluir v-if="showModalExcluir" :funcionarioId="funcionarioId" @close-modal="showModalExcluir = false" />
            <Paginacao :links="funcionarios.links" />

        </div>
    </DashboardLayout>
</template>
