@extends('dashboard.layout.layout')

@section('content')
    <project-index :data="{{ json_encode($componentData) }}"></project-index>
@endsection