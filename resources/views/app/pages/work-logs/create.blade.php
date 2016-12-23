@extends('app.layout.layout')

@section('content')
    <work-log-create :data="{{ json_encode($componentData) }}"></work-log-create>
@endsection