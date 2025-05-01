<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>CRM </title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">

    <!-- Owl Carousel CSS -->
    <link href="{{ asset('vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Select CSS -->
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
	

    <!-- Main Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <!-- jQuery (Ensure this is loaded before any other script that uses $) -->

	<link href="{{ asset('plugins/fontawesome/css/fontawesome.css') }}" rel="stylesheet" />
	<link href="{{ asset('plugins/fontawesome/css/brands.css') }}" rel="stylesheet" />
	<link href="{{ asset('plugins/fontawesome/css/solid.css') }}" rel="stylesheet" />

    {{-- TOAST LINK https://kamranahmed.info/toast#toast-generator --}}
	<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('plugins/toast/jquery.toast.min.css') }}" rel="stylesheet" />

	<link href="{{ asset('plugins/sweetalert/dist/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('plugins/summernote/summernote.min.css') }}" rel="stylesheet">

</head>
<style>
    .select2-container--default .select2-selection--single {
        border-color: #d9d9d9;
        height: 38px; 
        
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px; 
        
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 33px; 
        border-radius: 2px
    }
	
	
	.loader {
		width: 48px;
		height: 48px;
		border: 5px dotted #000; /* Alterado para preto */
		border-radius: 50%;
		display: inline-block;
		position: absolute; /* Ajustado para centralizar */
		top: 50%; /* Centraliza verticalmente */
		left: 50%; /* Centraliza horizontalmente */
		transform: translate(-50%, -50%); /* Corrige o deslocamento para o centro */
		box-sizing: border-box;
		animation: rotation 2s linear infinite;
	}


	.loading {
		position: fixed;
		z-index: 9999;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(128, 128, 128, 0.35);
		backdrop-filter: blur(4px); /* Efeito de desfoque no fundo */
	}

	.class-loading {
		/* Personalize o spinner conforme sua necessidade */
		width: 3rem;
		height: 3rem;
	}

	@keyframes rotation {
		0% {
			transform: translate(-50%, -50%) rotate(0deg);
		}
		100% {
			transform: translate(-50%, -50%) rotate(360deg);
		}
	} 

    .table-lista .item-desativado {
        background: #ed434336!important;
    }

    .form-control-feedback {
        color: red;
    }

    .form-control-danger{
        color: red;
    }
</style>

