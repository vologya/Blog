@extends ('layouts.app')

@section ('content')

<div class="col-sm-8 blog-main">

    <div class="blog-post">
        <h2 class="blog-post-title">{{ $post->title }}</h2>
        @can ('update', $post)
            <span class="pull-right">
                <a href="{{ route('posts.edit', $post) }}">Edit</a>
                <a href="{{ route('posts.destroy', $post) }}"
                    onclick="event.preventDefault();
                            document.getElementById('delete-form').submit();">Delete</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" id="delete-form" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
            </span>
        @endcan
        <p class="blog-post-meta">{{ $post->created_at->toDayDateTimeString() }} by <a href="#">{{ $post->author->name }}</a></p>

        {{ $post->body }}

        <p class="blog-post-meta">
            @foreach ( $post->tags as $tag )
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}">
                    <span class="badge">{{ $tag->name }}</span>
                </a>
            @endforeach
        </p>
    </div><!-- /.blog-post -->

</div><!-- /.blog-main -->

@endsection