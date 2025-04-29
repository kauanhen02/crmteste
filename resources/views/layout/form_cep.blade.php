<div class="col-3 form-group">
    <label class="form-control-label">CEP </label>
    <input type="text" name="cep" id="cep" class="form-control" placeholder="Ex: 01001-000" alt="cep"
        value="{{ old('cep', !empty($item) ? $item->cep : '') }}">
    @error('cep')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="col-3 form-group">
    <label class="form-control-label">Rua </label>
    <input type="text" name="rua" id="rua" class="form-control"
        value="{{ old('rua', !empty($item) ? $item->rua : '') }}">
    @error('rua')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="col-3 form-group">
    <label class="form-control-label">Numero </label>
    <input type="text" name="numero" id="numero" class="form-control"
        value="{{ old('numero', !empty($item) ? $item->numero : '') }}">
    @error('numero')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="col-3 form-group">
    <label class="form-control-label">Bairro </label>
    <input type="text" name="bairro" id="bairro" class="form-control"
        value="{{ old('bairro', !empty($item) ? $item->bairro : '') }}">
    @error('bairro')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="col-4 form-group">
    <label class="form-control-label">Cidade </label>
    <input type="text" name="cidade" id="cidade" class="form-control"
        value="{{ old('cidade', !empty($item) ? $item->cidade : '') }}">
    @error('cidade')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="col-4 form-group">
    <label class="form-control-label">Estado </label>
    <select name="estado" id="estado" class="form-control select2">
        @include('clientes.estados')
    </select>
    @error('estado')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="col-4 form-group">
    <label class="form-control-label">Complemento </label>
    <input type="text" name="complemento" id="complemento" class="form-control"
        value="{{ old('complemento', !empty($item) ? $item->complemento : '') }}">
    @error('estado')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>