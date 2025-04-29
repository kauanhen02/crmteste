<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Descrição</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($perfis as $perfil)
            <tr class="tr-class">
                <td>{{ $perfil->id }}</td>
                <td>{{ $perfil->descricao }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_perfil')
                        <a href="{{ route('perfis.edit', $perfil->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_perfil')
                        @if (count($perfil->users) == 0)
                            <form action="{{ route('perfis.destroy', $perfil->id) }}" method="POST"
                                style="display: inline; padding: 5px; cursor: pointer;"
                                class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                                title="Excluir"><i class="fa-solid fa-trash"></i>
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border: none; background: none; padding: 0;">
                                </button>
                            </form>
                        @endif
                    @endcan
                    @can('permissoes_tela', 'permissao_para_editar_habilidade_perfil')
                        <a href="{{ route('perfis.habilidades', $perfil->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Habilidades" style="padding: 5px"><i class="fa-solid fa-lock"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Paginação -->
<div class="d-flex justify-content-end pagination-class">
    {{ $perfis->appends(['search' => $search])->links() }}
</div>