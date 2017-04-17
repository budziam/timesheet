@extends('dashboard.layout.layout')

@section('content')
    <user-change-password :user-id="{{ $user->id }}"></user-change-password>
@stop