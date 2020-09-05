<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
  // protected $fillable = [
  // 'image', 'title',
  // ];

  // 以下を教材から追加
  protected $guarded = ['id', 'tags'];

  public static $rules = [
    'title' => 'required',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:max_width=5000,',
  ];

  public static $rules_edit = [
    'title' => 'required',
  ];


  // Postモデルに関連付けを行う
  public function histories()
  {
    return $this->hasMany('App\History');
  }

  public function tags()
  {
    return $this->belongsToMany('App\Tag', 'post_tag', 'post_id');
    // ->using('App\PostTag');
  }

  public function post_tags()
  {
    return $this->hasMany('App\PostTag');
    // ->using('App\PostTag');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
