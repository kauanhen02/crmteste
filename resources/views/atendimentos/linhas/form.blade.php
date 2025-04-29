<form
    action="{{ isset($linha) ? route('linhasProdutos.update', [$atendimento, $linha]) : route('linhasProdutos.store', [$atendimento]) }}"
    enctype="multipart/form-data" method="POST" id="formLinha">
    @csrf
    @if (isset($linha))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-3 form-group">
                    <label class="form-control-label">Categorias <span class="text-danger">*</span></label>
                    <select name="categoria_id" id="categoria_id" class="select2">
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categorias as $item)
                            <option value="{{$item->id}}" @if (old('categoria_id', !empty($linha) ? $linha->categoria_id : '') == $item->id) selected @endif>{{$item->nome}}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Linha</label>
                    <select name="linha_id" id="linha_id" class="select2 form-control">
                        <option value="">Selecione uma linha</option>
                    </select>
                    <input type="hidden" name="linha_id_selecionada" id="linha_id_selecionada" value="{{ $linha->linha_id ?? '' }}">
                    @error('linha_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Qtde amostra: (g)</label>
                    <input type="number" step='1' class="form-control" id="quantidade" name="quantidade"
                        value="{{ old('quantidade', isset($linha) ? $linha->quantidade : 1 ) }}">
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Nº de sugestões</label>
                    <input type="number" step='1' class="form-control" id="numero_sugestoes" name="numero_sugestoes"
                        value="{{ old('numero_sugestoes', isset($linha) ? $linha->numero_sugestoes : 0 ) }}">
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Volume</label>
                    <select name="volume_id" id="volume_id" class="select2 form-control">
                        <option value="">Selecione um volume</option>
                        @foreach ($volumes as $item)
                            <option value="{{ $item->id }}" @if (old('volume_id', isset($linha) ? $linha->volume_id : '') == $item->id) selected @endif>
                                {{ $item->nome }}</option>
                        @endforeach
                    </select>
                    @error('volume_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6 form-group">
                    <label class="form-control-label">Custo venda</label>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label class="form-control-label">Mínimo</label>
                            <input type="number" step='0.01' class="form-control" id="custo_venda_minimo" name="custo_venda_minimo" value="{{ old('custo_venda_minimo', isset($linha) ? $linha->custo_venda_minimo : 0 ) }}">
                        </div>
                        <div class="col-6 form-group">
                            <label class="form-control-label">Máximo</label>
                            <input type="number" step='0.01' class="form-control" id="custo_venda_maximo" name="custo_venda_maximo" value="{{ old('custo_venda_maximo', isset($linha) ? $linha->custo_venda_maximo : 0 ) }}">
                        </div>
                    </div>
                </div>
                <div class="col-6 form-group">
                    <label class="form-control-label">% Aplicação</label>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label class="form-control-label">Mínimo</label>
                            <input type="number" step='0.001' class="form-control" id="aplicacao_minimo" name="aplicacao_minimo" value="{{ old('aplicacao_minimo', isset($linha) ? $linha->aplicacao_minimo : 0 ) }}">
                        </div>
                        <div class="col-6 form-group">
                            <label class="form-control-label">Máximo</label>
                            <input type="number" step='0.001' class="form-control" id="aplicacao_maximo" name="aplicacao_maximo" value="{{ old('aplicacao_maximo', isset($linha) ? $linha->aplicacao_maximo : 0 ) }}">
                        </div>
                    </div>
                </div>
            
                <div class="col-2 form-group">
                    <input type="checkbox" name="custo_beneficio" id="custo_beneficio" value="1" data-grupo="custo_beneficio"
                        @if (isset($linha) && $linha->custo_beneficio) checked @endif>
                    <label for="custo_beneficio" class="form-check-label">Custo benefício</label>
                </div>
                <div class="col-2 form-group">
                    <input type="checkbox" name="aplicacao" id="aplicacao" value="1" data-grupo="aplicacao"
                        @if (isset($linha) && $linha->aplicacao) checked @endif>
                    <label for="aplicacao" class="form-check-label">Aplicação</label>
                </div>
                <div class="col-2 form-group aplicacao-check">
                    <label class="form-control-label">Base</label>
                    <select name="base" id="base" class="select2 form-control">
                        <option value="">Selecione uma base</option>
                        <option value='cliente' @if (old('base', isset($linha) ? $linha->base : '') == 'cliente') selected @endif> Cliente</option>
                        <option value='propria' @if (old('base', isset($linha) ? $linha->base : '') == 'propria') selected @endif> Própria</option>
                    </select>
                    @error('base')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 form-group aplicacao-check">
                    <label class="form-control-label">Observação</label>
                    <textarea class="form-control" name="obs" id="obs" cols="10" rows="5">{{isset($linha) ? $linha->obs : ''}}</textarea>
                </div>
                <div class="col-3 form-group aplicacao-check">
                    <input type="checkbox" name="aplicacao_personalizada" id="aplicacao_personalizada" value="1" data-grupo="aplicacao_personalizada"
                        @if ( isset($linha) && $linha->aplicacao_personalizada) checked @endif>
                    <label for="aplicacao_personalizada" class="form-check-label">Aplicação personalizada</label>
                </div>
                <div class="col-3 form-group aplicacao-check">
                    <input type="checkbox" name="estabilidade" id="estabilidade" value="1" data-grupo="estabilidade"
                        @if ( isset($linha) && $linha->estabilidade) checked @endif>
                    <label for="estabilidade" class="form-check-label">Estabilidade</label>
                </div>
                <div class="col-3 form-group aplicacao-check">
                    <input type="checkbox" name="sugestao_formulacao" id="sugestao_formulacao" value="1" data-grupo="sugestao_formulacao"
                        @if ( isset($linha) && $linha->sugestao_formulacao) checked @endif>
                    <label for="sugestao_formulacao" class="form-check-label">Sugestão formulação</label>
                </div>
                <div class="col-3 form-group aplicacao-check">
                    <input type="checkbox" name="suporte_tecnico" id="suporte_tecnico" value="1" data-grupo="suporte_tecnico"
                        @if ( isset($linha) && $linha->suporte_tecnico) checked @endif>
                    <label for="suporte_tecnico" class="form-check-label">Suporte técnico</label>
                </div>
                <div class="col-12 form-group">
                    <label class="form-control-label">Observação olfativa</label>
                    <textarea class="form-control" name="obs_olfativa" id="obs_olfativa" cols="10" rows="5">{{isset($linha) ? $linha->obs_olfativa : ''}}</textarea>
                </div>
            </div>
        </div>
        <div class="offset-9 col-3">
            <button type="button" id="salvar-linha-produto" style="float: right; padding: 5px; margin: 5px"
                class="btn btn-success">Salvar</button>
            <button type="button" id="btn-volta-linha-produto" style="float: right; padding: 5px; margin: 5px"
                class="btn btn-info" data-url="{{ route('linhasProdutos.index', $atendimento) }}"> Voltar</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        verificaAplicacaoCheck();
        getLinhasProduto();
        $(".select2").select2()
    });

    $("#aplicacao").on('change', function(){
        verificaAplicacaoCheck();
    })

    function verificaAplicacaoCheck()
    {
        if($("#aplicacao").is(":checked")){
            $(".aplicacao-check").show();
        }else{
            $(".aplicacao-check").hide();
        }
    }

    $("#salvar-linha-produto").on('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        $("#formLinha").submit();
    });

    $("#formLinha").on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        let url = $(this).attr('action');
        Olimpus.ajaxForm('formLinha', url, routeToGo = null, () => {
            $("#btn-volta-linha-produto").click()
        }); 
    });

    $("#categoria_id").on('change', function(){
        getLinhasProduto();
    });

    function getLinhasProduto(){
        if($("#categoria_id").val()){
            $.ajax({
                url: "{{ route('linhas.getLinhasCategoria') }}",
                method: "POST",
                data: {
                    '_token': token,
                    "categoria_id": $("#categoria_id").val()
                },
                beforeSend: () => {
                    Olimpus.preload();
                },
                success: function (data) {
                    let options = $("#linha_id");
                    options.find('option').filter(':not([value=""])').remove();
                    let selected = ""
                    if(data.linhas.length > 0){
                        $.each(data.linhas, function(index, el) {
                            if(el.id == $("#linha_id_selecionada").val()){
                                selected = "selected"
                            }
                            options.append(`<option value='${el.id}' ${selected}>${el.nome}</option>`)
                        })
                    }
                },
                complete: () => {
                    Olimpus.preloadOff();
                },
                error: () => {
                    Olimpus.preloadOff();
                }
            });   
        }
    }
</script>