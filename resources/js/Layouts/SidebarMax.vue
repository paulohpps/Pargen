<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    categoriaPagina: String,
    pagina: String,
});

</script>
<template>
    <div class="sidebar" id="sidebar-wrapper">
        <div class="w-100 navbar">
            <div class="accordion accordion-flush w-100" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <Link href="/dashboard/home"
                            class="accordion-button text-decoration-none accordeon-text-custom collapsed fw-normal">
                        <i class="fa-solid fa-house me-1"></i>HOME
                        </Link>
                    </h2>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button " type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" :aria-expanded="categoriaPagina == 'geral'"
                            aria-controls="flush-collapseOne" :class="{ 'collapsed': categoriaPagina != 'geral' }">
                            <i class="fa-solid fa-book me-2"></i> GERENCIAMENTO
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                        :class="{ 'show': categoriaPagina == 'geral' }" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul class="btn-toggle-nav list-unstyled fw-normal mb-0 ms-4">
                                <li>
                                    <Link href="/dashboard/fornecedores" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'fornecedores' }">Fornecedores</Link>
                                </li>
                                <li>
                                    <Link href="/dashboard/funcionarios" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'funcionarios' }">Funcionários</Link>
                                </li>
                                <li>
                                    <Link href="/dashboard/clientes/" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'clientes' }">
                                    Clientes</Link>
                                </li>
                                <li>
                                    <Link href="/dashboard/analises/" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'analises' }">
                                    Analises</Link>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" :aria-expanded="categoriaPagina == 'financeiro'"
                            aria-controls="flush-collapseTwo" :class="{ 'collapsed': categoriaPagina != 'financeiro' }">
                            <i class="fa-solid fa-wallet me-2"></i>FINANCEIRO
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                        :class="{ 'show': categoriaPagina == 'financeiro' }" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul class="btn-toggle-nav list-unstyled fw-normal mb-0 ms-4">
                                <li>
                                    <Link href="/dashboard/financeiro/categorias" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'categorias' }">Categorias</Link>
                                </li>
                                <li>
                                    <Link href="/dashboard/financeiro/receitas" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'receitas' }">Receitas</Link>
                                </li>
                                <li>
                                    <Link href="/dashboard/financeiro/pagamentos" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'pagamentos' }">Pagamentos</Link>
                                </li>
                                <li>
                                    <Link href="#" class="nav-link">Fluxo de
                                    caixa</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" :aria-expanded="categoriaPagina == 'lancamentos'"
                            aria-controls="flush-collapseThree" :class="{ 'collapsed': categoriaPagina != 'lancamentos' }">
                            <i class="fa-solid fa-file-lines me-2 ms-1"></i>LANÇAMENTOS
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        :class="{ 'show': categoriaPagina == 'lancamentos' }" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul class="btn-toggle-nav list-unstyled fw-normal mb-0 ms-4">
                                <li>
                                    <Link href="/dashboard/lancamentos" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'lancamentos' }">Lancamentos</Link>
                                </li>
                                <li>
                                    <Link href="/dashboard/servicos/" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'servicos' }">
                                    Serviços</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour"
                            :class="{ 'collapsed': categoriaPagina != 'fatura' }">
                            <i class="fa-solid fa-wallet me-2"></i>FATURA
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse"
                        :class="{ 'show': categoriaPagina == 'fatura' }" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul class="btn-toggle-nav list-unstyled fw-normal mb-0 ms-4">
                                <li>
                                    <Link href="/dashboard/fatura" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'faturar' }">Faturar</Link>
                                </li>
                                <li>
                                    <Link href="/dashboard/fatura/faturas" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'faturas' }">Faturas
                                    emitidas</Link>
                                </li>
                                <li>
                                    <Link href="/dashboard/fatura/baixar" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'Baixa de faturas' }">
                                    Baixa de faturas
                                    </Link>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive"
                            :class="{ 'collapsed': categoriaPagina != 'relatorio' }">
                            <i class="fa-solid fa-briefcase me-2"></i>RELATORIOS
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample"
                        :class="{ 'show': categoriaPagina == 'relatorio' }">
                        <div class="accordion-body">
                            <ul class="btn-toggle-nav list-unstyled fw-normal mb-0 ms-4">
                                <li>
                                    <Link href="/dashboard/relatorios/analise-financeira" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'analise_financeira' }">Análise financeira
                                    </Link>
                                </li>
                                <li>
                                    <Link href="#" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'evolucao_financeira' }">Evolução financeira
                                    </Link>
                                </li>
                                <li>
                                    <Link href="#" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'ranking_cliente' }">Ranking Cliente
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix"
                            :class="{ 'collapsed': categoriaPagina != 'dre' }">
                            <i class="fa-solid fa-briefcase me-2"></i>DRE
                        </button>
                    </h2>
                    <div id="flush-collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample"
                        :class="{ 'show': categoriaPagina == 'dre' }">
                        <div class="accordion-body">
                            <ul class="btn-toggle-nav list-unstyled fw-normal mb-0 ms-4">
                                <li>
                                    <Link href="#" class="nav-link" :class="{ 'text-primary': pagina == 'dre-mensal' }">
                                    DRE Mensal
                                    </Link>
                                </li>
                                <li>
                                    <Link href="#" class="nav-link" :class="{ 'text-primary': pagina == 'dre-anual' }">
                                    DRE Anual
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item"  v-if="usePage().props.auth.user.tipo_usuario === 1">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven"
                            :class="{ 'collapsed': categoriaPagina != 'administracao' }">
                            <i class="fa-solid fa-briefcase me-2"></i>ADMINISTRAÇÃO
                        </button>
                    </h2>
                    <div id="flush-collapseSeven" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample" :class="{ 'show': categoriaPagina == 'administracao' }">
                        <div class="accordion-body">
                            <ul class="btn-toggle-nav list-unstyled fw-normal mb-0 ms-4">
                                <li>
                                    <Link href="/dashboard/usuarios" class="nav-link"
                                        :class="{ 'text-primary': pagina == 'usuarios' }">Usuarios</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
