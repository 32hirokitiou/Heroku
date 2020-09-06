@extends('layouts.common')
@section('title','PROFILE')
@section('contents')
<link rel="stylesheet" href="{{ asset('/css/font.css') }}">


<p class=page-title>PROFILE</p>
@if ($authuser->id == $user->id )

<!-- 本人だったら編集画面リンクありを表示させる -->
<div class="topWrapper">

    <td>
        <a href="{{ action('UserController@userShow', ['id' => $user->id]) }}">
            <img src="{{ $user->image_path }}" class="editThumbnail">
        </a>
    </td>

    <div class="profileDate">
        <div class="labelTitle">Name</div>
        <div>
            <td class="userForm">{{ $user->name }}</td>
        </div>

        <div class="labelTitle">自己紹介</div>
        @if($errors->has('name'))<div class="error">{{ $errors->first('name') }}</div>@endif
        <div>
            <td class="userForm">{{ $user->comment }}</td>
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
    <td>
        <a href="{{ action('UserController@userShow', ['id' => $user->id]) }}">
            <img src="{{ $user->image_path }}" class="editThumbnail">
        </a>
    </td>

    <div class="profileDate">
        <div class="labelTitle">名前</div>
        <div>
            <td class="userForm">{{ $user->name }}</td>
        </div>

        <div class="labelTitle">自己紹介</div>
        @if($errors->has('name'))
        <div class="error">{{ $errors->first('name') }}</div>
        @endif
        <div>
            <td class="userForm">{{ $user->comment }}</td>
            @if($errors->has('comment'))
            <div class="error">
                {{ $errors->first('comment') }}
            </div>
            @endif
        </div>

        <div class="buttonSet">
            <div class="btn btn-primary btn-sm" onclick="history.back()"></a>戻る</div>
        </div>
    </div>
</div>

@endif
@endsection