<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Razão social</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr class="tr-class {{$cliente->status ? "" : "item-desativado"}}">
                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->razao_social }}</td>
                <td>{{ $cliente->telefone }}</td>
                <td>{{ $cliente->email }}</td>
                <td>
                    @can('permissoes_tela', 'permissao_para_editar_cliente')
                        <a href="{{ route('clientes.edit', $cliente->id) }}" data-toggle="tooltip"
                            data-placement="top" title="Editar" style="padding: 5px"><i
                                class="fa-solid fa-pencil"></i></a>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_excluir_cliente')
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                            style="display: inline; padding: 5px; cursor: pointer;"
                            class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                            title="Excluir"><i class="fa-solid fa-trash"></i>
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;">
                            </button>
                        </form>
                    @endcan
                    @can('permissoes_tela', 'permissao_para_ativar_desativar_cliente')
                        <a href="{{ route('clientes.ativar_desativar', $cliente->id) }}" data-toggle="tooltip" class="ativar_desativar_class"
                            data-placement="top" @if ($cliente->status) data-texto="Deseja desativar a cliente?" data-title="Desativar" title="Desativar" @else data-texto="Deseja ativar a cliente?" data-title="Ativar" title="Ativar" @endif style="padding: 5px">
                            @if ($cliente->status)
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
    {{ $clientes->appends(['search' => $search])->links() }}
</div>