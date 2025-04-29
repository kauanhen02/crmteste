<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Destino</th>
            <th>Envio</th>
            <th>Contato</th>
            <th>Cep</th>
            <th>Endereço</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($envios as $envio)
            <tr class="tr-class">
                <td>{{ $envio->id }}</td>
                <td>{{ $envio->destinoTrashed->nome }}</td>
                <td>{{ $envio->envioTrashed->nome }}</td>
                <td>{{ $envio->contato }}</td>
                <td>{{ $envio->cep }}</td>
                <td>{{ $envio->rua }}, {{$envio->numero}} - {{$envio->bairro}}</td>
                <td>{{ $envio->cidade }}</td>
                <td>{{ $envio->estado }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_atendimento_envio')
                        @if (!isset($projeto))
                            <a href="{{ route('atendimentoEnvios.edit', [$atendimento->id, $envio->id]) }}" data-toggle="tooltip" data-placement="top" title="Editar" style="padding: 5px" class="edit-envios"><i class="fa-solid fa-pencil"></i></a>
                        @endif
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_atendimento_envio')
                        <form action="{{ route('atendimentoEnvios.destroy', [$atendimento->id, $envio->id]) }}" method="POST"
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
    {{ $envios->appends(['search_destino' => $search_destino])->links() }}
</div>