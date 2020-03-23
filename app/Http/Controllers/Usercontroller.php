<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Article;
use App\Follow;
use DB;
class Usercontroller extends Controller
{
    public function createArticle(Request $request)
    {
        
        $userid= $request->userid;
        $article = new Article;
        $article->userid = $$userid;
        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->save();
    }
    public function showArticle()
    {
        $userid= $request->userid;
        $check= Follow::where('followedby','=',$userid)->get()->count();
        if(($check)>0)
        {
          $data= DB::table('follow')->join('articles','articles.userid','=','follow.follow')
          ->where('follow.userid','=',$userid)
          ->select('articles.title','articles.description')->get();
          $comment=$request->input('comment');
          DB::table('comments')->insert(['userid'=>$userid, 'comment'=>$comment]);
          echo $data;
        
        }
        else {
          $data= Article::pluck('userid');
          echo $data;
          $this->follow($followedby,$request);

        }
        
    }
    public function follow(Request $request)
    {
      
      $userid= $request->userid;
      $follow = new Follow;
      $follow->userid = $userid;
      $follow->follow = $request->input('follow');
      $follow->save();
    }
    public function unfollow(Request $request)
    {
      $userid= $request->userid;
      $delete=$request->input('follow');
      DB::table('follow')->select('userid','=',$userid)->where('follow', '=', $delete)->delete();  
    }
    
 public function Adminview()
 {
  $data= User::with('article')->find(1);
  return response()->json($data);
}
 public function AdminDeleteArticle(Request $request)
{
  $delete=$request->input('articleid');
  DB::table('articles')->where('articleid', '=',$delete )->delete();

}
    
}
