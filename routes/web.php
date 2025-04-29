<?php

use App\Http\Controllers\AtendimentoAnexos;
use App\Http\Controllers\AtendimentoEnvios;
use App\Http\Controllers\Atendimentos;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Carteiras;
use App\Http\Controllers\Categorias;
use App\Http\Controllers\Clientes;
use App\Http\Controllers\Destinos;
use App\Http\Controllers\Envios;
use App\Http\Controllers\FormasAtuacoes;
use App\Http\Controllers\Grupos;
use App\Http\Controllers\Linhas;
use App\Http\Controllers\LinhasProdutos;
use App\Http\Controllers\ModelosImpressoes;
use App\Http\Controllers\Perfis;
use App\Http\Controllers\ProdutosServicos;
use App\Http\Controllers\Projetos;
use App\Http\Controllers\Segmentos;
use App\Http\Controllers\StatusLGPD;
use App\Http\Controllers\SubGrupos;
use App\Http\Controllers\TipoAtendimentos;
use App\Http\Controllers\TipoSolicitacoes;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\Volumes;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect()->route('login.form');
})->name('login.redirect');
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    });

    Route::resource('usuarios', Usuarios::class)->names('usuarios');

    Route::resource('perfis', Perfis::class)->names('perfis')->parameters([
        'perfis' => 'perfil'
    ]);
    Route::get('habilidades/{perfil}', [Perfis::class, 'habilidades'])->name('perfis.habilidades');
    Route::post('habilidades-salvar/{perfil}', [Perfis::class, 'habilidadesStore'])->name('perfis.habilidadesStore');

    Route::resource('carteiras', Carteiras::class)->names('carteiras');
    Route::post('ativar-desativar-carteira/{carteira}', [Carteiras::class, 'ativarDesativar'])->name('carteiras.ativar_desativar');
    
    Route::resource('segmentos', Segmentos::class)->names('segmentos');
    Route::post('ativar-desativar-segmento/{segmento}', [Segmentos::class, 'ativarDesativar'])->name('segmentos.ativar_desativar');
    
    Route::resource('forma-atuacao', FormasAtuacoes::class)->names('formas_atuacoes')->parameters([
        'forma-atuacao' => 'atuacao'
    ]);
    Route::post('ativar-desativar-forma-atuacao/{atuacao}', [FormasAtuacoes::class, 'ativarDesativar'])->name('formas_atuacoes.ativar_desativar');
    
    Route::resource('sub-grupo', SubGrupos::class)->names('sub_grupos')->parameters([
        'sub-grupo' => 'sub'
    ]);
    Route::post('ativar-desativar-sub-grupo/{sub}', [SubGrupos::class, 'ativarDesativar'])->name('sub_grupos.ativar_desativar');
    
    Route::resource('grupo', Grupos::class)->names('grupos');
    Route::post('ativar-desativar-grupo/{grupo}', [Grupos::class, 'ativarDesativar'])->name('grupos.ativar_desativar');
    
    Route::resource('status', StatusLGPD::class)->names('status')->parameters([
        'status' => 'statu'
    ]);
    Route::post('ativar-desativar-status/{statu}', [StatusLGPD::class, 'ativarDesativar'])->name('status.ativar_desativar');
    
    Route::resource('cliente', Clientes::class)->names('clientes');
    Route::post('ativar-desativar-cliente/{cliente}', [Clientes::class, 'ativarDesativar'])->name('clientes.ativar_desativar');
    
    Route::resource('produtos-servicos', ProdutosServicos::class)->names('produtos_servicos')->parameters([
        'produtos-servicos' => 'produto_servico'
    ]);

    Route::resource('envio', Envios::class)->names('envios');
    Route::post('ativar-desativar-envio/{envio}', [Envios::class, 'ativarDesativar'])->name('envios.ativar_desativar');

    Route::resource('tipo-atendimento', TipoAtendimentos::class)->names('tipoAtendimentos')->parameters([
        'tipo-atendimento' => 'atendimento'
    ]);
    Route::post('ativar-desativar-tipo-atendimento/{atendimento}', [TipoAtendimentos::class, 'ativarDesativar'])->name('tipoAtendimentos.ativar_desativar');
    
    Route::resource('tipo-solicitacao', TipoSolicitacoes::class)->names('tipoSolicitacoes')->parameters([
        'tipo-solicitacao' => 'solicitacao'
    ]);
    Route::post('ativar-desativar-tipo-solicitacao/{solicitacao}', [TipoSolicitacoes::class, 'ativarDesativar'])->name('tipoSolicitacoes.ativar_desativar');

    Route::resource('categorias', Categorias::class)->names('categorias');
    Route::post('ativar-desativar-categoria/{categoria}', [Categorias::class, 'ativarDesativar'])->name('categorias.ativar_desativar');

    Route::resource('linhas', Linhas::class)->names('linhas');
    Route::post('ativar-desativar-linha/{linha}', [Linhas::class, 'ativarDesativar'])->name('linhas.ativar_desativar');
    Route::post('get-linhas-categoria', [Linhas::class, 'getLinhasCategoria'])->name('linhas.getLinhasCategoria');

    Route::resource('volumes', Volumes::class)->names('volumes');
    Route::post('ativar-desativar-volume/{volume}', [Volumes::class, 'ativarDesativar'])->name('volumes.ativar_desativar');

    Route::resource('destinos', Destinos::class)->names('destinos');
    Route::post('ativar-desativar-destino/{destino}', [Destinos::class, 'ativarDesativar'])->name('destinos.ativar_desativar');

    Route::resource('atendimentos', Atendimentos::class)->names('atendimentos');
    Route::post('atendimentos-acao-marketing/{atendimento}', [Atendimentos::class, 'acaoMarketing'])->name('atendimentos.acaoMarketing');
    Route::post('atendimentos-concorrente/{atendimento}', [Atendimentos::class, 'concorrente'])->name('atendimentos.concorrente');
    Route::post('atendimentos-change-status/{atendimento}', [Atendimentos::class, 'changeStatus'])->name('atendimentos.changeStatus');
    
    Route::resource('atendimentos.linhas-produtos', LinhasProdutos::class)->names('linhasProdutos')->parameters([
        'linhas-produtos' => 'linha'
    ]);

    Route::resource('atendimentos.atendimento-envios', AtendimentoEnvios::class)->names('atendimentoEnvios')->parameters([
        'atendimento-envios' => 'envio'
    ]);

    Route::resource('atendimentos.atendimento-anexos', AtendimentoAnexos::class)->names('atendimentoAnexos')->parameters([
        'atendimento-anexos' => 'anexo'
    ]);
    Route::get('atendimentos/{atendimento}/get-anexo/{anexo}', [AtendimentoAnexos::class, 'getAnexo'])->name('atendimentoAnexos.getAnexo');
    Route::get('atendimentos/{atendimento}/baixa-anexo/{anexo}', [AtendimentoAnexos::class, 'baixarAnexo'])->name('atendimentoAnexos.baixarAnexo');

    Route::resource('projetos', Projetos::class)->names('projetos')->parameters([
        'projetos' => 'atendimento'
    ]);
    Route::post('projetos-edit/{atendimento}', [Projetos::class, 'editProjeto'])->name('projetos.editProjeto');
    Route::get('projetos-imprimir/{atendimento}', [Projetos::class, 'imprimirProjeto'])->name('projetos.imprimirProjeto');

    Route::resource("modelos-impressao", ModelosImpressoes::class)->names('modelosImpressao')->parameters([
        'modelos-impressao' => 'modelo'
    ]);
    Route::post('ativar-desativar-modelos-impressao/{modelo}', [ModelosImpressoes::class, 'ativarDesativar'])->name('modelosImpressao.ativar_desativar');
});