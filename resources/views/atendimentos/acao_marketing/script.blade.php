<script>
    $(document).ready(function(){
        verificaAcaoMarketing();
    })

    $("#acao_marketing").on('click', function(e){
        verificaAcaoMarketing();
    });

    function verificaAcaoMarketing()
    {
        $(".open-acao-marketing").hide();
        $(".close-acao-marketing").show();
        if($("#acao_marketing").is(":checked")){
            $(".open-acao-marketing").show();            
            $(".close-acao-marketing").hide();
        }
    }

    $("#salvar-acao-marketing").on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#formAcaoMarketing").submit();
    });

    $("#formAcaoMarketing").on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        let url = $(this).attr('action');
        Olimpus.ajaxForm('formAcaoMarketing', url, null, null); 
    });
</script>