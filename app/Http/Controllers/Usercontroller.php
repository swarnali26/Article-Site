<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Article;
use App\Follow;
use DB;
class Usercontroller extends Controller
{
  
  public function create(Request $request)
  {   
      $validator = Validator::make($request->all(), [
      'firstname'=>'required|min:3|regex:/^[a-zA-Z]+$/u',
      'lastname'=>'required|min:2|regex:/^[a-zA-Z]+$/u',
      'email' =>'required|email|unique:users',
      'password' =>'required',
      'phone'=>'required|numeric|min:10|max:10',
       ]);
      if($validator->fails())
    {
     return response()->json(
        [ 'firstname.required'=>'field is required', 
          'firstname.min'=>'firstname should contain minimum 3 letter',
          'firstname.regex'=>'only character allowed',
          'lastname.required'=>'field is required', 
          'lastname.min'=>'only character allowed', 
          'lastname.regex'=>'only character allowed',
          'email.required'=>'field is required',
          'email.email'=> 'The email must be a valid email address',
          'email.unique'=> 'The email has already been taken',
          'password.required'=>'field is required',
          'phone.required'=>'field is required',
          'phone.min'=>'field contain minimum 10 number',
          'phone.max'=>'field contain maximum 10 number',
          'phone.numeric'=>'only numbers allowed'
        ]
        );
    }
      $user = new User;
      $user->firstname = $request->input('firstname');
      $user->lastname = $request->input('lastname');
      $user->email = $request->input('email');
      $user->password = md5($request->input('password'));
      $user->phone = $request->input('phone');
      $user->roleid=2;
      $user->save();
       return response()->json($user);
  }
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
    
 public function adminView()
 {
  $data= User::with('article')->find(1);
  return response()->json($data);
}
 public function adminDeleteArticle(Request $request)
{
  $delete=$request->input('articleid');
  DB::table('articles')->where('articleid', '=',$delete )->delete();

}
    
}
