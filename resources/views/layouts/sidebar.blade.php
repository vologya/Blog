<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    <div class="sidebar-module sidebar-module-inset">
        <h4>About</h4>
        <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
    </div>
    <div class="sidebar-module">
        <h4>Archives</h4>
        <ol class="list-unstyled">
            @foreach ( $archives as $archive )
                <li>
                    <a href="{{ route('posts.index',
                        ['year' => $archive->year, 'month' => $archive->month]) }}">
                        <div class="col-sm-7">
                            {{ $archive->month }} {{ $archive->year }}
                        </div>
                        <span class="badge">{{ $archive->posts }}</span>
                    </a>
                </li>
            @endforeach
        </ol>
    </div>
    <div class="sidebar-module">
        <h4>Tags</h4>
        <ol class="list-unstyled">
            @foreach ($tags as $tag)
                <li>
                    <a href="{{ route('posts.index', ['tag' => $tag->name]) }}">
                        <div class="col-sm-7">
                            {{ $tag->name }}
                        </div>
                        <span class="badge">{{ $tag->posts_count }}</span>
                    </a>
                </li>
            @endforeach
        </ol>
    </div>
</div><!-- /.blog-sidebar -->