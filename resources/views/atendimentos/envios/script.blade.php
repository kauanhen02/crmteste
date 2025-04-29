<script>
    $(document).ready(function() {
        callAtivaEnvioScript();
    });

    $('#v-pills-envios').on('click', '#btn-add-envios', function() {
        let url = $(this).attr('data-url');

        $("#v-pills-envios").load(url);
    });

    $('#v-pills-envios').on('click', '#btn-volta-envios', function() {
        let url = $(this).attr('data-url');
        $("#v-pills-envios").load(url, function() {
            callAtivaEnvioScript()
        });
    });

    function callAtivaEnvioScript() {
        $(".select2").select2();
        $("#v-pills-envios").on('click', '.edit-envios', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('href');
            $("#v-pills-envios").load(url);
        });

        $("#v-pills-envios").on('click', '.excluir-envios', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('href');
            $("#v-pills-envios").load(url);
        });
    }
</script>
