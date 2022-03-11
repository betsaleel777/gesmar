<script src=" {{ asset('template/lib/jquery/jquery.min.js') }}"></script>
<script src=" {{ asset('template/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src=" {{ asset('template/lib/feather-icons/feather.min.js') }}"></script>
<script src=" {{ asset('template/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src=" {{ asset('template/lib/js-cookie/js.cookie.js') }}"></script>
@yield('scripts')
<script src=" {{ asset('template/assets/js/cassie.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.toast').toast('show');
    });
</script>
