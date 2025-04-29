<form
    action="{{ route('projetos.editProjeto', [$atendimento]) }}"
    enctype="multipart/form-data" method="POST" id="formLabAplicacao">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-3 form-group">
                    <label for="" class="form-control-label">Data Estimada</label>
                    <input type="date" name="data_estimada_ap" id="data_estimada_ap" value="{{ $atendimento->data_estimada_ap ?? '' }}" class="form-control">
                </div>
                <div class="col-3 form-group">
                    <label for="" class="form-control-label">Data Retorno</label>
                    <input type="date" name="data_retorno_ap" id="data_retorno_ap" value="{{ $atendimento->data_retorno_ap ?? '' }}" class="form-control">
                </div>
                <div class="col-3 form-group">
                    <label for="" class="form-control-label">Elaborador</label>
                    <select name="elaborador_ap" id="elaborador_ap" class="form-control select2">
                        <option value="">Seleciona um eleborador</option>
                        @foreach ($usuarios as $item)
                            <option value="{{ $item->id }}" @if($atendimento->elaborador_ap == $item->id) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 form-group">
                    <input type="checkbox" name="concluido_ap" id="concluido_ap" value="1" data-grupo="concluido_ap"
                        @if (isset($atendimento) && $atendimento->concluido_ap) checked @endif>
                    <label for="concluido_ap" class="form-check-label">Concluido</label>
                </div>  
                
                <div class="col-12 form-group">
                    <label for="" class="form-control-label">Observação</label>
                    <input type="text" name="obs_ap" id="obs_ap" value="{{ $atendimento->obs_ap ?? '' }}" class="form-control">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="turbidez_check_ap" id="turbidez_check_ap" value="1" data-grupo="turbidez_check_ap"
                        @if (isset($atendimento) && $atendimento->turbidez_check_ap) checked @endif>
                    <label for="turbidez_check_ap" class="form-check-label">Turbidez</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="turbidez_desc_ap" name="turbidez_desc_ap" value="{{old('turbidez_desc_ap', isset($atendimento) ? $atendimento->turbidez_desc_ap : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="coloracao_check_ap" id="coloracao_check_ap" value="1" data-grupo="coloracao_check_ap"
                        @if (isset($atendimento) && $atendimento->coloracao_check_ap) checked @endif>
                    <label for="coloracao_check_ap" class="form-check-label">Coloração</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="coloracao_desc_ap" name="coloracao_desc_ap" value="{{old('coloracao_desc_ap', isset($atendimento) ? $atendimento->coloracao_desc_ap : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="nota_fragancia_check_ap" id="nota_fragancia_check_ap" value="1" data-grupo="nota_fragancia_check_ap"
                        @if (isset($atendimento) && $atendimento->nota_fragancia_check_ap) checked @endif>
                    <label for="nota_fragancia_check_ap" class="form-check-label">Nota de fragrância</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="nota_fragancia_desc_ap" name="nota_fragancia_desc_ap" value="{{old('nota_fragancia_desc_ap', isset($atendimento) ? $atendimento->nota_fragancia_desc_ap : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="precipitacao_check_ap" id="precipitacao_check_ap" value="1" data-grupo="precipitacao_check_ap"
                        @if (isset($atendimento) && $atendimento->precipitacao_check_ap) checked @endif>
                    <label for="precipitacao_check_ap" class="form-check-label">Precipitação</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="precipitacao_desc_ap" name="precipitacao_desc_ap" value="{{old('precipitacao_desc_ap', isset($atendimento) ? $atendimento->precipitacao_desc_ap : '')}}">
                </div>

                <div class="col-2 form-group">
                    <input type="checkbox" name="validacao_check_ap" id="validacao_check_ap" value="1" data-grupo="validacao_check_ap"
                        @if (isset($atendimento) && $atendimento->validacao_check_ap) checked @endif>
                    <label for="validacao_check_ap" class="form-check-label">Validação</label>
                </div>            
                <div class="col-10 form-group">
                    <label class="form-control-label"></label>
                    <input type="text" class="form-control" id="validacao_desc_ap" name="validacao_desc_ap" value="{{old('validacao_desc_ap', isset($atendimento) ? $atendimento->validacao_desc_ap : '')}}">
                </div>
            </div>
        </div>
        @can('permissoes_tela', 'permissao_para_editar_laboratorio_aplicacao')
            <div class="offset-9 col-3">
                <button type="button" id="salvar-lab-aplicacao" style="float: right; padding: 5px; margin: 5px"
                    class="btn btn-success">Salvar</button>
            </div>
        @endcan
    </div>
</form>