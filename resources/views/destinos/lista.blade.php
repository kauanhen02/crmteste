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
            <form action="{{ route('destinos.index') }}" method="GET" class="input-group search-area d-inline-flex mr-3 search-form">
                <div class="col-6">
                    <input type="hidden" name="pesquisa" value="1">
                    <input type="text" name="search" class="form-control " placeholder="Pesquise aqui" value="{{ $search }}">
                </div>
                <div class="col-3">
                    <select name="status" id="status" class="form-control ">
                        <option value="">Todos ativos/desativados</option>
                        <option value="ativo">Ativos</option>
                        <option value="desativado">Desativados</option>
                    </select>
                </div>
                <div class="col-1">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            
                <div class="col-2">
                    <div class="d-none d-lg-block">
                        @can('permissoes_tela', 'permissao_para_cadastrar_destino')
                            <a href="{{ route('destinos.create') }}" class="btn btn-primary btn-rounded btn-sm">+ Add destino</a>
                        @endcan
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive table-lista">
                    @include('destinos.table')
                </div>
            </div>
        </div>
    </div>
@endsection
