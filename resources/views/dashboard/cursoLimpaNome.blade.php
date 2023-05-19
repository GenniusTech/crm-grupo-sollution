@extends('dashboard/layout')
    @section('conteudo')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Curso: XXXXXXXX</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-exclamation-triangle fa-sm text-white-50"></i> Suporte</a>
        </div>

        <div class="row">

            <div class="col-sm-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Listagem de Aulas</h6>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Módulo</th>
                                        <th>Título</th>
                                        <th>Tempo</th>
                                        <th>Recursos</th>
                                        <th>Assistir</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>.</th>
                                        <th>.</th>
                                        <th>.</th>
                                        <th>.</th>
                                        <th>.</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection
