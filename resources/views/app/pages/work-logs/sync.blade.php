@extends('app.layout.layout')

@section('content')
    <work-log-sync :data="{{ json_encode($componentData) }}"></work-log-sync>
@endsection