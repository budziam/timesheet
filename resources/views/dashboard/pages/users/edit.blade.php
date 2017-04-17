@extends('dashboard.layout.layout')

@section('content')
    <user-createedit :model-id="{{ $user->id }}"></user-createedit>
@stop