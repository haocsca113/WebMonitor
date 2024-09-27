@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>CHECK URL</h1>
@stop

@section('content')
    <form action="{{ route('check-up-time') }}" method="POST">
        @csrf
        <label for="url">Enter URL:</label>
        <input type="text" id="url" name="url" required>
        <button type="submit" class="btn btn-success">Check</button>
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop