@extends('layout')
@section('conteudo')

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Primeiro acesso?</h1>
                                    <p class="mb-4">Crie o seu acesso ao Grupo Sollution!</p>
                                </div>
                                @if ($errors->any())
                                <div style="background-color: rgb(136, 16, 20); color:white; text-align: center; border-radius:5px;">
                                    <ul class="alert alert-error">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <form class="user d-none">

                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user"  placeholder="CPF">
                                    </div>
                                    <div class="form-group">
                                        <a href="index.html" class="btn btn-primary btn-user btn-block"> Buscar </a>
                                    </div>

                                    <div id="cadastro" class="d-none">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" placeholder="Enter Email Address...">
                                        </div>
                                    </div>
                                </form>
                                <form class="user" method="POST" action="{{ route('register_action') }}">
                                    <input type="hidden" value={{  csrf_token() }} name="_token">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="name" placeholder="Nome">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" name="cpf" placeholder="CPF">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="Senha">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="indicacao" placeholder="Indicação" value="{{ isset($id) ? $id : '' }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="assas" placeholder="Wallet Assas" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-user btn-block"> Cadastrar-me </button>
                                    </div>

                                    <div id="cadastro" class="d-none">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" placeholder="Enter Email Address...">
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <p><a href="/" class="small">Acessar minha conta.</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection

