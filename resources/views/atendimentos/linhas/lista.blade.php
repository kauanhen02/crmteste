<div class="row mb-4">
    <div class="col-12">
        <div class="row">
            <div class="col-4 form-group">
                <label class="form-control-label">Tipo solicitação <span class="text-danger">*</span></label>
                <select name="tipo_solicitacao_id" id="tipo_solicitacao_id" class="select2">
                    <option value="">Selecione uma solicitação</option>
                    @foreach ($tipo_solicitacoes as $item)
                        <option value="{{$item->id}}" @if (old('tipo_solicitacao_id', !empty($atendimento) ? $atendimento->tipo_solicitacao_id : '') == $item->id) selected @endif>{{$item->nome}}</option>
                    @endforeach
                </select>
                @error('tipo_solicitacao_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-4 form-group">
                <label class="form-control-label">Solicitado por <span class="text-danger">*</span></label>
                <select name="solicitado_por" id="solicitado_por" class="select2">
                    <option value="">Não selecionado</option>
                    <option value="cliente" @if (old('solicitado_por', !empty($atendimento) ? $atendimento->solicitado_por : '') == 'cliente') selected @endif>Cliente</option>
                    <option value="executivo" @if (old('solicitado_por', !empty($atendimento) ? $atendimento->solicitado_por : '') == 'executivo') selected @endif>Executivo</option>
                </select>
                @error('solicitado_por')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-8 form-group">
                        <label class="form-control-label">Data da amostra recebida</label>
                        <input type="date" class="form-control" id="data_recebimento_amostra" name="data_recebimento_amostra" value="{{old('data_recebimento_amostra', isset($atendimento->data_recebimento_amostra) ? $atendimento->data_recebimento_amostra->format('Y-m-d') : date('Y-m-d'))}}">
                    </div>
                    <div class="col-4 form-group" style="padding-top: 30px;">
                        <input type="checkbox" id="exportacao" value="1" data-grupo="exportacao" @if ($atendimento->exportacao) checked @endif>
                        <label for="exportacao" class="form-check-label">Exportação</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr style="width: 100%">
    <form action="{{ route('linhasProdutos.index', $atendimento) }}" method="GET" class="input-group search-area d-inline-flex mr-3 search-form-lista" data-table="table-lista-linha">
        <div class="col-9">
            <input type="hidden" name="pesquisa" value="1">
            <input type="text" name="search_linha" class="form-control " placeholder="Pesquise pela linha aqui" value="{{ isset($search_linha) ? $search_linha : "" }}">
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    
        @if(!isset($projeto))
            <div class="col-2">
                @can('permissoes_tela', 'permissao_para_cadastrar_linha_produto')
                    <button type="button" data-url="{{route('linhasProdutos.create', $atendimento)}}" id="btn-add-linha-produto" class="btn btn-primary btn-rounded btn-sm"><i class="fa-solid fa-plus"></i> Add linha de produto</button>
                @endcan        
            </div>
        @endif
    </form>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive table-lista table-lista-linha">
            @include('atendimentos.linhas.table')
        </div>
    </div>
</div>