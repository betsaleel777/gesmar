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
                    <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Rôles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Créer</li>
                </ol>
            </nav>
            <h4 class="content-title content-title-xs">{{ $titre }}</h4>
        </div>
    </div><!-- content-header -->
    <div class="row row-xs">
        <div class="col-sm-12">
            <div class="pd-y-10 pd-x-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.role.insert') }}" method="post">
                            @csrf
                            <div class="row row-sm">
                                <div class="col-sm-6">
                                    <input name="name" type="text" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Nom du rôle">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-icon btn-sm btn-block">
                                        <i data-feather="save"></i> valider
                                    </button>
                                </div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-10 mg-t-10">
                                    <table id="example1" class="table">
                                        <thead>
                                            <tr>
                                                <th class="wd-5p"></th>
                                                <th class="wd-30p">Nom</th>
                                                <th class="wd-10p">Créer le</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                                <tr>
                                                    <td>
                                                        <input name="permissions[]" type="checkbox"
                                                            class="custom-control-input">
                                                    </td>
                                                    <td>{{ $permission->name }}</td>
                                                    <td>{{ $permission->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-1"></div>
                            </div><!-- row -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
