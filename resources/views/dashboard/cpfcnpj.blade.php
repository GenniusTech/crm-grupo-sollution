@extends('dashboard/layout')
    @section('conteudo')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cadastado de Cliente</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-exclamation-triangle fa-sm text-white-50"></i> Suporte</a>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-12">

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

            <div class="col-12">
                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Cliente participante da Lista: {{ $listaAtiva->titulo }}</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-info-circle fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Opções:</div>
                                <a class="dropdown-item" onclick="criarFichaAssociativa()" href="#">Gerar Ficha Associativa</a>
                                <a class="dropdown-item" href="#">Gerar Contrato</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form id="pesquisa" class="user">
                            <div class="row">
                                <div class="col-sm-12 col-lg-4 offset-lg-2">
                                    <div class="form-group">
                                        <input type="number" name="cpfcnpj" class="form-control form-control-user" placeholder="CPF/CNPJ">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-2">
                                    <div class="form-group">
                                        <input type="date" name="dataNascimento" class="form-control form-control-user">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-2">
                                    <div class="form-group">
                                        <button type="button" onclick="pesquisaCPFCNPJ()" class="btn btn-primary btn-user btn-block"> Pesquisar </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form id="cadastro" class="user d-none"method="POST"  enctype="multipart/form-data" action="{{ route('cadastroCpfCnpj') }}">
                            <input type="hidden" value={{  csrf_token() }} name="_token">
                            <div class="row">
                                <div class="col-sm-12 col-lg-8 offset-lg-2 row">

                                    <div class="form-group col-sm-12 col-lg-4">
                                        <input type="number" id="cpfcnpj" class="form-control form-control-user" name="cpfcnpj" placeholder="CPF/CNPJ" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-4">
                                        <input type="text" id="situacao" class="form-control form-control-user" name="situacao" placeholder="Situação" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-4">
                                        <input type="text" id="dataNascimento" class="form-control form-control-user" name="dataNascimento" placeholder="Data de Nascimento" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-12">
                                        <input type="text" id="cliente" class="form-control form-control-user" name="cliente" placeholder="Cliente" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-6">
                                        <input type="email" id="email" class="form-control form-control-user" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-6">
                                        <input type="number" id="telefone" class="form-control form-control-user" name="telefone" placeholder="Telefone">
                                    </div>

                                    <div class="form-group col-sm-12 col-lg-6">
                                        <input type="number" onblur="consultarEndereco()" id="cep" class="form-control form-control-user" name="cep" placeholder="CEP">
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-6">
                                        <input type="text" id="cidade" class="form-control form-control-user" name="cidade" placeholder="Cidade" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-10">
                                        <input type="text" id="endereco" class="form-control form-control-user" name="endereco" placeholder="Endereço" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-2">
                                        <input type="text" id="num" class="form-control form-control-user" name="num" placeholder="N°">
                                    </div>

                                    {{-- <div class="form-group col-sm-12 col-lg-12">
                                        <input type="file" style="padding:5px;" class="form-control form-control-user" name="file" required>
                                    </div> --}}
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

    </div>
    @endsection
