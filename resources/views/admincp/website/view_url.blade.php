@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>VIEW WEBSITE URL</h1>
@stop

@section('content')
    

    @if(isset($website->id))
        <p class="card-text"><b>Website URL:</b> 
            {{$website->url}}
        </p>
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