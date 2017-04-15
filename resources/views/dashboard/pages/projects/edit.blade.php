@extends('dashboard.layout.layout')

@section('content')
    <project-edit :project-id="{{ $project->id }}"></project-edit>
@stop