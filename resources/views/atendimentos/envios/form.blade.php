<form
    action="{{ isset($envio) ? route('atendimentoEnvios.update', [$atendimento, $envio]) : route('atendimentoEnvios.store', [$atendimento]) }}"
    enctype="multipart/form-data" method="POST" id="formEnvio">
    @csrf
    @if (isset($envio))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-3 form-group">
                    <label class="form-control-label">Data envio</label>
                    <input type="date" class="form-control" value="{{date('Y-m-d')}}" disabled>
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Destino</label>
                    <select name="destino_id" id="destino_id" class="select2 form-control" required>
                        <option value="">Selecione um destino</option>
                        @foreach ($destinos as $item)
                            <option value="{{ $item->id }}" @if (old('destino_id', isset($envio) ? $envio->destino_id : '') == $item->id) selected @endif>
                                {{ $item->nome }}</option>
                        @endforeach
                    </select>
                    @error('destino_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Forma de envio</label>
                    <select name="envio_id" id="envio_id" class="select2 form-control" required>
                        <option value="">Selecione um envio</option>
                        @foreach ($envios as $item)
                            <option value="{{ $item->id }}" @if (old('envio_id', isset($envio) ? $envio->envio_id : '') == $item->id) selected @endif>
                                {{ $item->nome }}</option>
                        @endforeach
                    </select>
                    @error('envio_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Contato</label>
                    <input type="text" class="form-control" name="contato" id="contato" value="{{isset($envio) ? $envio->contato : ''}}">
                    @error('contato')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @include('layout.form_cep', ['item' => isset($envio) ? $envio : null])
                <div class="col-12 form-group">
                    <label class="form-control-label">Observação</label>
                    <textarea class="form-control" name="obs" id="obs" cols="10" rows="5">{{isset($envio) ? $envio->obs : ''}}</textarea>
                </div>
            </div>
        </div>
        <div class="offset-9 col-3">
            <button type="button" id="salvar-envios" style="float: right; padding: 5px; margin: 5px"
                class="btn btn-success">Salvar</button>
            <button type="button" id="btn-volta-envios" style="float: right; padding: 5px; margin: 5px"
                class="btn btn-info" data-url="{{ route('atendimentoEnvios.index', $atendimento) }}"> Voltar</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        $(".select2").select2()
    });

    $("#salvar-envios").on('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        $("#formEnvio").submit();
    });

    $("#formEnvio").on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        let url = $(this).attr('action');
        Olimpus.ajaxForm('formEnvio', url, routeToGo = null, () => {
            $("#btn-volta-envios").click()
        }); 
    });
</script>