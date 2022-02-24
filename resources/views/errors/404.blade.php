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

    <title>Erreur 404</title>

    <!-- vendor css -->
    <link href="{{ asset('template/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- template css -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/cassie.css') }}">

</head>

<body class="page-error">

    <div class="error-panel">
        <a href="dashboard-one.html" class="sidebar-logo mg-b-40"><span>Gesmar</span></a>

        <div class="svg-wrapper mg-b-40">
            <object type="image/svg+xml" data="http://themepixels.me/cassie/assets/svg/notfound.svg"></object>
        </div>
        <h1 class="tx-28 tx-sm-36 tx-numeric tx-md-40 tx-semibold">404 Page Introuvable</h1>
        <h4 class="tx-16 tx-sm-18 tx-md-24 tx-light mg-b-20 mg-md-b-30">Oups. La page que vous recherchz n'existe pas.
        </h4>
        <p class="tx-12 tx-sm-13 tx-md-14 tx-color-04">Pour retourner dans l'application <a
                href="{{ url('/') }}">cliquer ici.</a>
        </p>

        {{-- <div class="search-form wd-250 wd-md-400">
            <input type="search" class="form-control" placeholder="Search for page">
            <button class="btn" type="button"><i data-feather="search"></i></button>
        </div><!-- search-form --> --}}
    </div><!-- error-panel -->

    <script src="{{ asset('template/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/lib/feather-icons/feather.min.js') }}"></script>
    <script>
        $(function() {

            'use strict'

            feather.replace();

        })
    </script>
</body>

</html>
