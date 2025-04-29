<form
    action="{{ route('atendimentos.acaoMarketing', [$atendimento]) }}"
    enctype="multipart/form-data" method="POST" id="formAcaoMarketing">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-2 form-group">
                    <input type="checkbox" name="acao_marketing" id="acao_marketing" value="1" data-grupo="acao_marketing"
                        @if (isset($atendimento) && $atendimento->acao_marketing) checked @endif>
                    <label for="acao_marketing" class="form-check-label">Ação de marketing</label>
                </div>            
                <div class="col-12 form-group open-acao-marketing">
                    <label class="form-control-label">Observação</label>
                    <textarea class="form-control" name="obs_marketing" id="obs_marketing" cols="10" rows="5">{{$atendimento->obs_marketing ?? ''}}</textarea>
                </div>
                <div class="col-12 form-group close-acao-marketing">
                    <input type="checkbox" name="piramide_olfativa_1" id="piramide_olfativa_1" value="1" data-grupo="piramide_olfativa_1"
                        @if (isset($atendimento) && $atendimento->piramide_olfativa_1) checked @endif>
                    <label for="piramide_olfativa_1" class="form-check-label"><b>1. Piramide olfativa:</b> documento que identifica a Familia Olfativa a qual uma fragrância pertence, e descreve os principais ingredientes presentes na composição da mesma, considerando os seus três estágios da evolução: notas de saída, corpo e fundo.</label>
                </div>            
                <div class="col-12 form-group">
                    <input type="checkbox" name="descricao_olfativa_2" id="descricao_olfativa_2" value="1" data-grupo="descricao_olfativa_2"
                        @if (isset($atendimento) && $atendimento->descricao_olfativa_2) checked @endif>
                    <label for="descricao_olfativa_2" class="form-check-label"><b>2. Descrição olfativa:</b> documento que descreve aspectos sensoriais e com conceitos de marketing de uma fragrância considerando os ingredientes presentes na sua construção.</label>
                </div>            
            </div>
        </div>
        @if (!isset($projeto))
            <div class="offset-9 col-3">
                <button type="button" id="salvar-acao-marketing" style="float: right; padding: 5px; margin: 5px"
                    class="btn btn-success">Salvar</button>
            </div>
        @endif
    </div>
</form>