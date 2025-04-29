<form action="{{ route('projetos.editProjeto', [$atendimento]) }}" enctype="multipart/form-data" method="POST" id="formMarkup">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 form-group">
                    <textarea name="markup" id="markup" cols="10" rows="5" class="form-control">{{$atendimento->markup ?? ''}}</textarea>
                </div>
            </div>
        </div>
        @can('permissoes_tela', 'permissao_para_editar_markup')
            <div class="offset-9 col-3">
                <button type="button" id="salvar-markup" style="float: right; padding: 5px; margin: 5px"
                    class="btn btn-success">Salvar</button>
            </div>
        @endcan
    </div>
</form>