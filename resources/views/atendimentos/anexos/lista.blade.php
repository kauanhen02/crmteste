<div class="row mb-4">
    <form action="{{ route('atendimentoAnexos.index', $atendimento) }}" method="GET" class="input-group search-area d-inline-flex mr-3 search-form-lista" data-table="table-lista-anexo">
        <div class="col-9">
            <input type="hidden" name="pesquisa" value="1">
            <input type="text" name="search_anexo" class="form-control " placeholder="Pesquise pelo destino aqui" value="{{ isset($search_anexo) ? $search_anexo : "" }}">
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    
        @if(!isset($projeto))
            <div class="col-2">
                <div class="d-none d-lg-block">
                    @can('permissoes_tela', 'permissao_para_cadastrar_atendimento_anexo')
                        <button type="button" data-url="{{route('atendimentoAnexos.create', $atendimento)}}" id="btn-add-anexos" class="btn btn-primary btn-rounded btn-sm">+ Add anexo</button>
                    @endcan
                </div>
            </div>
        @endif
    </form>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive table-lista table-lista-anexo">
            @include('atendimentos.anexos.table')
        </div>
    </div>
</div>