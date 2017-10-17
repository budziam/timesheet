<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }}</title>

    {!! Html::style(mix('css/app.css')) !!}

    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
                'url'       => url('/'),
                'lang'      => App::getLocale()
        ]); ?>
    </script>
</head>

<body>
<div id="app">
    @include('app.layout.includes.navbar')

    @yield('content')

    <loader></loader>
</div>

{!! Html::script(mix('js/app.js') . '?v=2') !!}
</body>
</html>
