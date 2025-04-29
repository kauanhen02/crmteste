<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Linha</th>
            <th>Volume</th>
            <th>Quantidade</th>
            <th>Custo de venda minimo</th>
            <th>Custo de venda maximo</th>
            <th>Aplicação mínima</th>
            <th>Aplicação máxima</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($linhas as $linha)
            <tr class="tr-class">
                <td>{{ $linha->id }}</td>
                <td>{{ $linha->linhaTrashed->nome }}</td>
                <td>{{ $linha->volumeTrashed->nome }}</td>
                <td>{{ $linha->quantidade }}</td>
                <td>{{ $linha->custo_venda_minimo }}</td>
                <td>{{ $linha->custo_venda_maximo }}</td>
                <td>{{ $linha->aplicacao_minimo }}</td>
                <td>{{ $linha->aplicacao_maximo }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_linha_produto')
                        @if (!isset($projeto))
                            <a href="{{ route('linhasProdutos.edit', [$atendimento->id, $linha->id]) }}" data-toggle="tooltip" data-placement="top" title="Editar" style="padding: 5px" class="edit-linha-produto"><i class="fa-solid fa-pencil"></i></a>
                        @endif
                        
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_linha_produto')
                        <form action="{{ route('linhasProdutos.destroy', [$atendimento->id, $linha->id]) }}" method="POST"
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
    {{ $linhas->appends(['search_linha' => $search_linha])->links() }}
</div>