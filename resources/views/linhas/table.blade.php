<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($linhas as $linha)
            <tr class="tr-class {{$linha->status ? "" : "item-desativado"}}">
                <td>{{ $linha->id }}</td>
                <td>{{ $linha->nome }}</td>
                <td>{{ $linha->categoriaTrashed->nome }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_linha')
                        <a href="{{ route('linhas.edit', $linha->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_linha')
                        <form action="{{ route('linhas.destroy', $linha->id) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_ativar_desativar_linha')
                        <a href="{{ route('linhas.ativar_desativar', $linha->id) }}" data-toggle="tooltip" class="ativar_desativar_class"
                            data-placement="top" @if ($linha->status) data-texto="Deseja desativar a linha?" data-title="Desativar" title="Desativar" @else data-texto="Deseja ativar a linha?" data-title="Ativar" title="Ativar" @endif style="padding: 5px">
                            @if ($linha->status)
                                <i class="fa-regular fa-circle-xmark icon-class"></i>        
                            @else
                                <i class="fa-solid fa-check icon-class"></i>
                            @endif
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Paginação -->
<div class="d-flex justify-content-end pagination-class">
    {{ $linhas->appends(['search' => $search])->links() }}
</div>