<!DOCTYPE html>
<link rel="stylesheet" href="{{ asset('/css/posts.css') }}">
<link rel="stylesheet" href="{{ asset('/css/common.css') }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@extends('layouts.common')
@section('title','EDIT')
@section('contents')
<p class=page-title>EDIT</p>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="{{ action('PostsController@update') }}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group row">
                    <label class="col-md-2" for="title">タイトル</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ $form->title }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2" for="tags">
                        タグ
                    </label>

                    <div class="col-md-10">
                        <div class="form-text text-info">
                            @foreach ($tags as $tag)
                            @if ($form->tags->search(function($selectedTag, $key) use ($tag) {
                            return $selectedTag->id == $tag->id;
                            }) !== false)
                            <label><input type="checkbox" name="tags[]" value="{{ $tag->id }}" checked>{{ $tag->name }}</label>
                            @else
                            <label><input type="checkbox" name="tags[]" value="{{ $tag->id }}">{{ $tag->name }}</label>
                            @endif
                            @endforeach
                            <p>現在のタグ: @foreach ($form->tags as $tag) {{ $tag->name }} {{"\n"}} @endforeach</p>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-10">
                        <input type="hidden" name="id" value="{{ $form->id }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="更新">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection