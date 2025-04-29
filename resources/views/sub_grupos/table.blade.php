<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Sigla</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subs as $sub)
            <tr class="tr-class {{$sub->status ? "" : "item-desativado"}}">
                <td>{{ $sub->id }}</td>
                <td>{{ $sub->nome }}</td>
                <td>{{ $sub->sigla }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_sub_grupo')
                        <a href="{{ route('sub_grupos.edit', $sub->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_sub_grupo')
                        <form action="{{ route('sub_grupos.destroy', $sub->id) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_ativar_desativar_sub_grupo')
                        <a href="{{ route('sub_grupos.ativar_desativar', $sub->id) }}" data-toggle="tooltip" class="ativar_desativar_class"
                            data-placement="top" @if ($sub->status) data-texto="Deseja desativar o sub grupo?" data-title="Desativar" title="Desativar" @else data-texto="Deseja ativar o sub grupo?" data-title="Ativar" title="Ativar" @endif style="padding: 5px">
                            @if ($sub->status)
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
    {{ $subs->appends(['search' => $search])->links() }}
</div>