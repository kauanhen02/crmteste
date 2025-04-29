@if(isset($atendimento) && (isset($projeto) || $atendimento->status == "reprovado"))
    <div class="col-12" id="url-status" data-url="{{ route('atendimentos.changeStatus', $atendimento) }}">
        <div class="status" style="padding: 5px;">
            <div class="row">
                @if (isset($projeto))
                    <div class="col-12 form-group">
                        <label class="form-control-label">Usuario responsável</label>
                        <select class="form-control select2" name="usuario_responsavel_id" id="usuario_responsavel_id" @cannot('permissoes_tela', 'permissao_para_alterar_usuario_responsavel') disabled @endcannot>
                            <option value="">Selecione um usuario</option>
                            @foreach ($usuarios as $key => $usuario)
                                <option value="{{ $usuario->id }}" {{ $atendimento->usuario_responsavel_id == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-12">
                    <h5>Mudar status</h5>
                </div>
                @if ($atendimento->status == "concluido")
                    <div class="col-12">
                        <h5 style="color: #A336C9"><b>PROJETO CONCLUÍDO</b></h5>
                    </div>
                @else
                    <div class="col-12">
                        @if (isset($projeto))
                            @can('permissoes_tela', 'permissao_para_visualizar_status_reprovado')
                                @if ($atendimento->status == "pendente")
                                    <button class="btn btn-sm {{ ($atendimento->status == 'reprovado') ? 'btn-outline-danger' :  'btn-danger change_status' }}"     data-status='reprovado'>Reprovar</button>
                                @endif
                            @endcan
                        @endif
                        @if($atendimento->status == 'reprovado')
                            <button class="btn btn-sm {{ ($atendimento->status == 'pendente') ? 'btn-outline-primary' :  'btn-primary change_status' }}"    data-status='pendente'>Pendente</button>
                        @endif
                        @if (isset($projeto))
                            @can('permissoes_tela', 'permissao_para_alterar_status_aprovar')
                                <button class="btn btn-sm {{ ($atendimento->status == 'aprovado') ? 'btn-outline-success' :  'btn-success change_status' }}"    data-status='aprovado'>Aprovado</button>
                            @endcan
                            
                            @if ($atendimento->status == "aprovado")
                                @can('permissoes_tela', 'permissao_para_alterar_status_enviar_laboratorio')
                                    <button class="btn btn-sm {{ ($atendimento->status == 'enviar_laboratorio') ? 'btn-outline-info' :  'btn-info change_status' }}"    data-status='enviar_laboratorio' style="background-color: #e9dd3f; border-color: #e9dd3f; color: black;">Enviar Laboratorio</button>
                                @endcan
                            @endif
                            @can('permissoes_tela', 'permissao_para_alterar_status_avaliacao_final')
                                <button class="btn btn-sm {{ ($atendimento->status == 'avaliacao_final') ? 'btn-outline-info' :  'btn-info change_status' }}"    data-status='avaliacao_final' style="background-color: #ff8a00; border-color: #ff8a00; color: white;">Avaliação final</button>
                            @endcan
                            @if ($atendimento->status == "aprovado" || $atendimento->status == "avaliacao_final")
                                @can('permissoes_tela', 'permissao_para_alterar_status_concluir')
                                    <button class="btn btn-sm {{ ($atendimento->status == 'concluido') ? 'btn-outline-secondary' :  'btn-secondary change_status' }}"  data-status='concluido'>Concluído</button>
                                @endcan
                            @endif
                            
                        @endif
                    </div>
                @endif
                
            </div>
        </div>
    </div>
@endif