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

        <h4>{{!empty($usuario) ? 'Editar' : 'Criar'}} Usuario</h4>

        <form action="{{!empty($usuario) ? route('usuarios.update', [$usuario]) : route('usuarios.store')}}" enctype="multipart/form-data" method="POST" id="formUsuario">
            @csrf
            @if (!empty($usuario))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-6 form-group">
                    <label class="form-control-label">Nome <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{old('name', !empty($usuario) ? $usuario->name : '')}}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 form-group">
                    <label class="form-control-label">Email <span class="text-danger">*</span></label>
                    <input type="text" name="email" class="form-control" value="{{old('email', !empty($usuario) ? $usuario->email : '')}}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 form-group">
                    <label class="form-control-label">Senha <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" value="{{old('password')}}">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 form-group">
                    <label class="form-control-label">Perfil <span class="text-danger">*</span></label>
                    <select name="perfil_id" id="perfil_id" class="form-control">
                        @foreach ($perfis as $item)
                            <option value="{{$item->id}}" @if (old('perfil_id', !empty($usuario) ? $usuario->perfil_id : '') == $item->id) selected @endif>{{$item->descricao}}</option>
                        @endforeach
                    </select>
                    @error('perfil_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 form-group">
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" name="status" id="status" @if(old('status', !empty($usuario) ? $usuario->status : '')) checked @endif>
                        <label class="custom-control-label" for="status">Ativo</label>
                    </div>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="offset-9 col-3">
                    <button type="submit" style="float: right; padding: 5px; margin: 5px" class="btn btn-success">Salvar</button>
                    <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a href="{{route('usuarios.index')}}" style="color: inherit;">Voltar</a></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
