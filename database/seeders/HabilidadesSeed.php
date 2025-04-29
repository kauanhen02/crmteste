<?php

namespace Database\Seeders;

use App\Models\Habilidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabilidadesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->callHabilidades();        
        $this->apagaHabilidades();        
    }

    function callHabilidades()
    {
        $habilidades = [
            [
                'Usuarios',
                [
                    [
                        'Permissão para visualizar usuarios',
                        'permissao_para_visualizar_usuarios'
                    ],
                    [
                        'Permissão para cadastrar usuarios',
                        'permissao_para_cadastrar_usuarios'
                    ],
                    [
                        'Permissão para editar usuarios',
                        'permissao_para_editar_usuarios'
                    ],
                    [
                        'Permissão para excluir usuarios',
                        'permissao_para_excluir_usuarios'
                    ]
                ]
            ],
            [
                'Perfis',
                [
                    [
                        'Permissão para visualizar perfil',
                        'permissao_para_visualizar_perfil'
                    ],
                    [
                        'Permissão para cadastrar perfil',
                        'permissao_para_cadastrar_perfil'
                    ],
                    [
                        'Permissão para editar perfil',
                        'permissao_para_editar_perfil'
                    ],
                    [
                        'Permissão para excluir perfil',
                        'permissao_para_excluir_perfil'
                    ],
                    [
                        'Permissão para editar habilidade perfil',
                        'permissao_para_editar_habilidade_perfil'
                    ]
                ]
            ],
            [
                'Carteiras',
                [
                    [
                        'Permissão para visualizar carteira',
                        'permissao_para_visualizar_carteira'
                    ],
                    [
                        'Permissão para cadastrar carteira',
                        'permissao_para_cadastrar_carteira'
                    ],
                    [
                        'Permissão para editar carteira',
                        'permissao_para_editar_carteira'
                    ],
                    [
                        'Permissão para excluir carteira',
                        'permissao_para_excluir_carteira'
                    ],
                    [
                        'Permissão para ativar/desativar carteira',
                        'permissao_para_ativar_desativar_carteira'
                    ]
                ]
            ],
            [
                'Segmentos',
                [
                    [
                        'Permissão para visualizar segmento',
                        'permissao_para_visualizar_segmento'
                    ],
                    [
                        'Permissão para cadastrar segmento',
                        'permissao_para_cadastrar_segmento'
                    ],
                    [
                        'Permissão para editar segmento',
                        'permissao_para_editar_segmento'
                    ],
                    [
                        'Permissão para excluir segmento',
                        'permissao_para_excluir_segmento'
                    ],
                    [
                        'Permissão para ativar/desativar segmento',
                        'permissao_para_ativar_desativar_segmento'
                    ]
                ]
            ],
            [
                'Formas de atuações',
                [
                    [
                        'Permissão para visualizar forma de atuação',
                        'permissao_para_visualizar_forma_atuacao'
                    ],
                    [
                        'Permissão para cadastrar forma de atuação',
                        'permissao_para_cadastrar_forma_atuacao'
                    ],
                    [
                        'Permissão para editar forma de atuação',
                        'permissao_para_editar_forma_atuacao'
                    ],
                    [
                        'Permissão para excluir forma de atuação',
                        'permissao_para_excluir_forma_atuacao'
                    ],
                    [
                        'Permissão para ativar/desativar forma de atuação',
                        'permissao_para_ativar_desativar_forma_atuacao'
                    ]
                ]
            ],
            [
                'Sub grupos',
                [
                    [
                        'Permissão para visualizar sub grupo',
                        'permissao_para_visualizar_sub_grupo'
                    ],
                    [
                        'Permissão para cadastrar sub grupo',
                        'permissao_para_cadastrar_sub_grupo'
                    ],
                    [
                        'Permissão para editar sub grupo',
                        'permissao_para_editar_sub_grupo'
                    ],
                    [
                        'Permissão para excluir sub grupo',
                        'permissao_para_excluir_sub_grupo'
                    ],
                    [
                        'Permissão para ativar/desativar sub grupo',
                        'permissao_para_ativar_desativar_sub_grupo'
                    ]
                ]
            ],
            [
                'Grupos',
                [
                    [
                        'Permissão para visualizar grupo',
                        'permissao_para_visualizar_grupo'
                    ],
                    [
                        'Permissão para cadastrar grupo',
                        'permissao_para_cadastrar_grupo'
                    ],
                    [
                        'Permissão para editar grupo',
                        'permissao_para_editar_grupo'
                    ],
                    [
                        'Permissão para excluir grupo',
                        'permissao_para_excluir_grupo'
                    ],
                    [
                        'Permissão para ativar/desativar grupo',
                        'permissao_para_ativar_desativar_grupo'
                    ]
                ]
            ],
            [
                'Status LGPD',
                [
                    [
                        'Permissão para visualizar status lgpd',
                        'permissao_para_visualizar_status_lgpd'
                    ],
                    [
                        'Permissão para cadastrar status lgpd',
                        'permissao_para_cadastrar_status_lgpd'
                    ],
                    [
                        'Permissão para editar status lgpd',
                        'permissao_para_editar_status_lgpd'
                    ],
                    [
                        'Permissão para excluir status lgpd',
                        'permissao_para_excluir_status_lgpd'
                    ],
                    [
                        'Permissão para ativar/desativar status lgpd',
                        'permissao_para_ativar_desativar_status_lgpd'
                    ]
                ]
            ],
            [
                'Cliente',
                [
                    [
                        'Permissão para visualizar cliente',
                        'permissao_para_visualizar_cliente'
                    ],
                    [
                        'Permissão para cadastrar cliente',
                        'permissao_para_cadastrar_cliente'
                    ],
                    [
                        'Permissão para editar cliente',
                        'permissao_para_editar_cliente'
                    ],
                    [
                        'Permissão para excluir cliente',
                        'permissao_para_excluir_cliente'
                    ],
                    [
                        'Permissão para ativar/desativar cliente',
                        'permissao_para_ativar_desativar_cliente'
                    ]
                ]
            ],
            [
                'Produto/Serviço',
                [
                    [
                        'Permissão para visualizar produto/serviço',
                        'permissao_para_visualizar_produto_servico'
                    ],
                    [
                        'Permissão para cadastrar produto/serviço',
                        'permissao_para_cadastrar_produto_servico'
                    ],
                    [
                        'Permissão para editar produto/serviço',
                        'permissao_para_editar_produto_servico'
                    ],
                    [
                        'Permissão para excluir produto/serviço',
                        'permissao_para_excluir_produto_servico'
                    ]
                ]
            ],
            [
                'Envios',
                [
                    [
                        'Permissão para visualizar envio',
                        'permissao_para_visualizar_envio'
                    ],
                    [
                        'Permissão para cadastrar envio',
                        'permissao_para_cadastrar_envio'
                    ],
                    [
                        'Permissão para editar envio',
                        'permissao_para_editar_envio'
                    ],
                    [
                        'Permissão para excluir envio',
                        'permissao_para_excluir_envio'
                    ],
                    [
                        'Permissão para ativar/desativar envio',
                        'permissao_para_ativar_desativar_envio'
                    ]
                ]
            ],
            [
                'Tipos de atendimentos',
                [
                    [
                        'Permissão para visualizar tipo de atendimento',
                        'permissao_para_visualizar_tipo_atendimento'
                    ],
                    [
                        'Permissão para cadastrar tipo de atendimento',
                        'permissao_para_cadastrar_tipo_atendimento'
                    ],
                    [
                        'Permissão para editar tipo de atendimento',
                        'permissao_para_editar_tipo_atendimento'
                    ],
                    [
                        'Permissão para excluir tipo de atendimento',
                        'permissao_para_excluir_tipo_atendimento'
                    ],
                    [
                        'Permissão para ativar/desativar tipo de atendimento',
                        'permissao_para_ativar_desativar_tipo_atendimento'
                    ]
                ]
            ],
            [
                'Tipos de solicitações',
                [
                    [
                        'Permissão para visualizar tipo de solicitação',
                        'permissao_para_visualizar_tipo_solicitacao'
                    ],
                    [
                        'Permissão para cadastrar tipo de solicitação',
                        'permissao_para_cadastrar_tipo_solicitacao'
                    ],
                    [
                        'Permissão para editar tipo de solicitação',
                        'permissao_para_editar_tipo_solicitacao'
                    ],
                    [
                        'Permissão para excluir tipo de solicitação',
                        'permissao_para_excluir_tipo_solicitacao'
                    ],
                    [
                        'Permissão para ativar/desativar tipo de solicitação',
                        'permissao_para_ativar_desativar_tipo_solicitacao'
                    ]
                ]
            ],
            [
                'Categorias',
                [
                    [
                        'Permissão para visualizar categoria',
                        'permissao_para_visualizar_categoria'
                    ],
                    [
                        'Permissão para cadastrar categoria',
                        'permissao_para_cadastrar_categoria'
                    ],
                    [
                        'Permissão para editar categoria',
                        'permissao_para_editar_categoria'
                    ],
                    [
                        'Permissão para excluir categoria',
                        'permissao_para_excluir_categoria'
                    ],
                    [
                        'Permissão para ativar/desativar categoria',
                        'permissao_para_ativar_desativar_categoria'
                    ]
                ]
            ],
            [
                'Linhas',
                [
                    [
                        'Permissão para visualizar linha',
                        'permissao_para_visualizar_linha'
                    ],
                    [
                        'Permissão para cadastrar linha',
                        'permissao_para_cadastrar_linha'
                    ],
                    [
                        'Permissão para editar linha',
                        'permissao_para_editar_linha'
                    ],
                    [
                        'Permissão para excluir linha',
                        'permissao_para_excluir_linha'
                    ],
                    [
                        'Permissão para ativar/desativar linha',
                        'permissao_para_ativar_desativar_linha'
                    ]
                ]
            ],
            [
                'Volumes',
                [
                    [
                        'Permissão para visualizar volume',
                        'permissao_para_visualizar_volume'
                    ],
                    [
                        'Permissão para cadastrar volume',
                        'permissao_para_cadastrar_volume'
                    ],
                    [
                        'Permissão para editar volume',
                        'permissao_para_editar_volume'
                    ],
                    [
                        'Permissão para excluir volume',
                        'permissao_para_excluir_volume'
                    ],
                    [
                        'Permissão para ativar/desativar volume',
                        'permissao_para_ativar_desativar_volume'
                    ]
                ]
            ],
            [
                'Destinos',
                [
                    [
                        'Permissão para visualizar destino',
                        'permissao_para_visualizar_destino'
                    ],
                    [
                        'Permissão para cadastrar destino',
                        'permissao_para_cadastrar_destino'
                    ],
                    [
                        'Permissão para editar destino',
                        'permissao_para_editar_destino'
                    ],
                    [
                        'Permissão para excluir destino',
                        'permissao_para_excluir_destino'
                    ],
                    [
                        'Permissão para ativar/desativar destino',
                        'permissao_para_ativar_desativar_destino'
                    ]
                ]
            ],
            [
                'Atendimentos',
                [
                    [
                        'Permissão para visualizar atendimento',
                        'permissao_para_visualizar_atendimento'
                    ],
                    [
                        'Permissão para cadastrar atendimento',
                        'permissao_para_cadastrar_atendimento'
                    ],
                    [
                        'Permissão para editar atendimento',
                        'permissao_para_editar_atendimento'
                    ],
                    [
                        'Permissão para excluir atendimento',
                        'permissao_para_excluir_atendimento'
                    ],
                    [
                        'Permissão para editar ação de marketing',
                        'permissao_para_editar_acao_marketing'
                    ],
                    [
                        'Permissão para editar concorrente',
                        'permissao_para_editar_concorrente'
                    ]
                ]
            ],
            [
                'Atendimentos > Linha de produto',
                [
                    [
                        'Permissão para visualizar linha de produto',
                        'permissao_para_visualizar_linha_produto'
                    ],
                    [
                        'Permissão para cadastrar linha de produto',
                        'permissao_para_cadastrar_linha_produto'
                    ],
                    [
                        'Permissão para editar linha de produto',
                        'permissao_para_editar_linha_produto'
                    ],
                    [
                        'Permissão para excluir linha de produto',
                        'permissao_para_excluir_linha_produto'
                    ]
                ]
            ],
            [
                'Atendimentos > Envio',
                [
                    [
                        'Permissão para visualizar envio de atendimento',
                        'permissao_para_visualizar_atendimento_envio'
                    ],
                    [
                        'Permissão para cadastrar envio de atendimento',
                        'permissao_para_cadastrar_atendimento_envio'
                    ],
                    [
                        'Permissão para editar envio de atendimento',
                        'permissao_para_editar_atendimento_envio'
                    ],
                    [
                        'Permissão para excluir envio de atendimento',
                        'permissao_para_excluir_atendimento_envio'
                    ]
                ]
            ],
            [
                'Atendimentos > Anexo',
                [
                    [
                        'Permissão para visualizar anexo de atendimento',
                        'permissao_para_visualizar_atendimento_anexo'
                    ],
                    [
                        'Permissão para cadastrar anexo de atendimento',
                        'permissao_para_cadastrar_atendimento_anexo'
                    ],
                    [
                        'Permissão para editar anexo de atendimento',
                        'permissao_para_editar_atendimento_anexo'
                    ],
                    [
                        'Permissão para excluir anexo de atendimento',
                        'permissao_para_excluir_atendimento_anexo'
                    ]
                ]
            ],
            [
                'Projeto > Status',
                [
                    [
                        'Permissão para alterar status para reprovado',
                        'permissao_para_alterar_status_reprovado'
                    ],
                    [
                        'Permissão para visualizar status para reprovado',
                        'permissao_para_visualizar_status_reprovado'
                    ],
                    [
                        'Permissão para alterar status para aprovar',
                        'permissao_para_alterar_status_aprovar'
                    ],
                    [
                        'Permissão para visualizar status para aprovar',
                        'permissao_para_visualizar_status_aprovar'
                    ],
                    [
                        'Permissão para alterar status para enviar para laboratorio',
                        'permissao_para_alterar_status_enviar_laboratorio'
                    ],
                    [
                        'Permissão para visualizar status para enviar para laboratorio',
                        'permissao_para_visualizar_status_enviar_laboratorio'
                    ],
                    [
                        'Permissão para alterar status para avaliação final',
                        'permissao_para_alterar_status_avaliacao_final'
                    ],
                    [
                        'Permissão para visualizar status para avaliação final',
                        'permissao_para_visualizar_status_avaliacao_final'
                    ],
                    [
                        'Permissão para alterar status para concluir',
                        'permissao_para_alterar_status_concluir'
                    ],
                    [
                        'Permissão para visualizar status para concluir',
                        'permissao_para_visualizar_status_concluir'
                    ],
                ]
            ],
            [
                'Projetos',
                [
                    [
                        'Permissão para visualizar projetos',
                        'permissao_para_visualizar_projeto'
                    ],
                    [
                        'Permissão para visualizar todos projetos',
                        'permissao_para_visualizar_todos_projeto'
                    ],
                    [
                        'Permissão para imprimir projetos',
                        'permissao_para_imprimir_projeto'
                    ],
                    [
                        'Permissão para alterar usuario responsável',
                        'permissao_para_alterar_usuario_responsavel'
                    ],
                    [
                        'Permissão para visualizar markup',
                        'permissao_para_visualizar_markup'
                    ],
                    [
                        'Permissão para editar markup',
                        'permissao_para_editar_markup'
                    ]
                ]
            ],
            [
                'Modelo impressão',
                [
                    [
                        'Permissão para visualizar modelo de impressão',
                        'permissao_para_visualizar_modelo_impressao'
                    ],
                    [
                        'Permissão para cadastrar modelo de impressão',
                        'permissao_para_cadastrar_modelo_impressao'
                    ],
                    [
                        'Permissão para editar modelo de impressão',
                        'permissao_para_editar_modelo_impressao'
                    ],
                    [
                        'Permissão para excluir modelo de impressão',
                        'permissao_para_excluir_modelo_impressao'
                    ],
                    [
                        'Permissão para ativar/desativar modelo de impressão',
                        'permissao_para_ativar_desativar_modelo_impressao'
                    ]
                ]
            ],
            [
                'Projetos > Laboratório',
                [
                    [
                        'Permissão para visualizar laboratório desenvolvimento',
                        'permissao_para_visualizar_laboratorio_desenvolvimento'
                    ],
                    [
                        'Permissão para editar laboratório desenvolvimento',
                        'permissao_para_editar_laboratorio_desenvolvimento'
                    ],
                    [
                        'Permissão para visualizar laboratório aplicação',
                        'permissao_para_visualizar_laboratorio_aplicacao'
                    ],
                    [
                        'Permissão para editar laboratório aplicação',
                        'permissao_para_editar_laboratorio_aplicacao'
                    ]
                ]
            ],
            [
                'Projetos > Questionário ISO',
                [
                    [
                        'Permissão para visualizar questionário ISO',
                        'permissao_para_visualizar_questionario_iso'
                    ],
                    [
                        'Permissão para editar questionário ISO',
                        'permissao_para_editar_questionario_iso'
                    ]
                ]
            ],
        ];  
        
        foreach ($habilidades as $key => $grupo) {
            foreach ($grupo[1] as $keyH => $permissao) {
                $dados = [
                    'grupo_habilidade' => $grupo[0],
                    'nome_unico' => $permissao[1],
                    'nome' => $permissao[0],
                ];

                $habilidade = Habilidade::where('nome_unico', $permissao[1])->first();
                if(isset($habilidade) && !empty($habilidade)){
                    $habilidade->update($dados);
                }else{
                    Habilidade::create($dados);
                }
            }
        }

        return $habilidades;
    }

    function apagaHabilidades()
    {
        $habilidades = [
            // informe o nome_unico
        ];

        if(count($habilidades) > 0){
            Habilidade::whereIn('nome_unico', $habilidades)->delete();
        }

        return true;
    }
}
