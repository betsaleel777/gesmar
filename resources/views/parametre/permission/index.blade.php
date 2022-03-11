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
                    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                </ol>
            </nav>
            <h4 class="content-title content-title-xs">{{ $titre }}</h4>
        </div>
    </div><!-- content-header -->
    <div class="content-body">
        <div class="row row-sm">
            <div class="col-sm-2">
                @include('parametre.partials.menu')
            </div>
            <div class="col-sm-10">
                <div class="pd-y-10 pd-x-10">
                    <div class="card">
                        <div class="card-header tx-medium">
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">Nom</th>
                                        <th class="wd-15p">Créer le</th>
                                        {{-- <th class="wd-20p">Option</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->created_at }}</td>
                                            {{-- <td>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <a href="{{ route('admin.permission.show', $permission->id) }}">
                                                            <i width="18px" heigth="18px" data-feather="eye"></i></a>
                                                    </div>
                                                </div>
                                            </td> --}}
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
