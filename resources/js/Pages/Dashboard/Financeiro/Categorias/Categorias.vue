<script setup >
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Novo from './Componentes/Novo.vue';
import NovaSubcategoria from './Componentes/NovaSubcategoria.vue';
import ExcluirCategoria from './Componentes/ExcluirCategoria.vue';
import ExcluirSubcategoria from './Componentes/ExcluirSubcategoria.vue';
import Paginacao from '@/Componentes/Paginacao.vue';

const props = defineProps({
    categorias: Object,
});

let showModalExcluirCat = ref(false)
let categoriaId = ref(null)
let showModalExcluirSubcat = ref(false)
let subcategoriaId = ref(null)
let showNovaSubCategoria = ref(false)

function openModalExcluirCat(id) {
    showModalExcluirCat.value = true
    categoriaId.value = id
}

function openModalExcluirSubcat(catId, subcatId) {
    showModalExcluirSubcat.value = true
    subcategoriaId.value = subcatId
    categoriaId.value = catId
}

function openModalNovaSubCategoria(id) {
    categoriaId.value = id
    showNovaSubCategoria.value = true
}

</script>
<template>
    <DashboardLayout titulo="Categorias" categoriaPagina="financeiro" pagina="categorias">
        <div class="card shadow mt-3 w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title m-0">Categorias</h2>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adicionarModal">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body pb-0">
                <div v-for="categoria in categorias.data">
                    <ul class="list-group mb-3">
                        <li class="list-group-item fw-bold d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" :data-bs-target="`#collapse` + categoria.id">
                            <h3>{{ categoria.nome }}</h3>
                            <div>
                                <button type="button" class="btn btn-primary"
                                    @click="openModalNovaSubCategoria(categoria.id)">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-danger ms-2 "
                                    @click="openModalExcluirCat(categoria.id)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </li>
                        <div class="collapse" :id="`collapse` + categoria.id">
                            <li v-for="subcategoria in categoria.subcategorias" class="list-group-item ">
                                <div class="d-flex justify-content-between align-items-center ms-4">
                                    <div>{{ subcategoria.nome }}</div>
                                    <button type="button" class="btn btn-danger ms-2 "
                                        @click="openModalExcluirSubcat(categoria.id, subcategoria.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>

                            </li>
                        </div>
                    </ul>
                </div>
                <div v-if="categorias.data.length === 0" class="alert alert-warning" role="alert">
                    Nenhuma categoria cadastrada.
                </div>
                <Paginacao :links="categorias.links">

                </paginacao>
            </div>
            <Novo :categorias="categorias" />
            <ExcluirCategoria :categoriaId="categoriaId" v-if="showModalExcluirCat"
                @close-modal="showModalExcluirCat = false" />
            <ExcluirSubcategoria :categoriaId="categoriaId" :subcategoriaId="subcategoriaId" v-if="showModalExcluirSubcat"
                @close-modal="showModalExcluirSubcat = false" />
            <NovaSubcategoria :categoriaId="categoriaId" v-if="showNovaSubCategoria"
                @close-modal="showNovaSubCategoria = false" />

        </div>
    </DashboardLayout>
</template>
