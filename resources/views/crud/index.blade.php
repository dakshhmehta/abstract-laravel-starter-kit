@extends('kit::frontend.layouts.default')

@section('title')
List
@stop

@section('content')
<div class="page-header">
    <h1>List</h1>
</div>
<div class="row">
    <div class="container">
        <div class="col-md-12">
            <table class="table table-stripped">
                <thead>
                @foreach($columns as $column)
                    <th>{{ $column }}</th>
                @endforeach
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                    @foreach($columns as $column)
                        <td>{{ $item->{$column} }}</td>
                    @endforeach
                        <td><a href="{{ Request::url().'/edit/'.$item->id }}">Edit</a></td>
                        <td><a href="{{ Request::url().'/delete/'.$item->id }}">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
</div>
@stop
