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

        <h4>{{!empty($segmento) ? 'Editar' : 'Criar'}} Segmento</h4>

        <form action="{{!empty($segmento) ? route('segmentos.update', [$segmento]) : route('segmentos.store')}}" enctype="multipart/form-data" method="POST" id="fomrSegmento">
            @csrf
            @if (!empty($segmento))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-12 form-group">
                    <label class="form-control-label">Nome <span class="text-danger">*</span></label>
                    <input type="text" name="nome" class="form-control" value="{{old('nome', !empty($segmento) ? $segmento->nome : '')}}">
                    @error('nome')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="offset-9 col-3">
                    <button type="submit" style="float: right; padding: 5px; margin: 5px" class="btn btn-success">Salvar</button>
                    <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a href="{{route('segmentos.index')}}" style="color: inherit;">Voltar</a></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
