@if (session('success'))
    <div class="alert alert-success alert-dismissible   show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<h4>{{ !empty($atendimento) ? 'Editar' : 'Criar' }} Atendimento</h4>

<form action="{{ !empty($atendimento) ? route('atendimentos.update', [$atendimento]) : route('atendimentos.store') }}"
    enctype="multipart/form-data" method="POST" id="{{isset($atendimento) ? 'formAtendimentoEdit' : 'formAtendimento'}}">
    @csrf
    @if (!empty($atendimento))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-12 form-group">
            <label class="form-control-label">Cliente <span class="text-danger">*</span></label>
            <select name="cliente_id" id="cliente_id" class="select2">
                <option value="">Selecione um cliente</option>
                @foreach ($clientes as $item)
                    <option value="{{$item->id}}" @if (old('cliente_id', !empty($atendimento) ? $atendimento->cliente_id : '') == $item->id) selected @endif>{{$item->nome}}</option>
                @endforeach
            </select>
            @error('cliente_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6 form-group">
            <label class="form-control-label">Aberto por</label>
            <input type="hidden" class="form-control" readonly name="usuario_abriu_id" value="{{isset($atendimento) ? $atendimento->usuario_abriu_id : $usuario->id}}">
            <input type="text" class="form-control" readonly value="{{isset($atendimento) ? $atendimento->usuario->name : $usuario->name}}">
        </div>
        <div class="col-6 form-group">
            <label class="form-control-label">Tipo <span class="text-danger">*</span></label>
            <select name="tipo_atendimento_id" id="tipo_atendimento_id" class="select2">
                <option value="">Selecione um tipo</option>
                @foreach ($tipos_atendimentos as $item)
                    <option value="{{$item->id}}" @if (old('tipo_atendimento_id', !empty($atendimento) ? $atendimento->tipo_atendimento_id : '') == $item->id) selected @endif>{{$item->nome}}</option>
                @endforeach
            </select>
            @error('tipo_atendimento_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6 form-group">
            <label class="form-control-label">Assunto</label>
            <input type="text" class="form-control" id="assunto" name="assunto" value="{{old('assunto', isset($atendimento) ? $atendimento->assunto : '')}}">
        </div>
        <div class="col-6 form-group">
            <label class="form-control-label">Nome do projeto</label>
            <input type="text" class="form-control" id="nome_projeto" name="nome_projeto" value="{{old('nome_projeto', isset($atendimento) ? $atendimento->nome_projeto : '')}}">
        </div>
        <div class="col-6 form-group">
            <label class="form-control-label">Status <span class="text-danger">*</span></label>
            <select name="status_id" id="status_id" class="select2">
                <option value="">Selecione um status</option>
                @foreach ($status_lgpds as $item)
                    <option value="{{$item->id}}" @if (old('status_id', !empty($atendimento) ? $atendimento->status_id : '') == $item->id) selected @endif>{{$item->nome}}</option>
                @endforeach
            </select>
            @error('status_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6 form-group">
            <label for="" class="form-control-label">Nível de urgência</label>
            <div>
                <label class="radio-inline mr-3"><input type="radio" value="nenhuma" @if (old('nivel_urgencia', isset($atendimento) ? $atendimento->nivel_urgencia : '') == 'nenhuma') checked @endif name="nivel_urgencia"> Nenhuma</label>
                <label class="radio-inline mr-3"><input type="radio" value="baixa" @if (old('nivel_urgencia', isset($atendimento) ? $atendimento->nivel_urgencia : '') == 'baixa') checked @endif name="nivel_urgencia"> Baixa</label>
                <label class="radio-inline mr-3"><input type="radio" value="normal" @if (old('nivel_urgencia', isset($atendimento) ? $atendimento->nivel_urgencia : '') == 'normal') checked @endif name="nivel_urgencia"> Normal</label>
                <label class="radio-inline mr-3"><input type="radio" value="alta" @if (old('nivel_urgencia', isset($atendimento) ? $atendimento->nivel_urgencia : '') == 'alta') checked @endif name="nivel_urgencia"> Alta</label>
                <label class="radio-inline mr-3"><input type="radio" value="urgente" @if (old('nivel_urgencia', isset($atendimento) ? $atendimento->nivel_urgencia : '') == 'urgente') checked @endif name="nivel_urgencia"> Urgênte</label>
            </div>
        </div>
        <div class="col-6 form-group">
            <label class="form-control-label">Feito em</label>
            <input type="date" class="form-control" id="feito" name="feito" value="{{old('feito', isset($atendimento) ? $atendimento->feito->format('Y-m-d') : date('Y-m-d'))}}">
        </div>
        <div class="col-6 form-group">
            <label class="form-control-label">Prazo</label>
            <input type="date" class="form-control" id="prazo" name="prazo" value="{{old('prazo', isset($atendimento) ? $atendimento->prazo->format('Y-m-d') : date('Y-m-d', strtotime('+1 month')))}}">
        </div>
        <div class="col-9 form-group">
            <label for="" class="form-control-label">Meio de contato</label>
            <div>
                <label class="radio-inline mr-3"><input type="radio" value="nao_definido" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'nao_definido') checked @endif name="meio_contato"> Não definido</label>
                <label class="radio-inline mr-3"><input type="radio" value="visita" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'visita') checked @endif name="meio_contato"> Visita</label>
                <label class="radio-inline mr-3"><input type="radio" value="feira" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'feira') checked @endif name="meio_contato"> Feira</label>
                <label class="radio-inline mr-3"><input type="radio" value="telefone" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'telefone') checked @endif name="meio_contato"> Telefone</label>
                <label class="radio-inline mr-3"><input type="radio" value="email" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'email') checked @endif name="meio_contato"> Email</label>
                <label class="radio-inline mr-3"><input type="radio" value="skype" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'skype') checked @endif name="meio_contato"> Skype</label>
                <label class="radio-inline mr-3"><input type="radio" value="website" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'website') checked @endif name="meio_contato"> Website</label>
                <label class="radio-inline mr-3"><input type="radio" value="whatsapp" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'whatsapp') checked @endif name="meio_contato"> Whatsapp</label>
                <label class="radio-inline mr-3"><input type="radio" value="outro" @if (old('meio_contato', isset($atendimento) ? $atendimento->meio_contato : '') == 'outro') checked @endif name="meio_contato"> Outro</label>
            </div>
        </div>
        <div class="col-3 form-group">
            <label class="form-control-label">Contato</label>
            <input type="text" class="form-control" id="contato" name="contato" value="{{old('contato', isset($atendimento) ? $atendimento->contato : '')}}">
        </div>
        <div class="col-12 form-group">
            <label class="form-control-label">Observação</label>
            <textarea class="form-control" name="obs" id="obs" cols="30" rows="10">{{old('obs', isset($atendimento) ? $atendimento->obs : '')}}</textarea>
        </div>
        @if (!isset($projeto))
            <div class="offset-9 col-3">
                <button type="submit" style="float: right; padding: 5px; margin: 5px"
                    class="btn btn-success">@if (isset($atendimento)) Editar @else <i class="fa-solid fa-plus"></i> Adicionar linha produto @endif</button>
            </div>
        @endif
    </div>
</form>
