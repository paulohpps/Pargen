<script setup>
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Paginacao from '../../../../Componentes/Paginacao.vue';
import Editar from './Componentes/Editar.vue';


const props = defineProps({
    clientes: Array,
    categorias: Array,
});

let showEditar = ref(false);
let cliente = ref({});

function editar(id) {
    showEditar.value = true;
    cliente.value = props.clientes.data.find(cliente => cliente.id === id);
}

</script>
<template>
    <DashboardLayout titulo="Clientes" categoriaPagina="geral" pagina="clientes">
        <div class="card shadow tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Clientes</h2>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">CNPJ/CPF</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Cidade - Estado</th>
                            <th scope="col">CEP</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cliente in clientes.data">
                            <td>{{ cliente.name }}</td>
                            <td>{{ cliente.cnpj_cpf }}</td>
                            <td>{{ cliente.email }}</td>
                            <td>{{ cliente.phone }}</td>
                            <td>{{ cliente.address }}</td>
                            <td>{{ cliente.city }} - {{ cliente.state }}</td>
                            <td>{{ cliente.zip_code }}</td>
                            <td>{{ categorias[cliente.cliente_categoria[0]?.categoria] }}</td>
                            <td>
                                <button class="btn btn-primary" @click="editar(cliente.id)">
                                    Editar
                                </button>
                            </td>
                        </tr>
                        <tr v-if="clientes.data.length === 0">
                            <td colspan="8" class="text-center">Nenhum cliente cadastrado</td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <Paginacao :links="clientes.links" />
            <Editar :categorias="categorias" v-if="showEditar" :cliente="cliente" @close-modal="showEditar = !showEditar" />
        </div>
    </DashboardLayout>
</template>
