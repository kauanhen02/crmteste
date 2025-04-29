@extends('layout.layout')
@section('content')
    <div class="container-fluid">
        <div style="background-color: #fff; border-radius:10px; padding: 10px" class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible   show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <h4>{{ !empty($cliente) ? 'Editar' : 'Criar' }} Clientes</h4>

            <form action="{{ !empty($cliente) ? route('clientes.update', [$cliente]) : route('clientes.store') }}"
                enctype="multipart/form-data" method="POST" id="formClientes">
                @csrf
                @if (!empty($cliente))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-6 form-group">
                        <label class="form-control-label">Nome <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control" required
                            value="{{ old('nome', !empty($cliente) ? $cliente->nome : '') }}">
                        @error('nome')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label class="form-control-label">Razão social </label>
                        <input type="text" name="razao_social" class="form-control"
                            value="{{ old('razao_social', !empty($cliente) ? $cliente->razao_social : '') }}">
                        @error('razao_social')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4 form-group">
                        <label class="form-control-label">CNPJ <span class="text-danger">*</span></label>
                        <input type="text" name="cnpj" class="form-control" alt="cnpj" required
                            value="{{ old('cnpj', !empty($cliente) ? $cliente->cnpj : '') }}">
                        @error('cnpj')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4 form-group">
                        <label class="form-control-label">Telefone <span class="text-danger">*</span></label>
                        <input type="text" name="telefone" id="telefone" class="form-control" required
                            value="{{ old('telefone', !empty($cliente) ? $cliente->telefone : '') }}">
                        @error('telefone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4 form-group">
                        <label class="form-control-label">Email </label>
                        <input type="text" name="email" class="form-control"
                            value="{{ old('email', !empty($cliente) ? $cliente->email : '') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @include('layout.form_cep', ['item' => isset($cliente) ? $cliente : null])
                    <div class="col-6 form-group">
                        <label class="form-control-label">Carteira </label>
                        <select name="carteira_id" id="carteira_id" class="form-control select2">
                            @include('layout.option_basic', ['itens' => $carteiras, 'texto' => 'Selecione uma carteira', 'original' => $cliente ?? null, 'campo' => 'nome', 'select' => 'carteira_id'])
                        </select>
                        @error('carteira_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label class="form-control-label">Segmento </label>
                        <select name="segmento_id" id="segmento_id" class="form-control select2">
                            @include('layout.option_basic', ['itens' => $segmentos, 'texto' => 'Selecione um segmento', 'original' => $cliente ?? null, 'campo' => 'nome', 'select' => 'segmento_id'])
                        </select>
                        @error('segmento_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label class="form-control-label">Forma de atuação </label>
                        <select name="forma_atuacao_id" id="forma_atuacao_id" class="form-control select2">
                            @include('layout.option_basic', ['itens' => $formas, 'texto' => 'Selecione uma forma de atuação', 'original' => $cliente ?? null, 'campo' => 'nome', 'select' => 'forma_atuacao_id'])
                        </select>
                        @error('forma_atuacao_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label class="form-control-label">Status LGPD </label>
                        <select name="status_lgpd_id" id="status_lgpd_id" class="form-control select2">
                            @include('layout.option_basic', ['itens' => $status, 'texto' => 'Selecione um status lgpd', 'original' => $cliente ?? null, 'campo' => 'nome', 'select' => 'status_lgpd_id'])
                        </select>
                        @error('status_lgpd_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="offset-9 col-3">
                        <button type="submit" style="float: right; padding: 5px; margin: 5px"
                            class="btn btn-success">Salvar</button>
                        <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a
                                href="{{ route('clientes.index') }}" style="color: inherit;">Voltar</a></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#telefone').each(function(){
            $(this).setMask('(99) 99999-9999', {
                translation: { '9': { pattern: /[0-9]/, optional: false} }
            })
        });
    </script>
@endpush
