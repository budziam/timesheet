@extends('dashboard.layout.layout')

@section('content')
    <project-group-createedit :model-id="{{ $projectGroup->id }}"></project-group-createedit>
@stop