@extends('dashboard.layout.layout')

@section('content')
    <table class="table table-hover">
        <tr>
            <th>@lang('ID')</th>
            <td>{{ $project->id }}</td>
        </tr>

        <tr>
            <th>@lang('Name')</th>
            <td>{{ $project->name }}</td>
        </tr>

        <tr>
            <th>@lang('Description')</th>
            <td>{{ $project->description }}</td>
        </tr>

        <tr>
            <th>@lang('End date')</th>
            <td>{{ $project->ends_at }}</td>
        </tr>

        <tr>
            <th>@lang('Created at')</th>
            <td>{{ $project->created_at }}</td>
        </tr>
    </table>
@stop