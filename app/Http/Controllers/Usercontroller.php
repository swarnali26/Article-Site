<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Article;
use App\Follow;
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
        
        $userid= $request->userid;
        $article = new Article;
        $article->userid = $$userid;
        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->save();
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
