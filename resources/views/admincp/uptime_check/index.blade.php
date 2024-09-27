@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>HOME UPTIME CHECK</h1>
@stop

@section('content')
    {{-- <button type="submit" class="btn btn-success">Check Url</button> --}}
    <a href="{{ route('check-url') }}" class="btn btn-success">Check Url</a>

    <div class="table-responsive mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Respone Time (ms)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uptime_checks as $item)
                    <tr>
                        <td>{{ $item->url }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->response_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop