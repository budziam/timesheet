<html>
<body>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    {!! Html::style(source('css/dashboard.css')) !!}

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'url'       => url('/'),
            'lang'      => App::getLocale()
        ]); ?>
    </script>

</head>

<body>
<!-- Fixed navbar -->
<div class="navbar navbar-static navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle toggle-left hidden-md hidden-lg" data-toggle="sidebar"
                    data-target=".sidebar-left">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard.home.index') }}">{{ config('app.name') }}</a>
        </div>
    </div>
</div>
<!-- Begin page content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-7 col-sm-3 col-md-3 sidebar sidebar-left sidebar-animate sidebar-md-show">
            <ul class="nav navbar-stacked">
                <li class="active">
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#about">About</a>
                </li>
                <li>
                    <a href="#contact">Contact</a>
                </li>
            </ul>
        </div>
        <div class="main col-md-9 col-md-offset-3">
            <div class="page-header">
                <h1>Sticky footer with fixed navbar</h1>
            </div>
        </div>
    </div>
</div>

{!! Html::script(source('js/dashboard.js')) !!}
</body>
</html>
