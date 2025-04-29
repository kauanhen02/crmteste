<script>
    $("#salvar-lab-aplicacao").on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#formLabAplicacao").submit();
    });

    $("#formLabAplicacao").on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        let url = $(this).attr('action');
        Olimpus.ajaxForm('formLabAplicacao', url, null, null); 
    });
    
    $("#salvar-lab-desenvolvimento").on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#formLabDesenvolvimento").submit();
    });

    $("#formLabDesenvolvimento").on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        let url = $(this).attr('action');
        Olimpus.ajaxForm('formLabDesenvolvimento', url, null, null); 
    });
</script>