<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($segmentos as $segmento)
            <tr class="tr-class {{$segmento->status ? "" : "item-desativado"}}">
                <td>{{ $segmento->id }}</td>
                <td>{{ $segmento->nome }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_segmento')
                        <a href="{{ route('segmentos.edit', $segmento->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_segmento')
                        <form action="{{ route('segmentos.destroy', $segmento->id) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_ativar_desativar_segmento')
                        <a href="{{ route('segmentos.ativar_desativar', $segmento->id) }}" data-toggle="tooltip" class="ativar_desativar_class"
                            data-placement="top" @if ($segmento->status) data-texto="Deseja desativar a segmento?" data-title="Desativar" title="Desativar" @else data-texto="Deseja ativar a segmento?" data-title="Ativar" title="Ativar" @endif style="padding: 5px">
                            @if ($segmento->status)
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
    {{ $segmentos->appends(['search' => $search])->links() }}
</div>