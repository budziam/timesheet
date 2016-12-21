<ul class="nav navbar-nav">
    <li>
        <a href="{{ $projectsUrl }}">Projects</a>
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
            <li>
                <form action="{{ $logoutUrl }}" method="POST">
                    {{ csrf_field() }}

                    <button type="submit" class="btn btn-link btn-logout">Logout</button>
                </form>
            </li>
        </ul>
    </li>
</ul>