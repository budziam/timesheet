<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }} - {{ config('app.name') }}</title>

    {!! Html::style(source('css/dashboard.css')) !!}

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'url'       => url('/'),
            'lang'      => App::getLocale()
        ]); ?>
    </script>

    {!! Html::style('//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css') !!}
</head>

<body>
<div id="app">
    @include('dashboard.layout.includes.navbar')

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.layout.includes.sidebar')

            <div class="main col-md-9 col-md-offset-3">
                @include('dashboard.includes.breadcrumbs')

                @yield('content')
            </div>
        </div>
    </div>
</div>

{!! Html::script(source('js/dashboard.js')) !!}
</body>
</html>
