<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Descrição</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($anexos as $anexo)
            <tr class="tr-class">
                <td>{{ $anexo->id }}</td>
                <td>{{ $anexo->descricao }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_atendimento_anexo')
                        @if (!isset($projeto))
                            <a href="{{ route('atendimentoAnexos.edit', [$atendimento->id, $anexo->id]) }}" data-toggle="tooltip" data-placement="top" title="Editar" style="padding: 5px" class="edit-anexos"><i class="fa-solid fa-pencil"></i></a>
                        @endif
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_atendimento_anexo')
                        <form action="{{ route('atendimentoAnexos.destroy', [$atendimento->id, $anexo->id]) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_editar_atendimento_anexo')
                        <a href="{{ route('atendimentoAnexos.getAnexo', [$atendimento->id, $anexo->id]) }}" data-toggle="tooltip"
                            data-placement="top" title="Visualizar anexo" style="padding: 5px" class="visualizar-anexos"><i
                                class="fa-solid fa-eye"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_editar_atendimento_anexo')
                        <a href="{{ route('atendimentoAnexos.baixarAnexo', [$atendimento->id, $anexo->id]) }}" data-toggle="tooltip"
                            data-placement="top" title="Baixar anexo" style="padding: 5px" class="download-anexos"><i
                                class="fa-solid fa-download"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Paginação -->
<div class="d-flex justify-content-end pagination-class">
    {{ $anexos->appends(['search_anexo' => $search_anexo])->links() }}
</div>