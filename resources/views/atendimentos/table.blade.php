<table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
    <thead>
        <tr>
            <th>Id</th>
            <th>Cliente</th>
            @if (isset($projeto))
                <th>Usuario responsável</th>
            @endif
            <th>Assunto</th>
            <th>Projeto</th>
            <th>Status</th>
            <th>Urgência</th>
            <th>Prazo</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($atendimentos as $atendimento)
            <tr class="tr-class @if ($atendimento->status == "reprovado") item-desativado @endif {{ (isset($projeto)) ? $atendimento->status."-status" : '' }}">
                <td>{{ $atendimento->id }}</td>
                <td>{{ $atendimento->clienteTrashed->nome }}</td>
                @if (isset($projeto))
                    <td>{{ $atendimento->usuarioResponsavelTrashed->name ?? '' }}</td>
                @endif
                <td>{{ $atendimento->assunto }}</td>
                <td>{{ $atendimento->nome_projeto }}</td>
                <td>{{ $atendimento->statusLgpdTrashed->nome }}</td>
                <td>{{ App\Models\Atendimento::nivelUrgencia($atendimento->nivel_urgencia) }}</td>
                <td>{{ $atendimento->prazo->format('d/m/Y') }}</td>
                <td>
                    @if (\Gate::check('permissoes_tela', 'permissao_para_editar_atendimento') || \Gate::check('permissoes_tela', 'permissao_para_editar_atendimento'))    
                        <a href="{{ !isset($projeto) ? route('atendimentos.edit', $atendimento->id) : route('projetos.edit', [$atendimento->id, 'projeto' => 2]) }}" data-toggle="tooltip" data-placement="top" title="{{ !isset($projeto) ? 'Editar' : 'Visualizar' }}" style="padding: 5px;{{ isset($projeto) ? 'color: white;' : '' }}"><i class=" {{ !isset($projeto) ? 'fa-solid fa-pencil' : 'fa-solid fa-eye' }}"></i></a>
                    @endif
                    @if (!isset($projeto))
                        @can('permissoes_tela', 'permissao_para_excluir_atendimento')
                            <form action="{{ route('atendimentos.destroy', $atendimento->id) }}" method="POST"
                                style="display: inline; padding: 5px; cursor: pointer;"
                                class="form-excluir-registro" data-toggle="tooltip" data-placement="top"
                                title="Excluir"><i class="fa-solid fa-trash"></i>
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border: none; background: none; padding: 0;">
                                </button>
                            </form>
                        @endcan
                    @endif
                    @if (isset($projeto))
                        @can('permissoes_tela', 'permissao_para_imprimir_projeto')
                            <button type="button" class="imprimir-projeto" data-projeto="{{ $atendimento->id }}" style="border: none; background: none; padding: 0;color: white;" data-toggle="tooltip" data-placement="top" data-url="{{ route('projetos.imprimirProjeto', $atendimento) }}"
                            title="Imprimir"><i class="fa-solid fa-print"></i></button>
                        @endcan
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Paginação -->
<div class="d-flex justify-content-end pagination-class">
    {{ $atendimentos->appends(['search' => $search])->links() }}
</div>


@push('scripts')
    <script>
        var modelos = @json($modelos);
        $(document).ready(function() {
            $(".table-lista").on('click', '.imprimir-projeto', function(){
                let url = $(this).attr('data-url');
                Swal.fire({
                    title: "Selecione um modelo de impressão",
                    input: "select",
                    inputOptions: modelos,
                    inputPlaceholder: "Selecione um modelo",
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if(value){
                            url += "?impressao="+value;
                            window.open(url, '_blank');
                        }
                    }
                });
            })
        })
    </script>
@endpush
