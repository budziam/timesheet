@extends('app.layout.layout')

@section('content')
    <project-search :data="{{ json_encode($componentData) }}"></project-search>
@endsection