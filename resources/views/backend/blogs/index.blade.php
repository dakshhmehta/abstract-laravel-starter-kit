@extends('kit::backend.layouts.default')

{{-- Page title --}}
@section('title')
Blog Management ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Blog Management

		<div class="pull-right">
			<a href="{{ route('create/blog') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

{{ $posts->render() }}

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span6">@lang('kit::admin/blogs/table.title')</th>
			<th class="span2">@lang('kit::admin/blogs/table.comments')</th>
			<th class="span2">@lang('kit::admin/blogs/table.created_at')</th>
			<th class="span2">@lang('kit::table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($posts as $post)
		<tr>
			<td>{{ $post->title }}</td>
			<td>{{ $post->comments()->count() }}</td>
			<td>{{ $post->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/blog', $post->id) }}" class="btn btn-mini">@lang('kit::button.edit')</a>
				<a href="{{ route('delete/blog', $post->id) }}" class="btn btn-mini btn-danger">@lang('kit::button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

{{ $posts->render() }}
@stop
