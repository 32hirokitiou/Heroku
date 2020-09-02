@extends('layouts.common')
@section('contents')
<a href="{{ action('PostsController@add') }}" role="button" class="btn btn-primary">新規作成</a>

<div id="cardlayout-wrap-detail">

    <section class="card-list">
        <a class="card-link">
            <figure class="card-figure"><a href="{{ action('PostsController@edit', ['id' => $post->id]) }}"><img src="{{ $post->image_path }}"></figure>
            <h2 class="card-title">{{ \Str::limit($post->title, 100) }}</h2>
        </a>
        <div>
            <a href="{{ action('PostsController@edit', ['id' => $post->id]) }}">編集</a>
        </div>
        <div>
            <a href="{{ action('PostsController@delete', ['id' => $post->id]) }}">削除</a>
        </div>
        <div class="form-text text-info">
            現在選択中のタグ: @foreach ($post->tags as $tag) {{ $tag->name }} {{"\n"}} @endforeach
        </div>
    </section>
</div>
@endsection