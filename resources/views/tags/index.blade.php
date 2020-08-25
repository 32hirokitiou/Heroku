@extends('layouts.common')
@section('contents')
<p class=page-title>SEARCH</p>
<div class="tag-text">
    @foreach ($tags as $tag)
    <label class="tag-info">
        <div class="tags_name" value="{{ $tag->name }}"> <a href="{{ action('TagsController@show', ['tag_id' => $tag->id]) }}">{{ $tag->name }}</div>
    </label>
    @endforeach
</div>
@endsection