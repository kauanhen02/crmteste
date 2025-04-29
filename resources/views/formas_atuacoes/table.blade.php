<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($atuacoes as $atuacao)
            <tr class="tr-class {{$atuacao->status ? "" : "item-desativado"}}">
                <td>{{ $atuacao->id }}</td>
                <td>{{ $atuacao->nome }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_forma_atuacao')
                        <a href="{{ route('formas_atuacoes.edit', $atuacao->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_forma_atuacao')
                        <form action="{{ route('formas_atuacoes.destroy', $atuacao->id) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_ativar_desativar_forma_atuacao')
                        <a href="{{ route('formas_atuacoes.ativar_desativar', $atuacao->id) }}" data-toggle="tooltip" class="ativar_desativar_class"
                            data-placement="top" @if ($atuacao->status) data-texto="Deseja desativar a forma de atuação?" data-title="Desativar" title="Desativar" @else data-texto="Deseja ativar a forma de atuação?" data-title="Ativar" title="Ativar" @endif style="padding: 5px">
                            @if ($atuacao->status)
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
    {{ $atuacoes->appends(['search' => $search])->links() }}
</div>