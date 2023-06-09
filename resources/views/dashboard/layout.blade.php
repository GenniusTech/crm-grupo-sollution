<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CRM - Grupo Sollution</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>

</head>
<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-text mx-3">Grupo Sollution</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="/dashboard"> <i class="fas fa-fw fa-chart-area"></i> <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Canais
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-phone"></i>
                    <span>Atendimento</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" target="_blank" href="https://crm.gruposollution.com.br/login">Bot WhatsApp</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Negócios
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Limpa Nome</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/lista">Listas</a>
                        <a class="collapse-item" href="/cpfcnpj">Cadastrar CPF/CNPJ</a>
                        <a class="collapse-item" onclick="geraIndicacao('{{  Auth::user()->codigo}}')">Indicação</a>
                        <a class="collapse-item" href="/cursoLimpaNome">Curso</a>
                    </div>
                </div>
            </li>

            <!--<hr class="sidebar-divider">

            <div class="sidebar-heading">
                Financeiro
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinancas"
                    aria-expanded="true" aria-controls="collapseFinancas">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Minhas Finanças</span>
                </a>
                <div id="collapseFinancas" class="collapse" aria-labelledby="headingFinancas" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/wallet">Minha Carteira</a>
                        {{-- <a class="collapse-item" href="/indicacao">Indicação</a> --}}
                    </div>
                </div>
            </li> -->

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <p>Olá, {{  Auth::user()->name}}. Bem-vindo(a)!</p>
                    </div>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>

                                <span class="badge badge-danger badge-counter">
                                    {{ count($notfic) }}+
                                    </span>
                            </a>

                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notificações
                                </h6>

                             @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                             @endif

                            @foreach ($notfic as $notfi)
                                <form action="{{ route('notificacao.destroy', $notfi->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="this.closest('form').submit()">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">{{ $notfi->data}}</div>
                                            <span class="font-weight-bold">{{ $notfi->mensagem}}</span>
                                        </div>
                                    </a>
                                </form>
                            @endforeach

                                <a class="dropdown-item text-center small text-gray-500" href="#">Não há mais nada.</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> {{  Auth::user()->name}}</span>
                                <img class="img-profile rounded-circle" src="{{ Auth()->user()->perfil ? asset(Auth()->user()->perfil) : Storage::url('public/profiles/perfil.png') }}">


                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('perfil') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                @yield('conteudo')

                </div>

                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Grupo Sollution</span>
                        </div>
                    </div>
                </footer>

            </div>

        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('admin/js/pesquisa.js') }}"></script>
    <script src="{{ asset('admin/js/geraPdf.js') }}"></script>

</body>

</html>
