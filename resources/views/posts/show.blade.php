@extends('layouts.common')
@section('title','MYITEM')
@section('contents')
<p class=page-title>MYITEMS</p>

<div id="cardlayout-wrap">
    @foreach($posts as $post)
    <section class="card-list">
        <a class="card-link">
            <figure class="card-figure">
                <a href="/posts/{{ $post->id }}"><img src="{{ $post->image_path }}"></a>
            </figure>
            <h2 class="card-title">{{ \Str::limit($post->title, 100) }}</h2>
            <div class="form-texta">
                @foreach ($post->tags as $tag)
                <a value="{{ $tag->name }}" class="tag-names"><a href="{{ action('TagsController@show', ['tag_id' => $tag->id]) }}">{{ $tag->name }}</a>
                    @endforeach
                    <p class="card-text-tax"><a href="{{ action('UserController@show', ['post' => $post]) }}"> <img src="{{ $post->user->image_path }}" method="post" class="thumbnail"></p>
                </a>
                <h2 class="created_at">{{ $post->created_at->format('Y/m/d') }}</h2>
        </a>
    </section>
    @endforeach
</div>
<p>{{ $posts->links() }}</p>
@endsection