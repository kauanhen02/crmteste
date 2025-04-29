<script>
    $("#salvar-concorrente").on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#formConcorrente").submit();
    });

    $("#formConcorrente").on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        let url = $(this).attr('action');
        Olimpus.ajaxForm('formConcorrente', url, null, null); 
    });
</script>