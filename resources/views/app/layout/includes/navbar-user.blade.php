<ul class="nav navbar-nav">
    <li class="{{ $navbar->check('projects') }}">
        <a href="{{ route('app.projects.index') }}">@lang('Projects')</a>
    </li>
    <li class="{{ $navbar->check('work-logs.sync') }}">
        <a href="{{ route('app.work-logs.sync') }}">@lang('Manage work logs')</a>
    </li>
</ul>

<ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#"
           role="button"
           class="dropdown-toggle"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false"
        >
            {{ $user->name }}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            @can('enter', 'dashboard')
            <li>
                <a href="{{ route('dashboard.home.index') }}">@lang('Dashboard')</a>
            </li>
            @endcan
            <li>
                <form action="{{ route('auth.logout') }}" method="POST">
                    {{ csrf_field() }}

                    <button type="submit" class="btn btn-link btn-logout">@lang('Logout')</button>
                </form>
            </li>
        </ul>
    </li>
</ul>
