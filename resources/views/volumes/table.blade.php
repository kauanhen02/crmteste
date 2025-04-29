<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($volumes as $volume)
            <tr class="tr-class {{$volume->status ? "" : "item-desativado"}}">
                <td>{{ $volume->id }}</td>
                <td>{{ $volume->nome }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_volume')
                        <a href="{{ route('volumes.edit', $volume->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_volume')
                        <form action="{{ route('volumes.destroy', $volume->id) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_ativar_desativar_volume')
                        <a href="{{ route('volumes.ativar_desativar', $volume->id) }}" data-toggle="tooltip" class="ativar_desativar_class"
                            data-placement="top" @if ($volume->status) data-texto="Deseja desativar a volume?" data-title="Desativar" title="Desativar" @else data-texto="Deseja ativar a volume?" data-title="Ativar" title="Ativar" @endif style="padding: 5px">
                            @if ($volume->status)
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
    {{ $volumes->appends(['search' => $search])->links() }}
</div>