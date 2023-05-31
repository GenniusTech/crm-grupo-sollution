@extends('dashboard/layout')
    @section('conteudo')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gestão de Listas</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-exclamation-triangle fa-sm text-white-50"></i> Suporte</a>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
 @endif
        <div class="row">
            @if (Auth::user()->profile === 'admin')
            <!-- /start Administrador -->
            <div class="col-sm-12 col-lg-6">
                <div class="card shadow mb-4">
                    <a href="#collapseCardLista" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Cadastro de Lista</h6>
                    </a>

                    <div class="collapse" id="collapseCardLista">
                        <div class="card-body">
                            <form id="cadastro" class="user" method="POST" action="{{ route('cadastroList') }}">
                                <input type="hidden" value={{  csrf_token() }} name="_token">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12 row">

                                        <div class="form-group col-sm-12 col-lg-12">
                                            <input type="text" id="titulo" class="form-control form-control-user" name="titulo" placeholder="Título da Lista">
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <input type="date" id="dataInicial" class="form-control form-control-user" name="dataInicial" placeholder="Data Inicial">
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <input type="date" id="dataFinal" class="form-control form-control-user" name="dataFinal" placeholder="Data Final">
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-4 offset-lg-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-user btn-block"> Cadastrar </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (Auth::user()->profile === 'admin')
            <div class="col-sm-12 col-lg-6">
                <div class="card shadow mb-4">
                    <a href="#collapseCardNotification" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Gerar noficações</h6>
                    </a>

                    <div class="collapse" id="collapseCardNotification">
                        <div class="card-body">
                            <form id="cadastro" class="user" method="POST" action="{{ route('cadastroNotficacao') }}">
                                <input type="hidden" value={{  csrf_token() }} name="_token">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12 row">
                                        <div class="form-group col-sm-12 col-lg-12">
                                            <input type="text" id="titulo" class="form-control form-control-user" name="mensagem" placeholder="Mensagem">
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-12">
                                            <select class="form-control" name="tipo">
                                                <option value="0">Todos</option>
                                                @foreach ($userlist as $userslist )

                                                <option value="{{ $userslist->id }}">{{ $userslist->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-4 offset-lg-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-user btn-block"> Enviar </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /end administrador -->
            @if (Auth::user()->consulta_p === '1')
            <div class="col-sm-12 col-lg-12">
                <div class="card shadow mb-4">
                    <a href="#collapseCardConsulta" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Gerar Consultas</h6>
                    </a>

                    <div class="collapse show" id="collapseCardConsulta">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Cliente</th>
                                            <th>CPF</th>
                                            <th class="text-center">Adc Documento</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        @foreach ($sales as $key => $sale)
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <th>{{ $sale->cliente }}</th>
                                            <th>{{ $sale->cpfcnpj }}</th>    <!--$sale->id-->
                                            <th class="text-center">
                                                <button value="{{ $sale->id }}" class="btn btn-success" type="button" data-toggle="modal" data-target="#logoutModal{{ $sale->id }}">
                                                    <i class="fa fa-file"></i>
                                                </button>

                                                <div class="modal fade" id="logoutModal{{ $sale->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Realizar consulta.</h5>
                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <form class="user" method="POST"  enctype="multipart/form-data" action="{{ route('GerarConsultas',['id'=> $sale->id]) }}">
                                                                <input type="hidden" value={{  csrf_token() }} name="_token">
                                                            <div class="modal-body">
                                                                <p>Anexe ao Input abaixo o PDF da Consulta</p>
                                                                    <div class="form-group">
                                                                        <input type="file" class="form-control form-control-user" name="file" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <p class="text-danger">Atente-se para realizar a consulta corretamente!</p>
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-success" type="submit">Solicitar</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </th>
                                        </tr>
                                        @endforeach
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif

            @endif
            <div class="col-sm-12 col-lg-12">
                @if(session('mensagem'))
                <div class="alert alert-warning">
                    {{ session('mensagem') }}
                </div>
            @endif

                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Listagem de Listas</h6>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Título</th>
                                        <th>Início/Fim</th>
                                        <th class="text-center">Vendas</th>
                                        <th class="text-center">Contratos</th>
                                        <th class="text-center">Opções</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    @foreach ($lists as $key => $list)
                                    <tr>
                                        <th>{{ $key + 1 }}</th>
                                        <th>{{ $list->titulo }}</th>
                                        <th>{{ $list->dataInicial }} <br> {{ $list->dataFinal }}</th>
                                        <th class="text-center"><a href="{{ route('sales.export', ['id_lista' => $list->id]) }}" ><button class="btn btn-primary"><i class="fa fa-credit-card text-light"></i></button></a></th>
                                        <th class="text-center"><button class="btn btn-primary"><i class="fa fa-file text-light"></i></button></th>

                                        <th class="text-center">
                                            @if (Auth::user()->profile === 'admin')
                                            <form action="{{ route('ativar-lista', $list->id) }}" method="POST">
                                                @if($list->status != 1)
                                                @csrf
                                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button><!--botão check-->
                                                @endif
                                            </form>
                                            @endif
                                        </th>

                                    </tr>
                                    @endforeach
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection
