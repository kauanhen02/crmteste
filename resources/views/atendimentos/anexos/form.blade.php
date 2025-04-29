<form
    action="{{ isset($anexo) ? route('atendimentoAnexos.update', [$atendimento, $anexo]) : route('atendimentoAnexos.store', [$atendimento]) }}"
    enctype="multipart/form-data" method="POST" id="formAnexo">
    @csrf
    @if (isset($anexo))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 form-group">
                    <label class="form-control-label">Descrição</label>
                    <input type="text" class="form-control" name="descricao" id="descricao" value="{{isset($anexo) ? $anexo->descricao : ''}}">
                </div>
                <div class="col-12">
                    <label for="arquivo" class="form-label">Arquivo</label>
                    <input class="form-control" type="file" id="arquivo" name="arquivo">
                </div>
            </div>
        </div>
        <div class="offset-9 col-3">
            <button type="button" id="salvar-anexos" style="float: right; padding: 5px; margin: 5px"
                class="btn btn-success">Salvar</button>
            <button type="button" id="btn-volta-anexos" style="float: right; padding: 5px; margin: 5px"
                class="btn btn-info" data-url="{{ route('atendimentoAnexos.index', $atendimento) }}"> Voltar</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        $(".select2").select2()
    });

    $("#salvar-anexos").on('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        $("#formAnexo").submit();
    });

    $("#formAnexo").on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        let url = $(this).attr('action');
        Olimpus.ajaxForm('formAnexo', url, routeToGo = null, () => {
            $("#btn-volta-anexos").click()
        }); 
    });
</script>