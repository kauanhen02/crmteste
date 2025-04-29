<script>
    $(document).ready(function() {
        callAtivaAnexoscript();
    });

    $('#v-pills-anexos').on('click', '#btn-add-anexos', function() {
        let url = $(this).attr('data-url');

        $("#v-pills-anexos").load(url);
    });

    $('#v-pills-anexos').on('click', '#btn-volta-anexos', function() {
        let url = $(this).attr('data-url');
        $("#v-pills-anexos").load(url, function() {
            callAtivaAnexoscript()
        });
    });

    function callAtivaAnexoscript() {
        $(".select2").select2();
        $("#v-pills-anexos").on('click', '.edit-anexos', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('href');
            $("#v-pills-anexos").load(url);
        });

        $("#v-pills-anexos").on('click', '.excluir-anexos', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = $(this).attr('href');
            $("#v-pills-anexos").load(url);
        });

        $("#v-pills-anexos").on('click', '.visualizar-anexos', function (e) {
            e.stopImmediatePropagation();
            e.preventDefault();
    
            let url = $(this).attr('href');
            $("#modal-tab").load(url, function() {
                $("#modal-visualizar-anexo").modal()
            });
        });
    }

</script>
