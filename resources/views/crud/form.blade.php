@extends('kit::frontend.layouts.default')

@section('title')
    @if($mode == 'create')
        Create
    @else
        Editing: {{ $item->id }}
    @endif
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        {!! Template::form($mode, "", $form, $errors, $item) !!}
    </div>
</div>
@stop
