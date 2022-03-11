@extends('layouts.default')
@section('content')
    <div class="content-header">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Acceuil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Utilisateurs</a></li>
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
                        <form action="{{ route('admin.user.insert') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row row-sm">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-8">
                                    <div class="custom-file">
                                        <input name="avatar" type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choix de l'avatar</label>
                                    </div>
                                    @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input name="name" type="text" value="{{ old('name') }}"
                                        class="form-control mg-t-10 @error('name') is-invalid @enderror"
                                        placeholder="Votre nom complet">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input value="{{ old('email') }}" name="email" type="email"
                                        class="form-control mg-t-10 @error('email') is-invalid @enderror"
                                        placeholder="Votre adresse email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input name="password" type="password"
                                        class="form-control mg-t-10 @error('password') is-invalid @enderror"
                                        placeholder="Votre mot de passe">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input name="password_confirmation" type="password" class="form-control mg-t-10"
                                        placeholder="Confirmer votre mot de passe">
                                    <input value="{{ old('adresse') }}" name="adresse"
                                        class="form-control @error('adresse') is-invalid @enderror mg-t-10" rows="2"
                                        placeholder="Votre adresse" />
                                    @error('adresse')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <textarea name="description" class="form-control mg-t-10" rows="3"
                                        placeholder="description">{{ old('description') }}</textarea>
                                    <button class="btn btn-primary btn-icon btn-block btn-sm mg-t-10">
                                        <i data-feather="save"></i> valider
                                    </button>
                                </div>
                                <div class="col-sm-2"></div>
                            </div><!-- row -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            'use strict'
            // File Browser
            $('#customFile').on('change', function() {
                var va = $(this).val().split('\\');
                $(this).next().text(va[2]);
            })
        });
    </script>
@endsection
