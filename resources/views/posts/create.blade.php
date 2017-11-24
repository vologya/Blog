@extends('layouts.app')

@section('content')

<div class="col-sm-8">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">New Post</div>

            <div class="panel-body">
                <form method="POST" action="{{ route('posts.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="control-label">{{ ucfirst('title') }}</label>
                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" autofocus>

                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                        <label for="body" class="control-label">Your Thoughts</label>
                        <textarea class="form-control" rows="5" id="body" name="body">{{ old('body') }}</textarea>

                        @if ($errors->has('body'))
                            <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="tags" class="control-label">Tags</label>
                        <select class="form-control" name="tags[]" id="tags" multiple="multiple">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Post
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section ('scripts')

<script>
    $(document).ready(function() {
        $("#tags").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });
    });
</script>

@endsection