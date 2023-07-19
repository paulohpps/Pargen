<script setup>
import { router, useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import FormError from '@/Componentes/Forms/FormError.vue';
import { ref } from 'vue';
import axios from 'axios';


const props = defineProps({
    receita: Object,
    categorias: Object,
});

const form = useForm({
    descricao: props.receita.descricao,
    categoria_id: props.receita.categoria_id,
    subcategoria_id: props.receita.subcategoria_id,
})

let subcategorias = ref(props.receita.categoria.subcategorias);

function getCategorias() {
    axios.get(`/dashboard/financeiro/categorias/${form.categoria_id}/subcategorias`)
        .then((response) => {
            subcategorias.value = response.data;
            form.subcategoria_id = response.data[0]?.id;
        });
}

let elDescricao = ref(null);
function redimencionarInput() {
    elDescricao.value.style.height = 'auto';
    elDescricao.value.style.height = elDescricao.value.scrollHeight + 5 + 'px';
}

function salvarPagamento() {
    form.post(`/dashboard/financeiro/receitas/${props.receita.id}/salvar`);
}
</script>

<template>
    <DashboardLayout titulo="Editar Receita" categoriaPagina="financeiro" pagina="pagamentos">
        <button class="btn btn-primary m-2" @click="router.visit('/dashboard/financeiro/pagamentos')">
            <i class="fa-solid fa-arrow-left fa-sm me-1"></i>Voltar</button>
        <div class="card shadow mt-1 m-2">
            <div class="card-header">
                <h2>Editar Receita</h2>
            </div>
            <form @submit.prevent="salvarPagamento">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="inputUsername" class="form-label">Descrição</label>
                        <textarea ref="elDescricao" type="text" class="form-control" v-model="form.descricao"
                            id="inputUsername" aria-describedby="emailHelp" required @input="redimencionarInput" />
                        <FormError :error="form.errors.descricao" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <select class="form-select" @change="getCategorias" v-model="form.categoria_id" required>
                            <option v-for="categoria in categorias" :value="categoria.id">{{ categoria.nome }}</option>
                        </select>
                    </div>
                    <div v-if="subcategorias.length !== 0" class="mb-3">
                        <label class="form-label">Subcategoria</label>
                        <select class="form-select" v-model="form.subcategoria_id" required>
                            <option v-for="subcategoria in subcategorias" :value="subcategoria.id">
                                {{
                                    subcategoria.nome
                                }}
                            </option>
                        </select>
                    </div>
                    <div class="alert alert-warning mb-3" v-else role="alert">
                        A categoria selecionada não possui subcategorias.
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>
