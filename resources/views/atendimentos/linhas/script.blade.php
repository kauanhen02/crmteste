<script>
    $(document).ready(function() {
        callAtivaLinhaScript();
    });

    $('#v-pills-linha-produto').on('click', '#btn-add-linha-produto', function() {
        let url = $(this).attr('data-url');

        let get = 'tipo_solicitacao_id=' + $(
                "#tipo_solicitacao_id").val() + '&solicitado_por=' + $("#solicitado_por").val() +
            '&data_recebimento_amostra=' + $("#data_recebimento_amostra").val() + '&exportacao=' + $(
                "#exportacao").val();

        $("#v-pills-linha-produto").load(url + "?" + get);
    });

    $('#v-pills-linha-produto').on('click', '#btn-volta-linha-produto', function() {
        let url = $(this).attr('data-url');
        $("#v-pills-linha-produto").load(url, function() {
            callAtivaLinhaScript()
        });
    });

    function callAtivaLinhaScript() {
        $(".select2").select2();
        $("#v-pills-linha-produto").on('click', '.edit-linha-produto', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('href');
            $("#v-pills-linha-produto").load(url);
        });

        $("#v-pills-linha-produto").on('click', '.excluir-linha-produto', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('href');
            $("#v-pills-linha-produto").load(url);
        });
    }
</script>
