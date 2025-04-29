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

        <h4>{{!empty($perfil) ? 'Editar' : 'Criar'}} Perfil</h4>

        <form action="{{!empty($perfil) ? route('perfis.update', [$perfil]) : route('perfis.store')}}" enctype="multipart/form-data" method="POST" id="formPerfil">
            @csrf
            @if (!empty($perfil))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-12 form-group">
                    <label class="form-control-label">Descrição <span class="text-danger">*</span></label>
                    <input type="text" name="descricao" class="form-control" value="{{old('descricao', !empty($perfil) ? $perfil->descricao : '')}}">
                    @error('descricao')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="offset-9 col-3">
                    <button type="submit" style="float: right; padding: 5px; margin: 5px" class="btn btn-success">Salvar</button>
                    <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a href="{{route('perfis.index')}}" style="color: inherit;">Voltar</a></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
