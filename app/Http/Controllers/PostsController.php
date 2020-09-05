<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use App\Post;
use App\History;
use App\Tag;
use Config\InterventionImage;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class PostsController extends Controller
{
	public function add()
	{
		$tags = Tag::all();
		return view('posts.create', ['tags' => $tags]);
	}

	public function show()
	{
		$user = Auth::user();
		$posts = Post::where('user_id', $user->id)->paginate(3);
		dd($posts);
		//本人の情報を$userとしてユーザー情報取得
		// ポストのuser_idとログイン中のidが一致しているものを$postsとしておく
		return view('posts.show', ['posts' => $posts, 'user' => $user]);
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

	// 以下を追記
	public function create(Request $request)
	{
		$this->validate($request, Post::$rules);
		//  varidateのアクションを理解する
		//  Post::$rulesの記述の意味も理解する
		$post = new Post;
		$form = $request->all();

		// $formは画面から飛んできたパラメーターが格納されている配列
		// フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
		if (isset($form['image'])) {
			$path = Storage::disk('s3')->putFile('/', $form['image'], 'public');
			//DBにはファイルをそのまま保存しない
			//ファイル名だけ保存している
			$post->image_path = Storage::disk('s3')->url($path);
		} else {
			$post->image_path = null;
		}
		// フォームから送信されてきた_tokenを削除する
		unset($form['_token']);
		// フォームから送信されてきたimageを削除する
		unset($form['image']);
		//これ消しちゃって良いのか？目的は写真データを保存したい→画像データ自体はストレージで保存
		// データベースに保存する
		// dd($form);
		$post->fill($form);
		$post->user_id = Auth::user()->id;
		//postとidを紐付けていてidが保存されておらずエラーが出たため追加
		//ここで投稿したpostはログイン中のユーザーのものと紐づけられている
		$post->save();

		//下記タグに追加に際してこれで保存できる？
		//投稿したタグに紐づけてたタグも保存する。
		$post->tags()->attach($request->tags);
		//ルーティングでのメソッドと重複していそう？
		return redirect('posts/show');
	}

	public function index(Request $request)
	{
		$auth_user = Auth::user();
		$posts = Post::paginate(3);
		return view('posts.index', ['posts' => $posts, 'auth_user' => $auth_user,]);
	}

	public function edit(Request $request)
	{
		// News Modelからデータを取得する
		$post = Post::find($request->id);
		if (empty($post)) {
			abort(404);
		}
		$tags = Tag::all();
		return view('posts.edit', ['form' => $post, 'tags' => $tags,]);
	}

	public function update(Request $request)
	{
		$this->validate($request, Post::$rules_edit);
		$post = Post::find($request->id);
		$form = $request->all();

		// 既存のコード16
		if (isset($form['image'])) {
			// isset — 変数が宣言されていること、そして NULL とは異なることを検査する
			$path = Storage::disk('s3')->putFile('/', $form['image'], 'public');
			$post->image_path = Storage::disk('s3')->url($path);
			unset($form['image']);
			// unset関数は、定義した変数の割当を削除する関数です。
		} elseif (isset($request->remove)) {
			$post->image_path = null;
			unset($form['remove']);
			//   unset関数は、定義した変数の割当を削除する関数です。
		}
		unset($form['_token']);
		// 該当するデータを上書きして保存する
		$post->fill($form)->save();

		$post->tags()->sync($request->tags);

		// これで全て保存する。リレーションのあるものも全て保存されるのか。tagはきていないみたい
		// 以下を追記
		$history = new History;
		$history->post_id = $post->id;
		$history->edited_at = Carbon::now();
		$history->save();
		return redirect('posts/show/');
	}

	public function delete(Request $request)
	{
		// 該当するNews Modelを取得
		$post = Post::find($request->id);
		// 削除する
		$post->delete();
		return redirect('posts/index/');
	}
}
