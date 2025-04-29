<?php 

if (!function_exists('getVariaveisTexto')) {
    function getVariaveisTexto()
    {
        return json_encode([
            '{data_hora_atual}',
            '{usuario_imprimiu}',
            '{cliente}',
            '{usuario_abriu}',
            '{tipo_atendimento}',
            '{assunto}',
            '{nome_projeto}',
            '{status_lgpd}',
            '{status_projeto}',
            '{nivel_urgencia}',
            '{feito_em}',
            '{prazo}',
            '{meio_contato}',
            '{contato}',
            '{observacao}',
            '{linha_produto}',
            '{acoes_marketing}',
            '{concorrentes_nossos}',
            '{concorrentes_cliente}',
        ]);
    }
}