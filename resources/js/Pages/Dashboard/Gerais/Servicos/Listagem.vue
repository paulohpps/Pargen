<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Paginacao from '../../../../Componentes/Paginacao.vue';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';


const props = defineProps({
    servicos: Array,
    analises: Array,
    filtros: Array,
    categorias_analise: Array,
    categorias_cliente: Array,
    fatura_status: Array,
});

let form = useForm({
    paciente : props.filtros.paciente ?? '',
    cliente : props.filtros.cliente ?? '',
    numero_fatura : props.filtros.numero_fatura ?? '',
    numero_amostra : props.filtros.numero_amostra ?? '',
    analise : props.filtros.analise ?? '',
    categoria_analise : props.filtros.categoria_analise ?? '',
    tipo_cliente : props.filtros.tipo_cliente ?? '',
    data_coleta : props.filtros.data_coleta ?? '',
    data_vencimento : props.filtros.data_vencimento ?? '',
    data_recebimento : props.filtros.data_recebimento ?? '',
});

function submitFiltrarServicos() {
    let url = new URL(window.location.href);
    let searchParams = new URLSearchParams(url.search);

    searchParams.set('paciente', form.paciente);

    searchParams.set('cliente', form.cliente);

    searchParams.set('numero_fatura', form.numero_fatura);

    searchParams.set('numero_amostra', form.numero_amostra);

    if (form.analise) {
        searchParams.set('analise', form.analise);
    }
    if (form.categoria_analise !== '') {
        searchParams.set('categoria_analise', form.categoria_analise);
    }
    if (form.tipo_cliente !== '') {
        searchParams.set('tipo_cliente', form.tipo_cliente);
    }

    searchParams.set('data_coleta', form.data_coleta);

    searchParams.set('data_vencimento', form.data_vencimento);

    searchParams.set('data_recebimento', form.data_recebimento);


    window.location.search = searchParams.toString();
}

</script>
<template>
    <DashboardLayout titulo="Serviços" categoriaPagina="lancamentos" pagina="servicos">
        <div class="card shadow tabela mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="me-3">
                    <h2 class="card-title">Serviços</h2>
                    <h6>{{ servicos.total }} {{servicos.total == 1 ? 'resultado' : 'resultados'}}</h6>
                </div>
                <form @submit.prevent="submitFiltrarServicos" class="w-100">
                    <div class="row">
                        <div class="col mb-2">
                            <label class="mb-2">Paciente</label>
                            <input v-model="form.paciente" type="text" class="form-control"/>
                        </div>
                        <div class="col mb-2">
                            <label class="mb-2">Cliente</label>
                            <input v-model="form.cliente" type="text" class="form-control"/>
                        </div>
                        <div class="col mb-2">
                            <label class="mb-2">N°Fatura</label>
                            <input v-model="form.numero_fatura" type="text" class="form-control"/>
                        </div>
                        <div class="col mb-2">
                            <label class="mb-2">N°Amostra</label>
                            <input v-model="form.numero_amostra" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label class="mb-2">Analise</label>
                            <select v-model="form.analise" class="form-control">
                                <option value="">Selecione</option>
                                <option v-for="analise, in analises" :value="analise.id">
                                    {{ analise.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label class="mb-2">Categoria Analise</label>
                            <select v-model="form.categoria_analise" class="form-control">
                                <option value="">Selecione</option>
                                <option v-for="(categoria_analise, index) in categorias_analise" :value="index">
                                    {{ categoria_analise }}
                                </option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label class="mb-2">Tipo Cliente</label>
                            <select v-model="form.tipo_cliente" class="form-control">
                                <option value="">Selecione</option>
                                <option v-for="(categoria_cliente, index) in categorias_cliente" :value="index">
                                    {{ categoria_cliente }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label class="mb-2">Data Coleta</label>
                            <input v-model="form.data_coleta" type="date" class="form-control"/>
                        </div>
                        <div class="col mb-2">
                            <label class="mb-2">Data Vencimento</label>
                            <input v-model="form.data_vencimento" type="date" class="form-control"/>
                        </div>
                        <div class=" col mb-2">
                            <label class="mb-2">Data Recebimento</label>
                            <div class="d-flex">

                                <input v-model="form.data_recebimento" type="date" class="form-control"/>
                                <button type="submit" class="ms-3 btn btn-primary">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data Coleta</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Analise</th>
                            <th scope="col">N° Amostra</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Valor Unit.</th>
                            <th scope="col">Categoria Analise</th>
                            <th scope="col">Tipo Cliente</th>
                            <th scope="col">N° Fatura</th>
                            <th scope="col">Data Vencimento</th>
                            <th scope="col">Data Recebimento</th>
                            <th scope="col">Status Fatura</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="servico in servicos.data">
                            <td>{{ servico.collect_date }}</td>
                            <td>{{ servico.pet }}</td>
                            <td>{{ servico.analises.map(analise => analise.name).join(', ') }}</td>
                            <td>{{ servico.request_number }}</td>
                            <td>{{ servico?.cliente?.name }}</td>
                            <td>R${{ servico.analises.reduce((accumulator, analise) => {
                                return accumulator + analise.price;
                            }, 0) }}</td>
                            <td>{{ servico.analises.map(analise =>
                                categorias_analise[analise?.categoria_analise?.categoria]).join(', ') || 'Nenhuma categoria'
                            }}</td>
                            <td>{{ categorias_cliente[servico.cliente?.cliente_categoria?.categoria] ?? 'Não cadastrado' }}
                            </td>
                            <td>{{ servico.fatura_id ?? 'Não Faturado' }}</td>
                            <td>{{ servico?.fatura?.data_vencimento ?? '-' }}</td>
                            <td>{{ servico?.fatura?.data_baixa ?? '-' }}</td>
                            <td>{{ fatura_status[servico?.fatura?.status] ?? '-' }}</td>
                        </tr>
                        <tr v-if="servicos.data.length === 0">
                            <td colspan="12" class="text-center">Nenhum Serviço Cadastrado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Paginacao :links="servicos.links" />
        </div>
    </DashboardLayout>
</template>
