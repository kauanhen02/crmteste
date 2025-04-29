@extends('layout.layout')
@section('content')
    <div class="container-fluid">
        <!-- Mensagem de sucesso -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible   show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row mb-4">
            <form action="{{ route('produtos_servicos.index') }}" method="GET" class="input-group search-area d-inline-flex mr-3 search-form">
                <div class="col-3">
                    <input type="hidden" name="pesquisa" value="1">
                    <input type="text" name="search" class="form-control " placeholder="Pesquise aqui por: nome e cod" value="{{ $search }}">
                </div>
                <div class="col-3">
                    <select name="grupo_id" id="grupo_id" class="form-control ">
                        @include('layout.option_basic_lista', ['itens' => $grupos, 'texto' => 'Todos os grupo', 'campo' => 'nome'])
                    </select>
                </div>
                <div class="col-3">
                    <select name="sub_grupo_id" id="sub_grupo_id" class="form-control ">
                        @include('layout.option_basic_lista', ['itens' => $sub_grupos, 'texto' => 'Todos os sub grupo', 'campo' => 'nome'])
                    </select>
                </div>
                <div class="col-1">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            
                <div class="col-2">
                    <div class="d-none d-lg-block">
                        @can('permissoes_tela', 'permissao_para_cadastrar_produto_servico')
                            <a href="{{ route('produtos_servicos.create') }}" class="btn btn-primary btn-rounded btn-sm">+ Add produto serviço</a>
                        @endcan
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive table-lista">
                    @include('produtos_servicos.table')
                </div>
            </div>
        </div>
    </div>
@endsection
