@extends('dashboard.layout.layout')

@section('content')
    <customer-createedit :model-id="{{ $customer->id }}"></customer-createedit>
@stop