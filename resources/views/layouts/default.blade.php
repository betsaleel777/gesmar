<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials.head')

<body>
    @include('partials.sidebar')
    <div class="content">
        @include('partials.header')
        @yield('content')
    </div>
</body>
@include('partials.script')

</html>
