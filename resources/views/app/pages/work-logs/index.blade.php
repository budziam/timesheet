@extends('app.layout.layout')

@section('content')
    <work-log-index :data="{{ json_encode($componentData) }}"></work-log-index>
@endsection