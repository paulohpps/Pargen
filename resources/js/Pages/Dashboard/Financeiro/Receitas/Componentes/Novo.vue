<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormError from '@/Componentes/Forms/FormError.vue';
import { Modal } from 'bootstrap';
import axios from 'axios';

const props = defineProps({
    categorias: Object,
})

const form = useForm({
    descricao: '',
    categoria_id: props.categorias[0]?.id,
    subcategoria_id: props.categorias[0]?.subcategorias[0].id,
})

let subcategorias = ref(props.categorias[0]?.subcategorias);

function getCategorias() {
    axios.get(`/dashboard/financeiro/categorias/${form.categoria_id}/subcategorias`)
        .then((response) => {
            subcategorias.value = response.data;
            form.subcategoria_id = response.data[0]?.id;
        });
}

function submitNovo() {
    form.post(`/dashboard/financeiro/receitas/criar`,
        {
            onSuccess: () => {
                form.reset();
                closeModal();
            },
        });
}
let modalEl = ref(null)
let elDescricao = ref(null);
let modal = null;
onMounted(() => {
    modal = new Modal(modalEl.value, {
        keyboard: false,
        backdrop: 'static',
    });
})
function closeModal() {
    modal.hide();
}

function redimencionarInput() {
    elDescricao.value.style.height = 'auto';
    elDescricao.value.style.height = elDescricao.value.scrollHeight + 5 + 'px';
}

</script>
<template>
    <div class="modal fade" id="adicionarModal" ref="modalEl" tabindex="-1" aria-labelledby="adicionarLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="adicionarLabel">Nova receita</h1>
                    <button type="button" class="btn-close" @click="form.reset()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitNovo">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea ref="elDescricao" type="text" style="scrollbar-width: none;" class="form-control"
                                @input="redimencionarInput" v-model="form.descricao" required />
                            <FormError :error="form.errors.descricao" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Categoria</label>
                            <select class="form-select" @change="getCategorias" v-model="form.categoria_id" required>
                                <option v-for="categoria in categorias" :value="categoria.id">{{ categoria.nome }}</option>
                            </select>
                        </div>
                        <div v-if="subcategorias?.length !== 0" class="mb-3">
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
                        <button type="submit" class="btn btn-primary"
                            :class="{ disabled: subcategorias?.length === 0 }">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
