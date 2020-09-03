<!DOCTYPE html>
<link rel="stylesheet" href="{{ asset('/css/posts.css') }}">
<link rel="stylesheet" href="{{ asset('/css/common.css') }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@extends('layouts.common')

@section('title','INDEX')
@section('contents')
<p class=page-title>HOME</p>
<div id="cardlayout-wrap">
    @foreach($posts as $post)
    <section class="card-list">
        <a class="card-link">
            <figure class="card-figure">
                <a href="/posts/{{ $post->id }}"><img src="{{ $post->image_path }}"></a>
            </figure>
            <h2 class="card-title">{{ \Str::limit($post->title, 100) }}</h2>
            <h2 class="card-title">
                @if ($auth_user->id != $post->user->id)
                @if ($auth_user->is_favorite($post->id))
                {!! Form::open(['route' => ['favorites.unfavorite', $post->id], 'method' => 'delete']) !!}
                {!! Form::submit('REMOVE FAVORITE', ['class' => "button btn btn-warning"]) !!}
                {!! Form::close() !!}
                @else
                {!! Form::open(['route' => ['favorites.favorite', $post->id]]) !!}
                {!! Form::submit('FAVORITE', ['class' => "button btn btn-success"]) !!}
                {!! Form::close() !!}
                @endif
                @else
                <p class="myitem-name">MyITEM</p>
                @endif

            </h2>
            <p class="card-text-tax"><a href="{{ action('UserController@show', ['post' => $post]) }}"> <img src="{{ $post->user->image_path }}" method="post" class="thumbnail"></a></p>
            <h2 class="created_at">{{ $post->created_at->format('Y/m/d') }}</h2>
        </a>

    </section>
    @endforeach
</div>
@endsection