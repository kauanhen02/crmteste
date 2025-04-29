<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($status as $statu)
            <tr class="tr-class {{$statu->status ? "" : "item-desativado"}}">
                <td>{{ $statu->id }}</td>
                <td>{{ $statu->nome }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_status_lgpd')
                        <a href="{{ route('status.edit', $statu->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_status_lgpd')
                        <form action="{{ route('status.destroy', $statu->id) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_ativar_desativar_status_lgpd')
                        <a href="{{ route('status.ativar_desativar', $statu->id) }}" data-toggle="tooltip" class="ativar_desativar_class"
                            data-placement="top" @if ($statu->status) data-texto="Deseja desativar o status lgpd?" data-title="Desativar" title="Desativar" @else data-texto="Deseja ativar o status lgpd?" data-title="Ativar" title="Ativar" @endif style="padding: 5px">
                            @if ($statu->status)
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
    {{ $status->appends(['search' => $search])->links() }}
</div>