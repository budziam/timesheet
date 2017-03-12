<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button"
                    class="navbar-toggle toggle-left hidden-md hidden-lg"
                    data-toggle="sidebar"
                    data-target=".sidebar-left"
            >
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard.home.index') }}">
                {{ config('app.name') }} - @lang('Dashboard')
            </a>
        </div>
    </div>
</nav>