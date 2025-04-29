<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Descrição</th>
            <th>COD</th>
            <th>Grupo</th>
            <th>Sub grupo</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produtos_servicos as $produto)
            <tr class="tr-class">
                <td>{{ $produto->id }}</td>
                <td>{{ $produto->descricao }}</td>
                <td>{{ $produto->cod }}</td>
                <td>{{ $produto->grupoTrashed->nome ??'' }}</td>
                <td>{{ $produto->subGrupoTrashed->nome ??'' }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_produto_servico')
                        <a href="{{ route('produtos_servicos.edit', $produto->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_produto_servico')
                        <form action="{{ route('produtos_servicos.destroy', $produto->id) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Paginação -->
<div class="d-flex justify-content-end pagination-class">
    {{ $produtos_servicos->appends(['search' => $search])->links() }}
</div>