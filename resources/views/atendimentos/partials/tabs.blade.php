@extends('layout.layout')
@section('content')
    <div class="container-fluid" style="padding: 15px!important; ">
        <div style="background-color: #fff; border-radius:10px; padding: 10px; max-width: 100%!important" class="container">
            <div class="card">
                <div class="card-header">
                    <div class="nav nav-pills mb-3">
                        <a href="#v-pills-dados" data-toggle="pill"
                            class="nav-link {{ !isset($create) ? 'active show' : '' }}">Dados</a>
                        @can('permissoes_tela', 'permissao_para_visualizar_linha_produto')
                            <a href="#v-pills-linha-produto" data-toggle="pill"
                                class="nav-link {{ isset($create) ? 'active show' : '' }} {{ !isset($create) && !isset($atendimento) ? 'disabled' : '' }}">Linha
                                de produto</a>
                        @endcan
                        <a href="#v-pills-acao-marketing" data-toggle="pill"
                            class="nav-link {{ !isset($create) && !isset($atendimento) ? 'disabled' : '' }}">Ações de
                            marketing</a>
                        @can('permissoes_tela', 'permissao_para_visualizar_atendimento_envio')
                        <a href="#v-pills-envios" data-toggle="pill"
                        class="nav-link {{ !isset($create) && !isset($atendimento) ? 'disabled' : '' }}">Envios</a>
                        @endcan
                        @can('permissoes_tela', 'permissao_para_editar_acao_marketing')
                            <a href="#v-pills-concorrentes" data-toggle="pill" class="nav-link {{ !isset($create) && !isset($atendimento) ? 'disabled' : '' }}">Concorrentes</a>
                        @endcan
                        @can('permissoes_tela', 'permissao_para_visualizar_atendimento_anexo')
                            <a href="#v-pills-anexos" data-toggle="pill" class="nav-link {{ !isset($create) && !isset($atendimento) ? 'disabled' : '' }}">Anexos</a>
                        @endcan
                        @if (isset($projeto))
                            @can('permissoes_tela', 'permissao_para_visualizar_markup')
                                <a href="#v-pills-markup" data-toggle="pill" class="nav-link">markup</a>
                            @endcan
                            @can('permissoes_tela', 'permissao_para_visualizar_laboratorio_desenvolvimento')
                                <a href="#v-pills-laboratorio-desenvolvimento" data-toggle="pill" class="nav-link">Lab. Desenvolvimento</a>
                            @endcan
                            @can('permissoes_tela', 'permissao_para_visualizar_laboratorio_aplicacao')
                                <a href="#v-pills-laboratorio-aplicacao" data-toggle="pill" class="nav-link">Lab. Aplicação</a>
                            @endcan
                            @can('permissoes_tela', 'permissao_para_visualizar_questionario_iso')
                                <a href="#v-pills-questionario-iso" data-toggle="pill" class="nav-link">Questionario ISO</a>
                            @endcan
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div id="v-pills-dados" class="tab-pane {{ !isset($create) ? 'active show' : '' }}">
                            @include('atendimentos.partials.form')
                        </div>
                        @if (isset($atendimento))
                            <div id="v-pills-linha-produto" class="tab-pane {{ isset($create) ? 'active show' : '' }}">
                                @include('atendimentos.linhas.lista')
                            </div>
                            <div id="v-pills-acao-marketing" class="tab-pane">
                                @include('atendimentos.acao_marketing.form')
                            </div>
                            <div id="v-pills-envios" class="tab-pane">
                                @include('atendimentos.envios.lista')
                            </div>
                            <div id="v-pills-concorrentes" class="tab-pane">
                                @include('atendimentos.concorrentes.form')
                            </div>
                            <div id="v-pills-anexos" class="tab-pane">
                                @include('atendimentos.anexos.lista')
                            </div>
                            @if (isset($projeto))
                                <div id="v-pills-markup" class="tab-pane">
                                    @include('atendimentos.partials.markup')
                                </div>
                                @can('permissoes_tela', 'permissao_para_visualizar_laboratorio_desenvolvimento')
                                    <div id="v-pills-laboratorio-desenvolvimento" class="tab-pane">
                                        @include('atendimentos.laboratorio.desenvolvimento.edit')
                                    </div>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_laboratorio_aplicacao')
                                    <div id="v-pills-laboratorio-aplicacao" class="tab-pane">
                                        @include('atendimentos.laboratorio.aplicacao.edit')
                                    </div>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_questionario_iso')
                                    <div id="v-pills-questionario-iso" class="tab-pane">
                                        @include('atendimentos.partials.questionario_iso')
                                    </div>
                                @endcan
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 status-tab">
                            @include('atendimentos.partials.status')
                        </div>
                        <div class="col-12">
                            <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a href="{{ isset($projeto) ? route('projetos.index') : route('atendimentos.index') }}" style="color: inherit;">Sair</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-tab"></div>
@endsection

@push('scripts')
    <script>
        $("#formAtendimentoEdit").on('submit', function(e) {
            e.preventDefault()
            e.stopPropagation();
            let url = $(this).attr('action');
            Olimpus.ajaxForm('formAtendimentoEdit', url, null, null);
        });

        $(".status-tab").on('click', '.change_status', function(){
            let status = $(this).attr("data-status");
            let status_el = $(this).parents('#url-status');
            let url = status_el.attr('data-url');
            let usuario_responsavel_id = $("#usuario_responsavel_id").val();
            if(status == "aprovado"){
                if(!$("#usuario_responsavel_id").val()){
                    $.toast({
                        heading: 'Error',
                        text: "Informe um usuario responsavel!",
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 10
                    });
                    return;
                }
            }
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    '_token': token,
                    'status': status,
                    'usuario_responsavel_id': usuario_responsavel_id,
                },
                beforeSend: () => {
                    Olimpus.preload();
                },
                success: function (data) {
                    status_el.html('')
                    status_el.html(data)
                    $.toast({
                        heading: 'Sucesso',
                        text: "Status alterado com sucesso!",
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 10
                    });
                },
                complete: () => {
                    Olimpus.preloadOff();
                },
                error: (response) => {
                    Olimpus.retornaError(response);
                    Olimpus.preloadOff();
                }
            }); 
        })

        $("#salvar-markup").on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $("#formMarkup").submit();
        });

        $("#formMarkup").on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('action');
            Olimpus.ajaxForm('formMarkup', url, null, null); 
        });
        
        $("#salvar-questionario-iso").on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $("#formQuestionarioIso").submit();
        });

        $("#formQuestionarioIso").on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('action');
            Olimpus.ajaxForm('formQuestionarioIso', url, null, null); 
        });
    </script>
    @include('atendimentos.linhas.script')
    @include('atendimentos.envios.script')
    @include('atendimentos.acao_marketing.script')
    @include('atendimentos.concorrentes.script')
    @include('atendimentos.anexos.script')
    @include('atendimentos.laboratorio.scripts')
@endpush
