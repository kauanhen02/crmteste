<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest\CriarUsuarioRequest;
use App\Http\Requests\UsuarioRequest\EditUsuarioRequest;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_visualizar_usuarios');
        $search = $request->input('search');

        // Consulta com filtro de busca se houver um termo de pesquisa, ou retorna todos
        $usuarios = User::pesquisaManyCampos($request, 'search', ['name', 'email'])->paginate(10);

        if(isset($request->pesquisa) && $request->pesquisa == 1){
            return view('usuarios.table', [
                'usuarios' => $usuarios,
                'search' => $search,
            ]);
        }
        
        return view('usuarios.lista', [
            'usuarios' => $usuarios,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_usuarios');

        $perfis = Perfil::get();
        return view('usuarios.form', [
            'perfis' => $perfis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarUsuarioRequest $request)
    {
        $this->authorize('permissoes_tela', 'permissao_para_cadastrar_usuarios');

        $dados = $request->validated();
        $dados['status'] = $request->boolean('status');
        $dados['password'] = Hash::make($dados['password']);

        DB::transaction(function() use($dados, $request)  {
            $usuario = User::create($dados);
            $usuario->criarLogCadastro($request->user());
        });

        return redirect()->route('usuarios.index')->with('success', 'Usuario criado com sucesso!');
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
    public function edit(User $usuario)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_usuarios');

        $perfis = Perfil::get();
        return view('usuarios.form', [
            'perfis' => $perfis,
            'usuario' => $usuario,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUsuarioRequest $request, User $usuario)
    {
        $this->authorize('permissoes_tela', 'permissao_para_editar_usuarios');

        $dados = $request->validated();
        $dados['status'] = $request->boolean('status');
        if(isset($dados['password'])){
            $dados['password'] = Hash::make($dados['password']);
        }else{
            unset($dados['password']);
        }

        DB::transaction(function() use($dados, $usuario, $request)  {
            $usuario->update($dados);
            $usuario->criarLogEdicao($request->user());
        });

        return redirect()->route('usuarios.edit', $usuario)->with('success', 'Usuario editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $usuario)
    {
        $this->authorize('permissoes_tela', 'permissao_para_excluir_usuarios');

        DB::transaction(function() use($usuario, $request)  {
            $usuario->delete();
            $usuario->criarLogExclusao($request->user());
        });

        return response()->json([
            'text' => 'Usuario excluido com sucesso!'
        ]);
        // return redirect()->route('usuarios.index')->with('success', 'Usuario excluido com sucesso!');
    }
}
