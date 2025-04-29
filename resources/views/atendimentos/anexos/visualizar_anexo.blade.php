<div class="modal" id="modal-visualizar-anexo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{$anexo->descricao}} 
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark p-0">
                <object data="{{ Storage::disk('public')->url($anexo->diretorio) }}" 
                    width="100%" height="auto" class="m-0 p-0"></object>
            </div>
            <div class="modal-footer">
                <a href="{{route('atendimentoAnexos.baixarAnexo', [$atendimento, $anexo])}}" class="btn btn-success download-anexo" data-id="{{$anexo->id}}">
                    Baixar <i class="fa-solid fa-download"></i>
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>