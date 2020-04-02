<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Article;
use App\Follow;
use App\Comment;
use App\Token;
use DB;
use Validator;

class Usercontroller extends Controller
{
      /**
     * @OA\Post(
     *     path="/create",
     *     operationId="create user",
     *     description="Creates a new user",
     *     @OA\RequestBody(
     *         description="Pet to add to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *       
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Created response",
     *     
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *     
     *     )
     * )
     */
    public function create(Request $request)
    {   
        $validator = Validator::make($request->all(), [
        'firstname'=>'required|min:3|regex:/^[a-zA-Z]+$/u',
        'lastname'=>'required|min:2|regex:/^[a-zA-Z]+$/u',
        'email' =>'required|email|unique:users',
        'password' =>'required',
        'phone'=>'required',
        ]);
        if($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()],401);
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
      $check= Follow::where('userid','=',$userid)->get()->count();
        
      if(($roleid)=='2')
      {
        $userid= $request->userid;
        $article = new Article;
        $article->userid = $$userid;
        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->save();
        return response()->json("ok",200);
      }
      else
        {
          return response()->json("Unauthorized",401);
        }

    }
    
   /**
     * @OA\Get(
     *     path="/showarticles",
     *     summary="get article list",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pet")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     )
     * )
     */
    public function showArticle(Request $request)
    {
        $userid= $request->userid;
        $roleid= Token::where('userid','=', $userid)->value('roleid');
        $check= Follow::where('userid','=',$userid)->get()->count();
        
        if(($roleid)=='2')
        {
          
        if(($check)>0) 
        {
          $data= DB::table('follow')->join('articles','articles.userid','=','follow.follow')
          ->where('follow.userid','=',$userid)
          ->select('articles.userid','articles.title','articles.description')->get();
          return response()->json($data);
        
        }
        else {
          $data= Article::select('userid')->get();
          return response()->json($data);
          $this->follow($followedby,$request);

        }
      }
      else {
        return response()->json("Unauthorized",401);
      }
      }
      
      
    public function comment(Request $request)
    {
      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->select('roleid');
      $check= Follow::where('userid','=',$userid)->get()->count();
        if(($check)>0)
        {
          if(($roleid)=='2')
         DB::table('comments')->insert(['userid'=>$userid, 'comment'=>$comment]);
          return response()->json("ok",200);
        }
        else 
        {
          return response()->json("Unauthorized",401);
        }
    }

    public function follow(Request $request)
    {
      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->value('roleid');
      
      if(($roleid)=='2')
      {
      $follow = new Follow;
      $follow->userid = $userid;
      $follow->follow = $request->input('follow');
      $follow->save();
      return response()->json("ok",200);
      }
      else{
        return response()->json("Unauthorized",401);
      }
    }
    public function unfollow(Request $request)
    { 
      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->value('roleid');
      if(($roleid)=='2')
      {
      $delete=$request->input('follow');
      DB::table('follow')->where('follow', '=', $delete)->select('userid','=',$userid)->delete(); 
      return response()->json(array("status" =>"unfollowed"));
      }
      else
      {
      return response()->json("Unauthorized",401);
      }

    }
    
    public function adminView(Request $request)
    {
      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->value('roleid');
      
      if(($roleid)=='1')
      {
      $data= User::with('article')->get();
      return response()->json($data);
      }
      else
       {
      return response()->json("Unauthorized",401);
       }
    }
    public function adminDeleteArticle(Request $request)
    {
      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->value('roleid');
      
      if(($roleid)=='1')
      {
      $delete=$request->input('articleid');
      
      DB::table('articles')->where('id', '=',$delete )->delete();
      
      return response()->json(array("status" =>"deleted"));
      }
      else
      {
     return response()->json("Unauthorized",401);
      }

    }
    
}
