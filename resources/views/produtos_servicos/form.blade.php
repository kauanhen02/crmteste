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

        <h4>{{!empty($produto_servico) ? 'Editar' : 'Criar'}} ProdutoServico</h4>

        <form action="{{!empty($produto_servico) ? route('produtos_servicos.update', [$produto_servico]) : route('produtos_servicos.store')}}" enctype="multipart/form-data" method="POST" id="formProdutoServico">
            @csrf
            @if (!empty($produto_servico))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-6 form-group">
                    <label class="form-control-label">Descrição <span class="text-danger">*</span></label>
                    <input type="text" name="descricao" class="form-control" value="{{old('descricao', !empty($produto_servico) ? $produto_servico->descricao : '')}}">
                    @error('descricao')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 form-group">
                    <label class="form-control-label">Descrição popular</label>
                    <input type="text" name="descricao_popular" class="form-control" value="{{old('descricao_popular', !empty($produto_servico) ? $produto_servico->descricao_popular : '')}}">
                    @error('descricao_popular')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">COD</label>
                    <input type="text" name="cod" class="form-control" value="{{old('cod', !empty($produto_servico) ? $produto_servico->cod : '')}}">
                    @error('cod')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Grupo</label>
                    <select name="grupo_id" id="grupo_id" class="form-control select2">
                        @include('layout.option_basic', ['itens' => $grupos, 'texto' => 'Selecione um grupo', 'original' => $produto_servico ?? null, 'campo' => 'nome', 'select' => 'grupo_id'])
                    </select>
                    @error('grupo_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Sub grupo</label>
                    <select name="sub_grupo_id" id="sub_grupo_id" class="form-control select2">
                        @include('layout.option_basic', ['itens' => $sub_grupos, 'texto' => 'Selecione um sub grupo', 'original' => $produto_servico ?? null, 'campo' => 'nome', 'select' => 'sub_grupo_id'])
                    </select>
                    @error('sub_grupo_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3 form-group">
                    <label class="form-control-label">Custo médio ponderado</label>
                    <input type="text" name="custo_medio_ponderado" class="form-control" alt="signed-decimal" value="{{old('custo_medio_ponderado', !empty($produto_servico) ? $produto_servico->custo_medio_ponderado : '')}}">
                    @error('custo_medio_ponderado')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="offset-9 col-3">
                    <button type="submit" style="float: right; padding: 5px; margin: 5px" class="btn btn-success">Salvar</button>
                    <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a href="{{route('produtos_servicos.index')}}" style="color: inherit;">Voltar</a></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
