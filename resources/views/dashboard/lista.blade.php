@extends('dashboard/layout')
    @section('conteudo')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gestão de Listas</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-exclamation-triangle fa-sm text-white-50"></i> Suporte</a>
        </div>

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
                                        <th class="text-center"><button onclick="geraExcel(this)" data-id="{{ $list->id }}" data-user="{{ Auth::user()->id }}" class="btn btn-success"><i class="fa fa-credit-card text-light"></i></button></th>
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
