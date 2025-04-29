<form
    action="{{ route('projetos.editProjeto', [$atendimento]) }}"
    enctype="multipart/form-data" method="POST" id="formQuestionarioIso">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-4 form-group">
                    <input type="checkbox" name="recurso_desenvolvimento" id="recurso_desenvolvimento" value="1" data-grupo="recurso_desenvolvimento"
                        @if (isset($atendimento) && $atendimento->recurso_desenvolvimento) checked @endif>
                    <label for="recurso_desenvolvimento" class="form-check-label">Recursos internos e externos para desenvolvimento</label>
                </div>            
                <div class="col-6 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="recurso_desenvolvimento_desc" name="recurso_desenvolvimento_desc" value="{{old('recurso_desenvolvimento_desc', isset($atendimento) ? $atendimento->recurso_desenvolvimento_desc : '')}}">
                </div>

                <div class="col-4 form-group">
                    <input type="checkbox" name="amostra_anexo" id="amostra_anexo" value="1" data-grupo="amostra_anexo"
                        @if (isset($atendimento) && $atendimento->amostra_anexo) checked @endif>
                    <label for="amostra_anexo" class="form-check-label">Amostra em anexo</label>
                </div>            
                <div class="col-6 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="amostra_anexo_desc" name="amostra_anexo_desc" value="{{old('amostra_anexo_desc', isset($atendimento) ? $atendimento->amostra_anexo_desc : '')}}">
                </div>

                <div class="col-4 form-group">
                    <input type="checkbox" name="boletim_tecnico" id="boletim_tecnico" value="1" data-grupo="boletim_tecnico"
                        @if (isset($atendimento) && $atendimento->boletim_tecnico) checked @endif>
                    <label for="boletim_tecnico" class="form-check-label">Boletim técnico</label>
                </div>            
                <div class="col-6 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="boletim_tecnico_desc" name="boletim_tecnico_desc" value="{{old('boletim_tecnico_desc', isset($atendimento) ? $atendimento->boletim_tecnico_desc : '')}}">
                </div>

                <div class="col-4 form-group">
                    <input type="checkbox" name="dados_materia_prima" id="dados_materia_prima" value="1" data-grupo="dados_materia_prima"
                        @if (isset($atendimento) && $atendimento->dados_materia_prima) checked @endif>
                    <label for="dados_materia_prima" class="form-check-label">Dados de entrada de matéria prima</label>
                </div>            
                <div class="col-6 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="dados_materia_prima_desc" name="dados_materia_prima_desc" value="{{old('dados_materia_prima_desc', isset($atendimento) ? $atendimento->dados_materia_prima_desc : '')}}">
                </div>

                <div class="col-4 form-group">
                    <input type="checkbox" name="normas_especificacoes" id="normas_especificacoes" value="1" data-grupo="normas_especificacoes"
                        @if (isset($atendimento) && $atendimento->normas_especificacoes) checked @endif>
                    <label for="normas_especificacoes" class="form-check-label">Normas e especificações foram fornecidas</label>
                </div>            
                <div class="col-6 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="normas_especificacoes_desc" name="normas_especificacoes_desc" value="{{old('normas_especificacoes_desc', isset($atendimento) ? $atendimento->normas_especificacoes_desc : '')}}">
                </div>

                <div class="col-4 form-group">
                    <input type="checkbox" name="amostras_item" id="amostras_item" value="1" data-grupo="amostras_item"
                        @if (isset($atendimento) && $atendimento->amostras_item) checked @endif>
                    <label for="amostras_item" class="form-check-label">Foram fornecidas amostras do item a ser produzido</label>
                </div>            
                <div class="col-6 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="amostras_item_desc" name="amostras_item_desc" value="{{old('amostras_item_desc', isset($atendimento) ? $atendimento->amostras_item_desc : '')}}">
                </div>

                <div class="col-4 form-group">
                    <input type="checkbox" name="materias_almoxarifado" id="materias_almoxarifado" value="1" data-grupo="materias_almoxarifado"
                        @if (isset($atendimento) && $atendimento->materias_almoxarifado) checked @endif>
                    <label for="materias_almoxarifado" class="form-check-label">Materias estão disponiveis no almoxarifado</label>
                </div>            
                <div class="col-6 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="materias_almoxarifado_desc" name="materias_almoxarifado_desc" value="{{old('materias_almoxarifado_desc', isset($atendimento) ? $atendimento->materias_almoxarifado_desc : '')}}">
                </div>

                <div class="col-4 form-group">
                    <input type="checkbox" name="reducao_custo" id="reducao_custo" value="1" data-grupo="reducao_custo"
                        @if (isset($atendimento) && $atendimento->reducao_custo) checked @endif>
                    <label for="reducao_custo" class="form-check-label">O cliente sugeriu uso de alternativas para redução de custo</label>
                </div>            
                <div class="col-6 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="reducao_custo_desc" name="reducao_custo_desc" value="{{old('reducao_custo_desc', isset($atendimento) ? $atendimento->reducao_custo_desc : '')}}">
                </div>
            </div>
        </div>
        @can('permissoes_tela', 'permissao_para_editar_questionario_iso')
            <div class="offset-9 col-3">
                <button type="button" id="salvar-questionario-iso" style="float: right; padding: 5px; margin: 5px"
                    class="btn btn-success">Salvar</button>
            </div>
        @endcan
    </div>
</form>