@extends('dashboard/layout')
    @section('conteudo')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-comments fa-sm text-white-50"></i> Suporte</a>
        </div>

        <!-- Relatórios -->
        <div class="row">

            <!-- Vendas -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Vendas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carteira
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Carteira</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">R$ 215,00</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->

            <!-- Meta -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Meta
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$percent}}%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{  $percent }}%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Atendimentos -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Atendimentos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Minha lista -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Minha Lista: @foreach($listname as $titulo)
                            {{ $titulo }}
                        @endforeach
                        </h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-info-circle fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Opções:</div>
                                <a class="dropdown-item" href="/cpfcnpj">Cadastrar CPF</a>
                                <a class="dropdown-item" href="/cpfcnpj">Cadastrar CNPJ</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Cliente</th>
                                        <th>CPF/CNPJ</th>
                                        <th>Situação</th>
                                        <th>Status</th>
                                        <th class="text-center">Gerar/Copiar link de Pagamento</th>
                                    </tr>
                                </thead>
                                @foreach ($sales as  $key =>$sale )
                                     <tbody>
                                    <tr>
                                        <td>{{  $key + 1 }}</td>
                                        <td>{{  $sale->cliente  }}</td>
                                        <td>{{  $sale->cpfcnpj  }}</td>
                                        <td>{{  $sale->situacao  }}</td>
                                        <td>
                                            @switch($sale->status)
                                                @case('PENDING')
                                                    Pendente
                                                    @break
                                                @case('PENDING_PAY')
                                                    Aguardando pagamento
                                                    @break
                                                @case('PAYMENT_RECEIVED')
                                                    Aprovado
                                                    @break
                                                @case('PAYMENT_CONFIRMED')
                                                    Aprovado
                                                    @break
                                                @default
                                                    Situação não identificada!
                                            @endswitch
                                        </td>
                                        @if(!empty($sale->link_pay))
                                            <td class="text-center"><button class="btn btn-info" type="button" onclick="copiaLink(this)" data-link="{{$sale->link_pay}}"><i class="fa fa-copy"></i></button></td>
                                        @else
                                            <td class="text-center"><button class="btn btn-success" type="button" onclick="geraPagamento(this)" data-id="{{$sale->id}}" data-name="{{$sale->cliente}}" data-cpfcnpj="{{$sale->cpfcnpj}}"><i class="fa fa-credit-card"></i></button></td>
                                        @endif

                                    </tr>
                                </tbody>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->profile === 'admin')
        <!-- Meus usuários -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Colaboradores</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-info-circle fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Opções:</div>
                                <a class="dropdown-item" href="/lista">Gerenciar notificações</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Colaborador</th>
                                        <th>Acesso</th>
                                    </tr>
                                </thead>
                                @foreach ($users as $user)
                                <tfoot>
                                    <tr>
                                        <th>{{ $user->id }}</th>
                                        <th>{{ $user->name }}</th>
                                        <th>{{ $user->profile }}</th>
                                    </tr>
                                </tfoot>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



    </div>
    @endsection
