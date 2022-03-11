@extends('layouts.default')
@section('css')
    <link href="{{ asset('template/lib/prismjs/themes/prism-tomorrow.css') }}" rel="stylesheet">
    <link href="{{ asset('template/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('template/lib/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="content-header">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Acceuil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
                </ol>
            </nav>
            <h4 class="content-title content-title-xs">{{ $titre }}</h4>
        </div>
    </div><!-- content-header -->
    <div class="content-body">
        <div class="row row-sm">
            <div class="col-sm-2">
                <div class="pd-y-10 pd-x-20">
                    <button id="mailComposeBtn" class="btn btn-block btn-brand-01">Menu</button>
                    <nav class="nav nav-classic flex-column tx-13 mg-t-20">
                        <a href="{{ route('admin.user.index') }}" class="nav-link"><i data-feather="inbox"></i>
                            <span>Utilisateurs</span> <span class="badge">00</span>
                        </a>
                        <a href="" class="nav-link"><i data-feather="monitor"></i> <span>Rôles</span> <span
                                class="badge">00</span>
                        </a>
                        <a href="" class="nav-link"><i data-feather="clock"></i> <span>Permissions</span> <span
                                class="badge">00</span>
                        </a>
                    </nav>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="pd-y-10 pd-x-10">
                    <div class="card">
                        <div class="card-header tx-medium">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-2">
                                    <form action="{{ route('admin.user.add') }}" method="get">
                                        <button class="btn btn-primary btn-icon btn-block btn-sm">
                                            <i data-feather="plus"></i> ajouter
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <form action="{{ route('admin.user.archive') }}" method="get">
                                        <button class="btn btn-primary btn-icon btn-block btn-sm">
                                            <i data-feather="archive"></i> archives
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">Name</th>
                                        <th class="wd-25p">Email</th>
                                        <th class="wd-20p">Statut</th>
                                        <th class="wd-15p">Créer le</th>
                                        <th class="wd-20p">Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><span class="badge badge-primary">{{ $user->status }}</span></td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <a href="#modal{{ $user->id }}" data-toggle="modal">
                                                            <i width="18px" heigth="18px" data-feather="rotate-cw"></i></a>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modal{{ $user->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title" id="exampleModalLabel">
                                                                    Confirmation
                                                                    de restauration
                                                                </h6>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"><i data-feather="x"></i></span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="mg-b-0">Voulez vous réelement restauré
                                                                    l'utilisateur {{ $user->name }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="{{ route('admin.user.restore', $user->id) }}"
                                                                    class="btn btn-success">Restaurer</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('template/lib/prismjs/prism.js') }}"></script>
    <script src="{{ asset('template/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/lib/select2/js/select2.min.js') }}"></script>
    <script>
        $(function() {
            'use strict'

            $('#example1').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });
            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });

        });
    </script>
@endsection
