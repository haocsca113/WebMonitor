@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>EDIT URL</h1>
@stop

@section('content')
    
@if(isset($website->id))
    <form method="post" action="{{ route('update-url', [$website->id]) }}">
        @csrf
        @method("PATCH")
        <label>URL</label></br>
        <input type="text" name="url" id="url" value="{{ $website->url }}" class="form-control" style="width: 50%;"></br>

        <input type="submit" value="Update" class="btn btn-success"></br>

    </form>
@else
    <p class="card-text">
        <b>No Website</b>
    </p>
@endif

    
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop