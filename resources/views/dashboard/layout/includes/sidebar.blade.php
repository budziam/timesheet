<div class="col-xs-7 col-sm-3 col-md-3 sidebar sidebar-left sidebar-animate sidebar-md-show">
    <ul class="nav navbar-user">
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
                <li>
                    <a href="{{ route('app.home.index') }}">@lang('Application')</a>
                </li>
                <li>
                    <form action="{{ route('auth.logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-link btn-logout">@lang('Logout')</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>

    <ul class="nav navbar-sidebar">
        <li class="{{ $navbar->check('homepage') }}">
            <a href="{{ route('dashboard.home.index') }}">@lang('Homepage')</a>
        </li>
        <li class="{{ $navbar->check('projects') }}">
            <a href="{{ route('dashboard.projects.index') }}">@lang('Projects')</a>
        </li>
        <li class="{{ $navbar->check('project-groups') }}">
            <a href="{{ route('dashboard.project-groups.index') }}">@lang('Project groups')</a>
        </li>
        <li class="{{ $navbar->check('work-logs') }}">
            <a href="{{ route('dashboard.work-logs.index') }}">@lang('Work logs')</a>
        </li>
        <li class="{{ $navbar->check('users') }}">
            <a href="{{ route('dashboard.users.index') }}">@lang('Users')</a>
        </li>
    </ul>
</div>