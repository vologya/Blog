@extends ('layouts.app')

@section ('content')

<div class="col-sm-8 blog-main">

    @foreach ( $posts as $post )
        <div class="blog-post">
            <h2 class="blog-post-title"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
            <p class="blog-post-meta">{{ $post->created_at->toDayDateTimeString() }} by <a href="#">{{ $post->author->name }}</a></p>

            {{ $post->body }}
        </div><!-- /.blog-post -->
    @endforeach

    {{ $posts->links() }}

</div><!-- /.blog-main -->

@endsection