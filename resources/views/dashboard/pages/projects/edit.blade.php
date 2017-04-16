@extends('dashboard.layout.layout')

@section('content')
    <project-createedit :model-id="{{ $project->id }}"></project-createedit>
@stop