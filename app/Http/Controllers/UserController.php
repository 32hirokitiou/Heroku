<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Storage;
// use App\Http\Controllers\Validator
// 下記追加分
use Validator;
use Intervention\Image\ImageManagerStatic as Image;


class UserController extends Controller
{
    public function show(Request $request)
    {
        $post = Post::find($request->id);
        if (empty($post)) {
            abort(404);
        }
        $user = Auth::user();
        return view('user.show', ['post' => $post, 'user' => $user,]);
    }

    public function userShow(Request $request)
    {
        $auth_user = Auth::user();
        $post = Post::find($request->id);
        //requestで受け取ったポストのid情報からPostの情報自体を取得する
        $user = User::find($post->user_id);
        $posts = $user->posts;

        //$userのidを抜き出す
        //$userのidが持っているポストを表示させたい
        //これをwhereを使ってかくべし！
        // $posts = Post::where('user_id', $user->id)->paginate(3);
        //その後そのポスト情報にあるuser_idからユーザーの情報を取得
        // $posts = $user->posts
        //ここで先程のユーザーのポストの情報を$postsにおいている。
        //今回これを取り出したい
        //Requestの中に入っている
        //本人の情報を$userとしてユーザー情報取得
        // ポストのuser_idとログイン中のidが一致しているものを$postsとしておく
        return view('user.userShow', ['posts' => $posts, 'auth_user' => $auth_user,]);
    }


    public function showDetail($id)
    {
        $post = Post::find($id);
        if (is_null($post)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect('posts/show');
        }
        $user = Auth::user();
        return view('posts.showdetail', ['post' => $post, 'user' => $user]);
    }


    //プロフ画像追加
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $users = User::all();
        $param = [
            'authUser' => $authUser,
            'users' => $users
        ];
        return view('user.index', $param);
    }

    public function userEdit(Request $request)
    {
        $authUser = Auth::user();
        $user =  User::all();

        $param = ['authUser' => $authUser, 'user' => $user,];
        return view('user.userEdit', $param);
    }

    public function userUpdate(Request $request)
    {
        // Validator check
        $rules = [
            'name' => 'required|max:20',
            'comment' => 'required|max:20',
        ];

        $messages = [
            'name' => '名前は20文字以内で記入してください',
            'comment.required' => '20文字以内で記入してください。',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('/user/userEdit')
                ->withErrors($validator)
                ->withInput();
        }
        $param = [
            'name' => $request->name,
            'comment' => $request->comment,
        ];
        $uploadfile = $request->image;
        if (!empty($uploadfile)) {
            $path = Storage::disk('s3')->putFile('user', $uploadfile, 'public');
            $param['image_path'] = Storage::disk('s3')->url($path);
        }

        User::where('id', $request->user_id)->update($param);
        return redirect(route('user.userEdit'))->with('success', '保存しました。');
    }
}
