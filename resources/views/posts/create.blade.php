@extends('layouts.common')
@section('title','NEW POST')
@section('contents')
<p class=page-title>POST</p>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="{{ action('PostsController@create') }}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                <ul class=>
                    @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group row">
                    <label class="col-md-2" for="title">TITLE</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2" for="image">PHOTO</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="image">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2" for="tags">
                        TAG
                    </label>


                    <label class="col-md-10">
                        <div class="form-text text-info">
                            @foreach ($tags as $tag)

                            <label><input type="checkbox" class="tagname" name="tags[]" value="{{ $tag->id }}">{{ $tag->name }}</label>

                            @endforeach
                        </div>
                    </label>


                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="POST!">
            </form>
        </div>
    </div>
</div>
@endsection