<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard and Admin Template">
    <meta name="author" content="ThemePixels">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/assets/img/favicon.png') }}">

    <title>Authentification Gesmar</title>

    <!-- vendor css -->
    <link href="{{ asset('template/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- template css -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/cassie.css') }}">
</head>

<body>
    <div class="signin-panel">
        {{-- <svg-to-inline path="http://themepixels.me/cassie/assets/svg/citywalk.svg" class-Name="svg-bg"></svg-to-inline> --}}
        <div class="signin-sidebar">
            <div class="signin-sidebar-body">
                <a href="dashboard-one.html" class="sidebar-logo mg-b-40"><span>Gesmar</span></a>
                <h4 class="signin-title">Bienvenue Dans Digital Market Gesmar</h4>
                <h5 class="signin-subtitle">Prière vous connectez</h5>
                <form method="POST" action="{{ route('connexion') }}">
                    @csrf
                    <div class="signin-form">
                        <div class="form-group">
                            <label>Adresse Email</label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Entrer votre adresse email" value="">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="d-flex justify-content-between">
                                <span>Password</span>
                            </label>
                            <input name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Entrer votre mot de passe" value="">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group d-flex mg-b-0">
                            <center><button class="btn btn-brand-01 btn-uppercase flex-fill">Se connecter</button>
                            </center>
                        </div>
                    </div>
                </form>
            </div><!-- signin-sidebar-body -->
        </div><!-- signin-sidebar -->
    </div><!-- signin-panel -->
    <script src=" {{ asset('template/lib/jquery/jquery.min.js') }}"></script>
    <script src=" {{ asset('template/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src=" {{ asset('template/lib/feather-icons/feather.min.js') }}"></script>
    <script src=" {{ asset('template/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/svg-inline.js') }}"></script>
    <script>
        $(function() {
            'use strict'
            feather.replace();
            new PerfectScrollbar('.signin-sidebar', {
                suppressScrollX: true
            });
        });
    </script>
</body>

</html>
