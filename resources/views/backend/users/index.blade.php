@extends('kit::backend.layouts.default')

{{-- Page title --}}
@section('title')
User Management ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		User Management

		<div class="pull-right">
			<a href="{{ route('create/user') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

<a class="btn btn-medium" href="{{ URL::to('admin/users?withTrashed=true') }}">Include Deleted Users</a>
<a class="btn btn-medium" href="{{ URL::to('admin/users?onlyTrashed=true') }}">Include Only Deleted Users</a>

{{ $users->render() }}

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span1">@lang('kit::admin/users/table.id')</th>
			<th class="span2">@lang('kit::admin/users/table.first_name')</th>
			<th class="span2">@lang('kit::admin/users/table.last_name')</th>
			<th class="span3">@lang('kit::admin/users/table.email')</th>
			<th class="span2">@lang('kit::admin/users/table.activated')</th>
			<th class="span2">@lang('kit::admin/users/table.created_at')</th>
			<th class="span2">@lang('kit::table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
		<tr>
			<td>{{ $user->id }}</td>
			<td>{{ $user->first_name }}</td>
			<td>{{ $user->last_name }}</td>
			<td>{{ $user->email }}</td>
			<td>@lang('kit::general.' . ($user->isActivated() ? 'yes' : 'no'))</td>
			<td>{{ $user->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/user', $user->id) }}" class="btn btn-mini">@lang('kit::button.edit')</a>

				@if ( ! is_null($user->deleted_at))
				<a href="{{ route('restore/user', $user->id) }}" class="btn btn-mini btn-warning">@lang('kit::button.restore')</a>
				@else
				@if (Sentry::getId() !== $user->id)
				<a href="{{ route('delete/user', $user->id) }}" class="btn btn-mini btn-danger">@lang('kit::button.delete')</a>
				@else
				<span class="btn btn-mini btn-danger disabled">@lang('kit::button.delete')</span>
				@endif
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

{{ $users->render() }}
@stop
