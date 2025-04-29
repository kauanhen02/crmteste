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
            <div class="col-10">
                <form action="{{ route('perfis.index') }}" method="GET" class="input-group search-area d-inline-flex mr-3 search-form">
                    <input type="hidden" name="pesquisa" value="1">
                    <input type="text" name="search" class="form-control" placeholder="Pesquise aqui"
                        value="{{ $search }}">
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-2">
                <div class="d-none d-lg-block">
                    @can('permissoes_tela', 'permissao_para_cadastrar_perfil')
                        <a href="{{ route('perfis.create') }}" class="btn btn-primary btn-rounded btn-sm">+ Add perfil</a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive table-lista">
                    @include('perfis.table')
                </div>
            </div>
        </div>
    </div>
@endsection
