@extends('dashboard.layout.layout')

@section('content')
    <statistics-projects initial-project="{{ $projectId }}"></statistics-projects>
@endsection
