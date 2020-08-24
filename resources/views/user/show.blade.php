@extends('layouts.app')
@section('title','ユーザー情報')
@section('content')
<link rel="stylesheet" href="{{ asset('/css/font.css') }}">
@if ($user->id == $post->user->id )
<!-- 本人だったら編集画面リンクありを表示させる -->

<div class="topWrapper">
    @if(!empty($post->user->image_path))
    <!-- <td><a href="{{ action('PostsController@edit', ['id' => $post->id]) }}"><img src="{{ asset('storage/image/'.$post->image_path)}}"> </td> -->
    <td><a href="{{ action('UserController@userShow', ['id' => $post->id]) }}"><img src="/storage/user/{{ $post->user->image_path }}" class="editThumbnail"></td></a>
    @else
    画像なし→ここにデフォでuserID1のデフォ画像を表示させる
    @endif
    <div class="profileDate">
        <div class="labelTitle">Name</div>
        <div>
            <td class="userForm">{{ $post->user->name }}</td>
        </div>

        <div class="labelTitle">自己紹介</div>
        @if($errors->has('name'))<div class="error">{{ $errors->first('name') }}</div>@endif
        <div>
            <td class="userForm">{{ $post->user->comment }}</td>
            @if($errors->has('comment'))<div class="error">{{ $errors->first('comment') }}</div>@endif
        </div>

        <div class="buttonSet">
            <div class="btn btn-primary btn-sm" onclick="history.back()">戻る</div>
            <a href="{{ route('user.userEdit') }}" class="btn btn-primary btn-sm">編集</a>
        </div>
    </div>
</div>

@else
<!-- 本人でなければ編集リンクなしを表示させる -->
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


<div class="topWrapper">
    @if(!empty($post->user->image_path))
    <!-- <td><a href="{{ action('PostsController@edit', ['id' => $post->id]) }}"><img src="{{ asset('storage/image/'.$post->image_path)}}"> </td> -->
    <td><a href="{{ action('UserController@userShow', ['id' => $post->id]) }}"><img src="/storage/user/{{ $post->user->image_path }}" class="editThumbnail"></a></td>
    @else
    画像なし→ここにデフォでuserID1のデフォ画像を表示させる
    @endif
    <div class="profileDate">
        <div class="labelTitle">Name</div>
        <div>
            <td class="userForm">{{ $post->user->name }}</td>
        </div>

        <div class="labelTitle">自己紹介</div>
        @if($errors->has('name'))<div class="error">{{ $errors->first('name') }}</div>@endif
        <div>
            <td class="userForm">{{ $post->user->comment }}</td>
            @if($errors->has('comment'))<div class="error">{{ $errors->first('comment') }}</div>@endif
        </div>

        <div class="buttonSet">
            <div class="btn btn-primary btn-sm" onclick="history.back()"></a>戻る</div>
        </div>
    </div>
</div>

@endif
@endsection