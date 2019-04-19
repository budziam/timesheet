@extends('dashboard.layout.layout')

@section('content')
    <statistics-projects initial-project-id="{{ $projectId }}"
                         initial-project-name="{{ $projectName }}"
    ></statistics-projects>
@endsection
