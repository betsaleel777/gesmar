<div class="pd-y-10 pd-x-20">
    <button id="mailComposeBtn" class="btn btn-block btn-brand-01">Menu</button>
    <nav class="nav nav-classic flex-column tx-13 mg-t-20">
        <a href="{{ route('admin.user.index') }}"
            class="nav-link {{ strpos(Route::currentRouteName(), 'admin.user.index') === 0 ? 'active' : '' }}"><i
                data-feather="inbox"></i>
            <span>Utilisateurs</span> <span class="badge">00</span>
        </a>
        <a href="{{ route('admin.role.index') }}"
            class="nav-link {{ strpos(Route::currentRouteName(), 'admin.role.index') === 0 ? 'active' : '' }}"><i
                data-feather="monitor"></i>
            <span>Rôles</span> <span class="badge">00</span>
        </a>
        <a href="{{ route('admin.permission.index') }}"
            class="nav-link {{ strpos(Route::currentRouteName(), 'admin.permission.index') === 0 ? 'active' : '' }}"><i
                data-feather="clock"></i>
            <span>Permissions</span> <span class="badge">00</span>
        </a>
    </nav>
</div>
