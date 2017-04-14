@extends('dashboard.layout.layout')

@section('content')
    <div class="card-table">
        <table class="container bordered highlight">
            <tr>
                <th>@lang('ID')</th>
                <td>{{ $project->id }}</td>
            </tr>

            <tr>
                <th>@lang('Name')</th>
                <td>{{ $project->name }}</td>
            </tr>

            <tr>
                <th>@lang('Created At')</th>
                <td>{{ $project->created_at }}</td>
            </tr>
        </table>
    </div>
@stop