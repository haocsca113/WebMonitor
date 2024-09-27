@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>HOME ATTACK DETECTED</h1>
@stop

@section('content')
    <a href="{{ route('check-url-attack-detected') }}" class="btn btn-success">Check Url</a>

    <div class="table-responsive mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Website</th>
                    <th>Acctack Type</th>
                    <th>Detected At</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attacks_detected as $item)
                    <tr>
                        <td>{{ $item->website_id }}</td>
                        <td>{{ $item->attack_type }}</td>
                        <td>{{ $item->detected_at }}</td>
                        <td>{{ $item->details }}</td>
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