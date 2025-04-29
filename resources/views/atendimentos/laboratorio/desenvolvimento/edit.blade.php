<form
    action="{{ route('projetos.editProjeto', [$atendimento]) }}"
    enctype="multipart/form-data" method="POST" id="formLabDesenvolvimento">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 form-group">
                    <input type="checkbox" name="desenvolvimento_dev" id="desenvolvimento_dev" value="1" data-grupo="desenvolvimento_dev"
                        @if (isset($atendimento) && $atendimento->desenvolvimento_dev) checked @endif>
                    <label for="desenvolvimento_dev" class="form-check-label">Desenvolvimento</label>
                </div>  
                <div class="col-3 form-group">
                    <label for="" class="form-control-label">Data Estimada</label>
                    <input type="date" name="data_estimada_dev" id="data_estimada_dev" value="{{ $atendimento->data_estimada_dev ?? '' }}" class="form-control">
                </div>
                <div class="col-3 form-group">
                    <label for="" class="form-control-label">Data Retorno</label>
                    <input type="date" name="data_retorno_dev" id="data_retorno_dev" value="{{ $atendimento->data_retorno_dev ?? '' }}" class="form-control">
                </div>
                <div class="col-3 form-group">
                    <label for="" class="form-control-label">Elaborador</label>
                    <select name="elaborador_dev" id="elaborador_dev" class="form-control select2">
                        <option value="">Seleciona um eleborador</option>
                        @foreach ($usuarios as $item)
                            <option value="{{ $item->id }}" @if($atendimento->elaborador_dev == $item->id) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 form-group">
                    <input type="checkbox" name="concluido_dev" id="concluido_dev" value="1" data-grupo="concluido_dev"
                        @if (isset($atendimento) && $atendimento->concluido_dev) checked @endif>
                    <label for="concluido_dev" class="form-check-label">Concluido</label>
                </div>  
                
                <div class="col-12 form-group">
                    <label for="" class="form-control-label">Observação</label>
                    <input type="text" name="obs_dev" id="obs_dev" value="{{ $atendimento->obs_dev ?? '' }}" class="form-control">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="viscosidade_check_dev" id="viscosidade_check_dev" value="1" data-grupo="viscosidade_check_dev"
                        @if (isset($atendimento) && $atendimento->viscosidade_check_dev) checked @endif>
                    <label for="viscosidade_check_dev" class="form-check-label">Viscosidade</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="viscosidade_desc_dev" name="viscosidade_desc_dev" value="{{old('viscosidade_desc_dev', isset($atendimento) ? $atendimento->viscosidade_desc_dev : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="turbidez_check_dev" id="turbidez_check_dev" value="1" data-grupo="turbidez_check_dev"
                        @if (isset($atendimento) && $atendimento->turbidez_check_dev) checked @endif>
                    <label for="turbidez_check_dev" class="form-check-label">Turbidez</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="turbidez_desc_dev" name="turbidez_desc_dev" value="{{old('turbidez_desc_dev', isset($atendimento) ? $atendimento->turbidez_desc_dev : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="coloracao_check_dev" id="coloracao_check_dev" value="1" data-grupo="coloracao_check_dev"
                        @if (isset($atendimento) && $atendimento->coloracao_check_dev) checked @endif>
                    <label for="coloracao_check_dev" class="form-check-label">Coloração</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="coloracao_desc_dev" name="coloracao_desc_dev" value="{{old('coloracao_desc_dev', isset($atendimento) ? $atendimento->coloracao_desc_dev : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="nota_fragancia_check_dev" id="nota_fragancia_check_dev" value="1" data-grupo="nota_fragancia_check_dev"
                        @if (isset($atendimento) && $atendimento->nota_fragancia_check_dev) checked @endif>
                    <label for="nota_fragancia_check_dev" class="form-check-label">Nota de fragrância</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="nota_fragancia_desc_dev" name="nota_fragancia_desc_dev" value="{{old('nota_fragancia_desc_dev', isset($atendimento) ? $atendimento->nota_fragancia_desc_dev : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="precipitacao_check_dev" id="precipitacao_check_dev" value="1" data-grupo="precipitacao_check_dev"
                        @if (isset($atendimento) && $atendimento->precipitacao_check_dev) checked @endif>
                    <label for="precipitacao_check_dev" class="form-check-label">Precipitação</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="precipitacao_desc_dev" name="precipitacao_desc_dev" value="{{old('precipitacao_desc_dev', isset($atendimento) ? $atendimento->precipitacao_desc_dev : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="validacao_check_dev" id="validacao_check_dev" value="1" data-grupo="validacao_check_dev"
                        @if (isset($atendimento) && $atendimento->validacao_check_dev) checked @endif>
                    <label for="validacao_check_dev" class="form-check-label">Validação</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="validacao_desc_dev" name="validacao_desc_dev" value="{{old('validacao_desc_dev', isset($atendimento) ? $atendimento->validacao_desc_dev : '')}}">
                </div>
            </div>
        </div>
        @can('permissoes_tela', 'permissao_para_editar_laboratorio_desenvolvimento')
            <div class="offset-9 col-3">
                <button type="button" id="salvar-lab-desenvolvimento" style="float: right; padding: 5px; margin: 5px"
                    class="btn btn-success">Salvar</button>
            </div>
        @endcan
    </div>
</form>