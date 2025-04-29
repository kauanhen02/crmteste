@extends('layout.layout')

@push('estilos')
    <style>
        .note-hint .arrow {
            display: none !important; /* Esconde a seta, já que ela pode estar cobrindo o conteúdo */
        }

        .note-hint {
            font-size: 16px !important;
            min-height: 30px !important;
            max-height: 200px !important;
            overflow-y: auto !important;
            background: white !important;
            border: 1px solid #ddd !important;
            padding: 5px !important;
            z-index: 9999 !important;
        }

        .note-hint-item {
            padding: 8px 12px !important;
            cursor: pointer !important;
            display: block !important;
        }

        .note-hint-item:hover {
            background-color: #f1f1f1 !important;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div style="background-color: #fff; border-radius:10px; padding: 10px" class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible   show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h4>{{!empty($modelo) ? 'Editar' : 'Criar'}} Modelo Impressão</h4>

        <form action="{{!empty($modelo) ? route('modelosImpressao.update', [$modelo]) : route('modelosImpressao.store')}}" enctype="multipart/form-data" method="POST" id="formModeloImpressao">
            @csrf
            @if (!empty($modelo))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-12 form-group">
                    <label class="form-control-label">Nome <span class="text-danger">*</span></label>
                    <input type="text" name="nome" class="form-control" value="{{old('nome', !empty($modelo) ? $modelo->nome : '')}}">
                    @error('nome')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 form-group">
                    <label class="form-control-label">Texto <span class="text-danger">*</span> <small>para acessar as variaveis de texto digite "{"</small></label>
                    <textarea name="texto" id="texto" cols="30" rows="10" class="form-control summernote">{{old('texto', !empty($modelo) ? $modelo->texto : '')}}</textarea>
                    @error('texto')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="offset-9 col-3">
                    <button type="submit" style="float: right; padding: 5px; margin: 5px" class="btn btn-success">Salvar</button>
                    <button type="button" style="float: right; padding: 5px; margin: 5px" class="btn btn-info"><a href="{{route('modelosImpressao.index')}}" style="color: inherit;">Voltar</a></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#texto").summernote({
                height: 320,
                hint: {
                    words: {!! getVariaveisTexto() !!},
                    match: /\B{(\w*)$/,
                    search: function (keyword, callback) {
                        callback($.grep(this.words, function (item) {
                            return item.indexOf('{' + keyword) === 0;
                        }));
                    },
                    content: function (item) {
                        return item;
                    }, 
                }, 
                lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                fontNames: ["Monotype Corsiva", "Arial", "Arial Black", "Comic Sans MS", "Courier New", "Helvetica Neue", "Helvetica", "Impact", "Lucida Grande", "Tahoma", "Times New Roman", "Verdana"],
                fontSizes: ["6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "24", "36"],
                toolbar: [
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['hr']],
                    ['view', ['fullscreen']],
                    ['misc', ['codeview']]
                ],
            });

             // Configurar MutationObserver para remover a .arrow
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    mutation.addedNodes.forEach(function(node) {
                        if ($(node).hasClass('note-hint')) {
                            $(node).find('.arrow').remove(); // Remove a seta errada
                        }
                    });
                });
            });

            // Observar mudanças no body (onde o Summernote insere elementos)
            observer.observe(document.body, { childList: true, subtree: true });
        })
    </script>
@endpush
