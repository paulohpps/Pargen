<?php

use App\Http\Controllers\AnalisesController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\Dashboard\ContaController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\FaturaController;
use App\Http\Controllers\Dashboard\Financeiro\CategoriaController;
use App\Http\Controllers\Dashboard\Financeiro\PagamentoController;
use App\Http\Controllers\Dashboard\Financeiro\PagamentoFornecedorController;
use App\Http\Controllers\Dashboard\Financeiro\PagamentoFuncionarioController;
use App\Http\Controllers\Dashboard\Financeiro\ReceitaController;
use App\Http\Controllers\Dashboard\Geral\FornecedorController;
use App\Http\Controllers\Dashboard\Geral\FuncionarioController;
use App\Http\Controllers\Dashboard\Relatorios\RelatorioController;
use App\Http\Controllers\LancamentoController;
use App\Http\Controllers\ServicosController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard')->group(function () {
    Route::get('/home', [DashboardController::class, 'home'])->name('.home');
    Route::prefix('usuarios')->name('.usuarios')->group(function () {
        Route::get('', [DashboardController::class, 'usuarios'])->name('');
        Route::post('/criar', [DashboardController::class, 'criarUsuario'])->name('.criar');
        Route::get('/editar/{id}', [DashboardController::class, 'editarUsuario'])->name('.editar');
        Route::post('/editar/{id}', [DashboardController::class, 'editarUsuario'])->name('.salvar');
        Route::get('/excluir/{id}', [DashboardController::class, 'excluirUsuario'])->name('.excluir');
        Route::get('/{id}', [DashboardController::class, 'getUsuario'])->name('.get');
    });

    Route::prefix('clientes')->name('.clientes')->group(function () {
        Route::get('', [ClientesController::class, 'clientes'])->name('');
        Route::post('/editar/categoria/', [ClientesController::class, 'editarCategoria'])->name('.editar.categoria');
    });

    Route::prefix('servicos')->name('.servicos')->group(function () {
        Route::get('', [ServicosController::class, 'servicos'])->name('');
        Route::post('/criar', [ServicosController::class, 'criarServico'])->name('.criar');
        Route::get('/editar/{id}', [ServicosController::class, 'editarServico'])->name('.editar');
        Route::post('/salvar/{id}', [ServicosController::class, 'salvarServico'])->name('.salvar');
        Route::get('/excluir/{id}', [ServicosController::class, 'excluirServico'])->name('.excluir');
        Route::get('/ajax', [ServicosController::class, 'ajax'])->name('.ajax');
    });

    Route::prefix('analises')->name('.analises')->group(function () {
        Route::get('', [AnalisesController::class, 'listagem'])->name('');
        Route::post('/editar/categoria', [AnalisesController::class, 'editar'])->name('.editar');
    });

    Route::prefix('funcionarios')->name('.funcionarios')->group(function () {
        Route::get('', [FuncionarioController::class, 'funcionarios'])->name('');
        Route::post('/criar', [FuncionarioController::class, 'criarFuncionario'])->name('.criar');
        Route::get('{id}/editar/', [FuncionarioController::class, 'editarFuncionario'])->name('.editar');
        Route::post('{id}/salvar/', [FuncionarioController::class, 'salvarFuncionario'])->name('.salvar');
        Route::get('{id}/excluir/', [FuncionarioController::class, 'excluirFuncionario'])->name('.excluir');
        Route::get('/consultar', [FuncionarioController::class, 'consultar'])->name('.consultar');
    });

    Route::prefix('fornecedores')->name('.fornecedores')->group(function () {
        Route::get('', [FornecedorController::class, 'fornecedores'])->name('');
        Route::post('/criar', [FornecedorController::class, 'criarFornecedor'])->name('.criar');
        Route::get('/{id}/editar', [FornecedorController::class, 'editarFornecedor'])->name('.editar');
        Route::post('/{id}/salvar', [FornecedorController::class, 'salvarFornecedor'])->name('.salvar');
        Route::get('/{id}/excluir', [FornecedorController::class, 'excluirFornecedor'])->name('.excluir');
        Route::get('/consultar', [FornecedorController::class, 'consultar'])->name('.consultar');
    });

    Route::prefix('financeiro')->name('.financeiro')->group(function () {
        Route::prefix('categorias')->name('.categorias')->group(function () {
            Route::get('', [CategoriaController::class, 'categorias'])->name('');
            Route::post('/criar', [CategoriaController::class, 'criarCategoria'])->name('.criar');
            Route::post('/{categoria_id}/subcategorias/criar', [CategoriaController::class, 'criarSubcategoria'])->name('.subcategorias.criar');
            Route::get('/{id}/excluir', [CategoriaController::class, 'excluirCategoria'])->name('.excluir');
            Route::get('/{categoria_id}/subcategorias/{subcat_id}/excluir', [CategoriaController::class, 'excluirSubcategoria'])->name('.subcategorias.excluir');
            Route::get('/consultar', [CategoriaController::class, 'getCategorias'])->name('.editar');
            Route::get('/{categoria_id}/subcategorias', [CategoriaController::class, 'getSubcategorias'])->name('.subcategorias');
        });

        Route::prefix('pagamentos')->name('.pagamentos')->group(function () {
            Route::get('', [PagamentoController::class, 'pagamentos'])->name('');
            Route::post('/criar', [PagamentoController::class, 'criar'])->name('.criar');
            Route::get('/{id}/editar', [PagamentoController::class, 'editar'])->name('.editar');
            Route::post('/{id}/salvar', [PagamentoController::class, 'salvar'])->name('.salvar');
            Route::get('/{id}/excluir', [PagamentoController::class, 'excluir'])->name('.excluir');
            Route::get('/consultar', [PagamentoController::class, 'consultar'])->name('.consultar');
        });

        Route::prefix('receitas')->name('.receitas')->group(function () {
            Route::get('', [ReceitaController::class, 'receitas'])->name('');
            Route::post('/criar', [ReceitaController::class, 'criar'])->name('.criar');
            Route::get('/{id}/editar', [ReceitaController::class, 'editar'])->name('.editar');
            Route::post('/{id}/salvar', [ReceitaController::class, 'salvar'])->name('.salvar');
            Route::get('/{id}/excluir', [ReceitaController::class, 'excluir'])->name('.excluir');
        });
    });

    Route::prefix('lancamentos')->name(".lancamentos")->group(function () {
        Route::get('', [LancamentoController::class, 'home'])->name('');
        Route::post('/criar', [LancamentoController::class, 'criar'])->name('.criar');
        Route::get('/{id}/editar', [LancamentoController::class, 'editar'])->name('.editar');
        Route::post('/{id}/salvar', [LancamentoController::class, 'salvar'])->name('.salvar');
        Route::get('/{id}/excluir', [LancamentoController::class, 'excluir'])->name('.excluir');
    });


    Route::prefix('fatura')->name(".fatura")->group(function () {
        Route::get('', [FaturaController::class, 'home'])->name('');
        Route::get('faturar', [FaturaController::class, 'faturar'])->name('.faturar');
        Route::post('faturar/gerar', [FaturaController::class, 'gerarFatura'])->name('.gerarFatura');
        Route::get('faturas', [FaturaController::class, 'faturas'])->name('.faturas');
        Route::get('baixar', [FaturaController::class, 'faturasBaixa'])->name('.faturas.baixar');
        Route::get('faturas/{id}/download', [FaturaController::class, 'fatura'])->name('.download');
        Route::get('faturas/{id}/servicos', [FaturaController::class, 'faturaServico'])->name('.faturas.servicos');
        Route::get('faturas/{id}/baixa', [FaturaController::class, 'baixarFatura'])->name('.baixar');
    });

    Route::prefix('relatorios')->name(".relatorios")->group(function () {
        Route::get('servicos', [RelatorioController::class, 'servicos'])->name('.servicos');
        Route::get('servicos/faturamento', [RelatorioController::class, 'servicosFaturamento'])->name('.servicos.faturamento');
        Route::get('analise-financeira', [RelatorioController::class, 'analiseFinanceira'])->name('.analiseFinanceira');
    });


    Route::get('/conta', [ContaController::class, 'home'])->name('.conta');
    Route::post('/conta/alterar-senha', [ContaController::class, 'alterarSenha'])->name('.conta.alterar-senha');
});
