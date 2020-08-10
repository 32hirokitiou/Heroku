<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\User;
use App\Post;
use App\History;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

//ユーザー情報を受け渡ししている
class PostsController extends Controller
{
    
        public function add()
        {
            return view('posts.create');
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
						$path = $request->file('image')->store('public/image');
						//DBにはファイルをそのまま保存しない
						//ファイル名だけ保存している
						$post->image_path = basename($path);
					} else {
						$post->image_path = null;
					}
					// フォームから送信されてきた_tokenを削除する
					unset($form['_token']);
					// フォームから送信されてきたimageを削除する
					unset($form['image']);
					//これ消しちゃって良いのか？目的は写真データを保存したい→画像データ自体はストレージで保存
					// データベースに保存する
					$post->fill($form);
					$post->save();
					// admin/news/createにリダイレクトする

					return redirect('posts/create');
		}
		




    
		public function index(Request $request)
		{
			$title = $request->title;
			if ($title != '') {
				// 検索されたら検索結果を取得する
				//画像も表示したい
				$posts = Post::where('title', $title)->get();
			} else {
				// それ以外はすべてのニュースを取得する
				$posts = Post::all();
			}
			return view('posts.index', ['posts' => $posts, 'title' => $title]);
		}
    
			public function edit(Request $request)
		{
			// News Modelからデータを取得する
			$post = Post::find($request->id);
			if (empty($post)) {
				abort(404);    
			}
			return view('posts.edit', ['form' => $post]);
		}


		public function update(Request $request)
		{
			$this->validate($request, Post::$rules);
			$post = Post::find($request->id);
			$form = $request->all();

			// 既存のコード16
			if (isset($form['image'])){
				// isset — 変数が宣言されていること、そして NULL とは異なることを検査する
				$path = $request->file('image')->store('public/image');
				$post->image_path = basename($path);
				unset($form['image']);
				// unset関数は、定義した変数の割当を削除する関数です。
			} elseif (isset($request->remove)) {
				$post->image_path =null;
				unset($form['remove']);
				//   unset関数は、定義した変数の割当を削除する関数です。
			} 
			unset($form['_token']);
			// 該当するデータを上書きして保存する
			$post->fill($form)->save();


			//   教材のコード17
			// if ($request->remove == 'true') {
			//     $form['image'] = null;
			//     //if remove だったら image をnullにする
			// } elseif ($request->file('image')) {
			//     // if fileにimageが入っていたら
			//     $path = $request->file('image')->store('public/image');
			//     $form['image'] = basename($path);
			//     //$path にデータを保存する
			// } else {
			//     $form['image'] = $post->image;
			// }
			//  unset($form['_token']);
			//  unset($form['image']);
			//  unset($form['remove']);
			//  $post->fill($form)->save();

			// 以下を追記
			$history = new History;
			$history->post_id = $post->id;
			$history->edited_at = Carbon::now();
			$history->save();
			return redirect('posts/index/');
		}

		public function delete(Request $request)
		{
			// 該当するNews Modelを取得
			$post = Post::find($request->id);
			// 削除する
			$post->delete();
			return redirect('posts/index/');
		}  
		

		public function store(Request $request)
		{
			// $post = $request->validate([
			// 	'title' => 'required|max:50',
			// 	'body' => 'required|max:2000',
			// ]);
	
			// #(ハッシュタグ)で始まる単語を取得。結果は、$matchに多次元配列で代入される。
			//preg_match_allはパターンにマッチした場合は1を返し、マッチしなかったら0を返します。
			preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $request->tags, $match);
			// $match[0]に#(ハッシュタグ)あり、$match[1]に#(ハッシュタグ)なしの結果が入ってくるので、$match[1]で#(ハッシュタグ)なしの結果のみを使います。
			$tags = [];
			//空の配列を用意?なぜエラーなのか
			foreach ($match[1] as $tag) {
				$record = Tag::firstOrCreate(['name' => $tag]);// firstOrCreateメソッドで、tags_tableのnameカラムに該当のない$tagは新規登録される。
				array_push($tags, $record);// $recordを配列に追加します(=$tags)
				 //array_push()は配列の末尾に要素を追加する関数です。ex)$tagの末尾に$recordを追加している
			};
	
			// 投稿に紐付けされるタグのidを配列化
			$tags_id = [];
			foreach ($tags as $tag) {
				array_push($tags_id, $tag['id']);
			};
			$post->tags()->attach($tags_id);// 投稿ににタグ付するために、attachメソッドをつかい、モデルを結びつけている中間テーブルにレコードを挿入します。// 投稿はposts_tableへレコードしましょう。
			$post = new Post;
			$post->title = $request->title;
			// $post->body = $request->body; bodyはないので必要ない。
			$post->user_id = Auth::user()->id;
			$post->save();
			return redirect()->route('top');
		}
}
