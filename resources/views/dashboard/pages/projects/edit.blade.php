@extends('dashboard.layout.layout')

@section('content')
    <project-create-edit :project-id="{{ $project->id }}"></project-create-edit>
@stop