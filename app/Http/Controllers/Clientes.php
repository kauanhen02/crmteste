<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientesRequest\CriarCliente;
use App\Models\Carteira;
use App\Models\Cliente;
use App\Models\FormaAtuacao;
use App\Models\Segmento;
use App\Models\StatuLGPD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Clientes extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_cliente');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $clientes = Cliente::pesquisaManyCampos($request, 'search', ['nome', 'email', 'razao_social', 'telefone'])->pesquisaStatus($request, 'status', 'status')->paginate(10);
        
        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('clientes.table', [
                'clientes' => $clientes,
                'search' => $search,
            ]);
        }
        
        return view('clientes.lista', [
            'clientes' => $clientes,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_cliente');

        $carteiras = Carteira::where('status', 1)->get();
        $segmentos = Segmento::where('status', 1)->get();
        $formas = FormaAtuacao::where('status', 1)->get();
        $status = StatuLGPD::where('status', 1)->get();

        return view('clientes.form', [
            'carteiras' => $carteiras,
            'segmentos' => $segmentos,
            'formas' => $formas,
            'status' => $status
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarCliente $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_cliente');

        $dados = $request->validated();
        DB::transaction(function() use($dados, $request)  {
            $cliente = Cliente::create($dados);
            $cliente->criarLogCadastro($request->user());
        });

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_cliente');
        
        $carteiras = Carteira::where('status', 1)->get();
        $segmentos = Segmento::where('status', 1)->get();
        $formas = FormaAtuacao::where('status', 1)->get();
        $status = StatuLGPD::where('status', 1)->get();

        return view('clientes.form', [
            'cliente' => $cliente,
            'carteiras' => $carteiras,
            'segmentos' => $segmentos,
            'formas' => $formas,
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CriarCliente $request, Cliente $cliente)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_cliente');

        $dados = $request->validated();

        DB::transaction(function() use($dados, $cliente, $request)  {
            $cliente->update($dados);
            $cliente->criarLogEdicao($request->user());
        });

        return redirect()->route('clientes.edit', $cliente)->with('success', 'Cliente editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Cliente $cliente)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_cliente');

        DB::transaction(function() use($cliente, $request)  {
            $cliente->delete();
            $cliente->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Cliente excluida com sucesso!'
        ]);
        // return redirect()->route('clientes.index')->with('success', 'Cliente excluido com sucesso!');
    }

    function ativarDesativar(Request $request, Cliente $cliente)
    {
        $this->authorize('permissoes_tela', 'permissao_para_ativar_desativar_cliente');
        
        $cliente = DB::transaction(function() use($cliente, $request)  {
            $tipo = $cliente->status ? 0 : 1;
            $cliente->update(['status' => $tipo]);
            $cliente->criarLogEdicao($request->user());
            return $cliente;
        });

        $text = $cliente->status ? 'ativado' : 'desativado';
        
        return response()->json([
            'title' => ucfirst($text),
            'text' => "Cliente {$text} com sucesso!",
            'tipo' => $cliente->status ? 'ativo' : 'desativado'
        ]);
    }
}