@stack('estilos')
<body>

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="loading-off" id="loading">
        <div class="loadericon"></div>
    </div>

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader loading" style="display: none">
        <span class="class-loading"></span>
    </div>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('images/logo.png')}}" alt="">
                <img class="logo-compact" src="{{ asset('images/logo-text.png')}}" alt="">
                <img class="brand-title" src="{{ asset('images/logo-text.png')}}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                Dashboard
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:;" role="button" data-toggle="dropdown">
                                    <img src="{{asset('images/client_default.png')}}" width="20" alt=""/>
									<div class="header-info">
										<span>Ola,<strong> {{request()->user()->name}}</strong></span>
									</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item ai-icon" >
										
										<form action="{{ route('logout') }}" method="POST" style="display: inline;">
											@csrf
											<button type="submit" class="dropdown-item ai-icon" style="border: none; background: none; padding: 0;">
												<svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
													<polyline points="16 17 21 12 16 7"></polyline>
													<line x1="21" y1="12" x2="9" y2="12"></line>
												</svg>
												<span class="ml-2">Logout </span>
											</button>
										</form>
									</a>
									
									
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    @if (\Gate::check('permissoes_tela', 'permissao_para_visualizar_atendimento'))                   
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="fa-solid fa-paste"></i>
                                <span class="nav-text">Atendimentos</span>
                            </a>						
                            <ul aria-expanded="false">
                                @can('permissoes_tela', 'permissao_para_visualizar_atendimento')
                                    <li><a href="{{route('atendimentos.index')}}">Atendimentos</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_projeto')
                                    <li><a href="{{route('projetos.index')}}">Projetos</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_modelo_impressao')
                                    <li><a href="{{route('modelosImpressao.index')}}">Modelo Impressão</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                    @if (
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_carteira') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_segmento') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_forma_atuacao') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_status_lgpd') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_cliente') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_grupo') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_sub_grupo') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_produto_servico') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_envio') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_tipo_atendimento') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_tipo_solicitacao') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_categoria') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_linha') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_volume') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_destino')
                        )
                        <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="fa-solid fa-pen-to-square"></i>
                                <span class="nav-text">Cadastros</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('permissoes_tela', 'permissao_para_visualizar_carteira')
                                    <li><a href="{{route('carteiras.index')}}">Carteira</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_segmento')
                                    <li><a href="{{route('segmentos.index')}}">Segmento</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_forma_atuacao')
                                    <li><a href="{{route('formas_atuacoes.index')}}">Forma de atuação</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_status_lgpd')
                                    <li><a href="{{route('status.index')}}">Status LGPD</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_cliente')
                                    <li><a href="{{route('clientes.index')}}">Clientes</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_grupo')
                                    <li><a href="{{route('grupos.index')}}">Grupo</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_sub_grupo')
                                    <li><a href="{{route('sub_grupos.index')}}">Sub grupo</a></li>
                                @endcan							
                                @can('permissoes_tela', 'permissao_para_visualizar_produto_servico')
                                    <li><a href="{{route('produtos_servicos.index')}}">Produto/Serviço</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_envio')
                                    <li><a href="{{route('envios.index')}}">Envios</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_tipo_atendimento')
                                    <li><a href="{{route('tipoAtendimentos.index')}}">Tipo de atendimentos</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_tipo_solicitacao')
                                    <li><a href="{{route('tipoSolicitacoes.index')}}">Tipo de solicitação</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_categoria')
                                    <li><a href="{{route('categorias.index')}}">Categoria</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_linha')
                                    <li><a href="{{route('linhas.index')}}">Linha</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_volume')
                                    <li><a href="{{route('volumes.index')}}">Volume</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_destino')
                                    <li><a href="{{route('destinos.index')}}">Destino</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                    @if (
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_usuarios') ||
                        \Gate::check('permissoes_tela', 'permissao_para_visualizar_perfil') 
                        )      
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="fa-solid fa-gear"></i>
                                <span class="nav-text">Configurações</span>
                            </a>						
                            <ul aria-expanded="false">
                                @can('permissoes_tela', 'permissao_para_visualizar_usuarios')
                                    <li><a href="{{route('usuarios.index')}}">Usuario</a></li>
                                @endcan
                                @can('permissoes_tela', 'permissao_para_visualizar_perfil')
                                    <li><a href="{{route('perfis.index')}}">Perfis</a></li>								
                                @endcan
                            </ul>
                        </li>
                    @endif
                    
                </ul>
            
				
				<div class="copyright">
					<p class="fs-14 font-w200"><strong class="font-w400">CRM</strong> </p>
					<p>Desenvolvido por <i class="fa fa-heart" style="width: 20px"></i> Keon Group Ltda</p>
				</div>
			</div>
        </div>

        <div class="content-body">
            <!-- row -->
			@yield('content')

        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://wa.me/5519993480072" target="_blank">Keon Group Ltda</a> 2024</p>
            </div>
        </div>


    </div>
	
		
<script>
    var token = "{{ csrf_token() }}";
</script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/global/global.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>


<script src="{{ asset('js/deznav-init.js') }}"></script>
<script src="{{ asset('vendor/owl-carousel/owl.carousel.js') }}"></script>

<script src="{{ asset('plugins/fontawesome/js/fontawesome.min.js')}}"></script>
<script src="{{ asset('plugins/sweetalert/dist/sweetalert2.all.min.js')}}"></script>
{{-- TOAST LINK https://kamranahmed.info/toast#toast-generator --}}
<script src="{{ asset('vendor/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('plugins/toast/jquery.toast.min.js')}}"></script>
<script src="{{ asset('plugins/mask/meiomask.js')}}"></script>

<script src="{{ asset('js/personalizado.js')}}"></script>

<script src="{{ asset('plugins/summernote/summernote.min.js')}}"></script>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        
        $('[data-toggle="tooltip"]').on("click", function () {
            $(this).tooltip("hide");
        });

        $('input[type="text"]').setMask();
    })
    function assignedDoctor() {
        /*  testimonial one function by = owl.carousel.js */
        jQuery('.assigned-doctor').owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            autoplaySpeed: 3000,
            navSpeed: 3000,
            paginationSpeed: 3000,
            slideSpeed: 3000,
            smartSpeed: 3000,
            autoplay: false,
            dots: false,
            navText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                767: {
                    items: 3
                },
                991: {
                    items: 2
                },
                1200: {
                    items: 3
                },
                1600: {
                    items: 5
                }
            }
        });
    }

    jQuery(window).on('load', function() {
        setTimeout(function() {
            assignedDoctor();
        }, 1000);
    });

    $(".select2").select2()
</script>

@stack('scripts')
	
</body>
</html>