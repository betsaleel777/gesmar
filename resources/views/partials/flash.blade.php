@if (session('success'))
    <div class="toast bg-success-light" role="alert" aria-live="assertive" aria-atomic="true"
        style="position: absolute; top: 1%; right: 1%;" data-delay="10000">
        <div class="toast-header">
            <i data-feather="check-circle"></i>
            <strong class="ml-2 mr-auto">Succès</strong>
            {{-- <small class="text-muted">11 mins ago</small> --}}
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {!! session('success') !!}
        </div>
    </div>
@endif
@if (session('error'))
    <div class="toast bg-success-danger" role="alert" aria-live="polite" aria-atomic="true"
        style="position: absolute; top: 1%; right: 1%;" data-delay="10000">
        <div class="toast-header">
            <i data-feather="alert-circle"></i>
            <strong class="mr-auto">Error</strong>
            {{-- <small class="text-muted">11 mins ago</small> --}}
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {!! session('error') !!}
        </div>
    </div>
@endif
@if (session('warning'))
    <div class="toast bg-success-warning" role="alert" aria-live="polite" aria-atomic="true"
        style="position: absolute; top: 1%; right: 1%;" data-delay="10000">
        <div class="toast-header">
            <i data-feather="alert-triangle"></i>
            <strong class="mr-auto">Warning</strong>
            {{-- <small class="text-muted">11 mins ago</small> --}}
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {!! session('warning') !!}
        </div>
    </div>
@endif
@if (session('info'))
    <div class="toast bg-success-info" role="alert" aria-live="polite" aria-atomic="true"
        style="position: absolute; top: 1%; right: 1%;" data-delay="10000">
        <div class="toast-header">
            <i data-feather="bell"></i>
            <strong class="mr-auto">Information</strong>
            {{-- <small class="text-muted">11 mins ago</small> --}}
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {!! session('info') !!}
        </div>
    </div>
@endif
