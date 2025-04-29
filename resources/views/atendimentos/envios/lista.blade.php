<div class="row mb-4">
    <form action="{{ route('atendimentoEnvios.index', $atendimento) }}" method="GET" class="input-group search-area d-inline-flex mr-3 search-form-lista" data-table="table-lista-envio">
        <div class="col-9">
            <input type="hidden" name="pesquisa" value="1">
            <input type="text" name="search_destino" class="form-control " placeholder="Pesquise pelo destino aqui" value="{{ isset($search_destino) ? $search_destino : "" }}">
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    
        @if(!isset($projeto))
            <div class="col-2">
                <div class="d-none d-lg-block">
                    @can('permissoes_tela', 'permissao_para_cadastrar_atendimento_envio')
                        <button type="button" data-url="{{route('atendimentoEnvios.create', $atendimento)}}" id="btn-add-envios" class="btn btn-primary btn-rounded btn-sm">+ Add envio</button>
                    @endcan
                </div>
            </div>
        @endif
    </form>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive table-lista table-lista-envio">
            @include('atendimentos.envios.table')
        </div>
    </div>
</div>