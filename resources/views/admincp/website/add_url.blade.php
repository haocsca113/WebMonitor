@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>ADD URL</h1>
@stop

@section('content')
    
<form method="post" action="{{ route('add-url-store') }}">
    @csrf
    <label>URL</label></br>
    <input type="text" name="url" id="url" class="form-control" style="width: 50%;"></br>

    <input type="submit" value="Save" class="btn btn-success"></br>
</form>
    
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop