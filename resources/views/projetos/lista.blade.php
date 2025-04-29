@extends('layout.layout')
@push('estilos')
    <style>
        .pendente-status {
            background: #0F66B0!important;
            color: white!important;
        }
        .aprovado-status {
            background: #2bc155!important;
            color: white!important;
        }
        .reprovado-status {
            background: #F46B68!important;
            color: white!important;
        }
        .enviar_laboratorio-status {
            background: #e9dd3f!important;
            color: black!important;
        }
        .avaliacao_final-status {
            background: #ff8a00!important;
            color: white!important;
        }
        .concluido-status {
            background: #A336C9!important;
            color: white!important;
        }
    </style>
@endpush
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
            <form action="{{ route('projetos.index') }}" method="GET" class="input-group search-area d-inline-flex mr-3 search-form">
                <div class="col-6">
                    <input type="hidden" name="pesquisa" value="1">
                    <input type="text" name="search" class="form-control " placeholder="Pesquise aqui" value="{{ $search }}">
                </div>
                <div class="col-2">
                    <select class="form-control" name="status" id="status">
                        <option value="">Todos status</option>
                        @foreach ($status as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                @can('permissoes_tela', 'permissao_para_visualizar_todos_projeto')
                    <div class="col-3">
                        <select class="form-control select2" name="usuario_id" id="usuario_id">
                            <option value="">Todos usuarios</option>
                            @foreach ($usuarios as $key => $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endcan
                <div class="col-1">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive table-lista">
                    @include('atendimentos.table')
                </div>
            </div>
        </div>
    </div>
@endsection
