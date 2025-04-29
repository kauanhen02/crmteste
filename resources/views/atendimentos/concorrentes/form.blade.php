<form
    action="{{ route('atendimentos.concorrente', [$atendimento]) }}"
    enctype="multipart/form-data" method="POST" id="formConcorrente">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 form-group">
                    <label class="form-control-label">Nossos concorrentes</label>
                    <input type="text" class="form-control" id="nossos_concorrentes" name="nossos_concorrentes" value="{{old('nossos_concorrentes', isset($atendimento) ? $atendimento->nossos_concorrentes : '')}}">
                </div>
                <div class="col-12 form-group">
                    <label class="form-control-label">Concorrentes do cliente</label>
                    <input type="text" class="form-control" id="clientes_concorrentes" name="clientes_concorrentes" value="{{old('clientes_concorrentes', isset($atendimento) ? $atendimento->clientes_concorrentes : '')}}">
                </div>
            </div>
        </div>
        @if (!isset($projeto))
            <div class="offset-9 col-3">
                <button type="button" id="salvar-concorrente" style="float: right; padding: 5px; margin: 5px"
                    class="btn btn-success">Salvar</button>
            </div>
        @endif
    </div>
</form>