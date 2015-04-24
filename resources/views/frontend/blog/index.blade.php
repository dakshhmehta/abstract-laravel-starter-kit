@extends('frontend/layouts/default')

{{-- Page content --}}
@section('content')
@foreach ($posts as $post)
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<!-- Post Title -->
			<div class="panel-heading">
				<h4><strong><a href="{{ $post->url() }}">{{ $post->title }}</a></strong></h4>
			</div>

			<!-- Post Content -->
			<div class="panel-body">
				<div class="col-md-2">
					<a href="{{ $post->url() }}" class="thumbnail"><img src="{{ $post->thumbnail() }}" alt=""></a>
				</div>
				<div class="col-md-6">
					<p>
						{{ Str::limit($post->content, 200) }}
					</p>
					<p><a class="btn btn-mini" href="{{ $post->url() }}">Read more...</a></p>
				</div>
			</div>

			<!-- Post Footer -->
			<div class="panel-footer">
					<i class="icon-user"></i> by <span class="muted">{{ $post->author->first_name }}</span>
					| <i class="icon-calendar"></i> {{ $post->created_at->diffForHumans() }}
					| <i class="icon-comment"></i> <a href="{{ $post->url() }}#comments">{{ $post->comments()->count() }} Comments</a>
			</div>
		</div>
	</div>
</div>

<hr />
@endforeach

{{ $posts->links() }}
@stop
