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
        //ここでクリックした写真の情報をuser/showに渡したい
        //
        $user = Auth::user();

        return view('user.show', ['post' => $post, 'user' => $user,]);
    }

    public function userShow(Request $request)
    {
        // $user = User::find($request->user_id);
        // $auth_user = Auth::user();
        // dd($user);
        // return view('posts.userShow', ['user' => $user, 'auth_user' => $auth_user,'user' => $user,]);

        //これが実装予定のもの
        $post = Post::find($request->id);
        //requestで受け取ったポストのid情報からPostの情報自体を取得する
        $user = User::find($post->user_id);
        //その後そのポスト情報にあるuser_idからユーザーの情報を取得
        $posts = $user->posts;
        $auth_user = Auth::user();
        //そこからユーザーに紐づいているpostsを取得しuserShowに$postsとして送る
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


    public function edit(Request $request)
    {
        $user = Auth::user();   #ログインユーザー情報を取得します。
        return view('user/edit', ['user_form' => $user]);
    }

    public function update(Request $request)
    {
        $this->validate($request, User::$rules);
        $user = Auth::user();
        // id?で全ての情報を引っ張ってこれているのか？
        // 送信されてきたフォームデータを格納する
        $user_form = $request->all();
        unset($user_form['_token']);
        // 該当するデータを上書きして保存する
        $user->fill($user_form)->save();
        //  return redirect('admin/news');
        return redirect('user/show');
    }

    //画像追加
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
        //'user' => $user,も追加分
        //デフォ追加分
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
        //dd確認済み。トークンいらない
        if ($validator->fails()) {
            return redirect('/user/userEdit')
                ->withErrors($validator)
                ->withInput();
            //リダイレクトしたときに値を保持する
        }
        //dd確認済み。


        $param = [
            'name' => $request->name,
            'comment' => $request->comment,
        ];
        $uploadfile = $request->file('image_path');
        if (!empty($uploadfile)) {
            $image_path = $uploadfile->hashName();
            $uploadfile->storeAs('public/user', $image_path);
            $param['image_path'] = $image_path;
        }
        // dd($param);
        User::where('id', $request->user_id)->update($param);
        //

        return redirect(route('user.userEdit'))->with('success', '保存しました。');
    }

    public function test()

    {
        return view('child');
    }

    public function common()

    {
        return view('common');
    }
}
