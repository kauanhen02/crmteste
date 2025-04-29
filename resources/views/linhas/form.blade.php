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

        <h4>{{!empty($linha) ? 'Editar' : 'Criar'}} Linha</h4>

        <form action="{{!empty($linha) ? route('linhas.update', [$linha]) : route('linhas.store')}}" enctype="multipart/form-data" method="POST" id="formLinha">
            @csrf
            @if (!empty($linha))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-12 form-group">
                    <label class="form-control-label">Nome <span class="text-danger">*</span></label>
                    <input type="text" name="nome" class="form-control" value="{{old('nome', !empty($linha) ? $linha->nome : '')}}">
                    @error('nome')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 form-group">
                    <label class="form-control-label">Categoria <span class="text-danger">*</span></label>
                    <select name="categoria_id" id="categoria_id" class="form-control select2">
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categorias as $item)
                            <option value="{{$item->id}}" @if ($item->id === old('categoria_id', $linha->categoria_id ?? '')) selected @endif>{{$item->nome}}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="offset-9 col-3">
                    <button type="submit" style="float: right; padding: 5px; margin: 5px" class="btn btn-success">Salvar</button>
                    <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a href="{{route('linhas.index')}}" style="color: inherit;">Voltar</a></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
