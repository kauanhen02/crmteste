@extends('layout.layout')
@section('content')
<div class="container-fluid">
    <div style="background-color: #fff; border-radius:10px" class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible   show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row" style="padding-top: 20px;">
            <div class="col-6">
                <h3>Editar Habilidades Perfil {{$perfil->descricao}}</h3>
            </div>
            <div class="col-6 input-group">
                <input type="text" name="search" class="form-control" id="search" placeholder="Pesquise pelo modulo">
                <div class="input-group-append">
                    <button type="submit" class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <input type="checkbox" id="todas-habilidades" class="libera_todas">
                <label for="todas-habilidades" class="form-check-label"><h3>Liberar todas as habilidades</h3></label>
            </div>
        </div>

        <form action="{{route('perfis.habilidadesStore', [$perfil])}}" enctype="multipart/form-data" method="POST" id="formHabilidade">
            @csrf
            @method('POST')

            <div class="row">
                @foreach ($habilidades as $key => $item)
                    <div class="col-6 filtro" data-filtro="{{$item['grupo']}}">
                        <hr>
                        @php
                            $perfil = preg_replace('/[^A-Za-z0-9 ]/', '', $item['grupo']);
                            $perfil = str_replace(' ', '_', $perfil);
                        @endphp
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-12 form-group">
                                <input type="checkbox" id="{{$perfil}}" class="grupo_habilidades" data-grupo="{{$perfil}}">
                                <label for="{{$perfil}}" class="form-check-label"><h3>{{$item['grupo']}}</h3></label>
                            </div>
                            
                            @foreach ($item['habilidades'] as $item)   
                                <div class="col-12 form-group">
                                    <input type="checkbox" id="{{$item['id']}}" name="habilidades[][habilidade_id]" class="all-checks grupo-check-{{$perfil}}" value="{{$item['id']}}" @if ($item['ativo']) checked @endif>
                                    <label for="{{$item['id']}}" class="form-check-label">{{$item['nome']}}</label>
                                </div>
                            @endforeach
                        </div>
                        
                    </div>
                @endforeach
                <div class="col-12">
                    <button type="submit" style="float: right; padding: 5px; margin: 5px" class="btn btn-success">Salvar</button>
                    <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a href="{{route('perfis.index')}}" style="color: inherit;">Voltar</a></button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')

    <script>
        $(".grupo_habilidades").on('click', function(){
            let grupo = $(this).attr('data-grupo');
            if($(this).is(":checked")){
                $(".grupo-check-"+grupo).prop('checked', true);
            }else{
                $(".grupo-check-"+grupo).prop('checked', false);
            }
        });
       
        $(".libera_todas").on('click', function(){
            if($(this).is(":checked")){
                $(".all-checks").prop('checked', true);
            }else{
                $(".all-checks").prop('checked', false);
            }
        });

        $("#search").on('input', function(){
            var texto = $(this).val().toLowerCase(); // Texto digitado, convertido para minúsculas
            $('.filtro').each(function () {
                var filtro = $(this).attr('data-filtro').toLowerCase(); // Atributo data-filtro
                if (filtro.includes(texto)) {
                    $(this).show(); // Exibe se contém o texto
                } else {
                    $(this).hide(); // Oculta se não contém o texto
                }
            });
        })
    </script>
    
@endpush
