@extends('kit::backend.layouts.default')

{{-- Web site Title --}}
@section('title')
Group Management ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h3>
		Group Management

		<div class="pull-right">
			<a href="{{ route('create/group') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

{{ $groups->render() }}

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span1">@lang('kit::admin/groups/table.id')</th>
			<th class="span6">@lang('kit::admin/groups/table.name')</th>
			<th class="span2">@lang('kit::admin/groups/table.users')</th>
			<th class="span2">@lang('kit::admin/groups/table.created_at')</th>
			<th class="span2">@lang('kit::table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@if ($groups->count() >= 1)
		@foreach ($groups as $group)
		<tr>
			<td>{{ $group->id }}</td>
			<td>{{ $group->name }}</td>
			<td>{{ $group->users()->count() }}</td>
			<td>{{ $group->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/group', $group->id) }}" class="btn btn-mini">@lang('kit::button.edit')</a>
				<a href="{{ route('delete/group', $group->id) }}" class="btn btn-mini btn-danger">@lang('kit::button.delete')</a>
			</td>
		</tr>
		@endforeach
		@else
		<tr>
			<td colspan="5">No results</td>
		</tr>
		@endif
	</tbody>
</table>

{{ $groups->render() }}
@stop
