@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>HOME WEBSITE URL</h1>
@stop

@section('content')
    <a href="{{ route('add-url') }}" class="btn btn-success">ADD URL</a>

    <div class="table-responsive mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Website URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($websites as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->url }}</td>

                        <td>
                            <a href="{{ route('view-url', [($item->id)]) }}" title="View Website">
                                <button class="btn btn-info btn-sm">
                                    <i class="far fa-eye"></i>
                                    View
                                </button>
                            </a>
                            <a href="{{ route('edit-url', [($item->id)]) }}" title="Edit Website">
                                <button class="btn btn-primary btn-sm">
                                    <i class="far fa-edit"></i>
                                    Edit
                                </button>
                            </a>
                            <form method="POST" action="{{ route('delete-url', [($item->id)]) }}" style="display: inline;">
                                @csrf
                                @method("DELETE")
                                
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Contact" onclick="return confirm('Confirm delete?')">
                                    <i class="far fa-trash-alt"></i>
                                    Delete
                                </button>    
                            </form>
                        </td>
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