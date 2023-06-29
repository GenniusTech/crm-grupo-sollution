@extends('dashboard/layout')
    @section('conteudo')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Perfil</h1>
        </div>

        <!-- Cadastrar CPF/CNPJ -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Meus dados</h6>
                    </div>

                    <div class="card-body">

                        <form id="cadastro" class="user" method="POST" action="{{ route('update') }}">
                            <input type="hidden" value={{  csrf_token() }} name="_token">
                            <div class="row">
                                <div class="col-sm-12 col-lg-8 offset-lg-2 row">

                                    <div class="form-group col-sm-12 col-lg-12">
                                        <input type="text" id="cpfcnpj" class="form-control form-control-user" name="name" placeholder="{{$dados->name}}">
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-6">
                                        <input type="text" id="situacao" class="form-control form-control-user" name="email" placeholder="{{ $dados->email }}">
                                    </div>
                                    <div class="form-group col-sm-12 col-lg-6">
                                        <input type="password" id="senha" class="form-control form-control-user" name="passwordHash" placeholder="*************">

                                    </div>
                                    <div class="form-group col-sm-12 col-lg-4 offset-lg-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-user btn-block"> Atualizar </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <div class="d-flex justify-content-center">
                            <div class="col-md-6">
                                <h1 class="text-center mb-4"><img class="img-profile rounded-circle" style="height:200px;" src="{{ asset(Auth()->user()->perfil) }}"></h1>
                                <form action="{{ route('perfilimg') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="perfil">Foto de perfil</label>
                                        <input id="perfil" type="file" name="perfil" class="form-control-file">
                                        @error('perfil')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </form>
                            </div>
                        </div>


                        <script>
                            window.addEventListener('DOMContentLoaded', function() {
                                // Obtem os elementos dos campos de email e nome
                                var email = document.getElementById('situacao');
                                var name = document.getElementById('cpfcnpj');

                                // Preenche os campos com os valores obtidos de $dados
                                email.value = "{{ $dados->email }}";
                                name.value = "{{ $dados->name }}";
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection
