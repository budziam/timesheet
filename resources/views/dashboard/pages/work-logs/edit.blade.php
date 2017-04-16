@extends('dashboard.layout.layout')

@section('content')
    <work-log-createedit :model-id="{{ $workLog->id }}"></work-log-createedit>
@stop