@extends('kit::backend.layouts.default')

{{-- Page title --}}
@section('title')
Create a New Blog Post ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Create a New Blog Post

		<div class="pull-right">
			<a href="{{ route('blogs') }}" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

{!! Template::form('addPost', '', [
	'tabs' => ['General', 'Meta Data'],
	'groups' => [
		'General' => [
			[
				'name' => 'title',
				'label' => 'Title',
			],
			[
				'name' => 'slug',
				'label' => 'URL Slug',
			],
			[
				'name' => 'content',
				'label' => 'Content',
				'field' => Form::editor('content', Input::old('content'))
			]
		],
		'Meta Data' => [
			[
				'name' => 'meta-title',
				'label' => 'Meta Title',
			],
			[
				'name' => 'meta-description',
				'label' => 'Meta Description',
			],
			[
				'name' => 'meta-keywords',
				'label' => 'Meta Keywords',
			],
		],
	],
], $errors) !!}

@stop
