<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Article;
use App\Follow;
use App\Comment;
use App\Token;
use App\Role;
use DB;
use Illuminate\Pagination;

use Validator;

class Usercontroller extends Controller
{
      /**
     * @OA\Post(
     *     path="/create",
     *     operationId="create user",
     *     description="Creates a new user",
     *     @OA\RequestBody(
     *         description="user added",
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
    {   $role= Role::where('name','=','user')->value('roleid');
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
        $user->roleid=$role;
        $user->save();
        return response()->json(array("status"=>true,
        "data"=>$user,
        "message"=> "You have successfully registered"));
    }
    /**
     * @OA\Post(
     *     path="/createArticle",
     *     operationId="create Article",
     *     description="Creates a new Article",
     *     @OA\RequestBody(
     *         description="Article added",
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
  

    public function createArticle(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'title' =>'required',
        'description'=>'required'
        ]);
        if($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()],401);
        }

      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->value('roleid');
      $role= Role::where('roleid','=',$roleid)->value('name');
        if(($role)=='user')
      {
        $userid= $request->userid;
        $article = new Article;
        $article->userid = $userid;
        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->save();
        return response()->json(array("status"=>true,
        "data"=>$article,
        "message"=> "Article created successfully"));
      }
      else
        {
          return response()->json(array("status"=> false, "message"=>"unauthorised"));
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
        $role= Role::where('roleid','=',$roleid)->value('name');
        $show= Article::where('userid','=',$userid)->simplePaginate(2);
        if(($role)=='user')
        {
          
             if(($check)>0) 
            {
          
                $data= Follow::join('articles','articles.userid','=','follow.follow')
               ->where('follow.userid','=',$userid)
               ->select('articles.userid','articles.title','articles.description')->paginate(2);
               return response()->json(array("status"=>true,
               'My article'=>$show,
               'User article'=>$data
                ));
        
            }
              else 
             {
                $data= Article::select('userid')->get();
                return response()->json(array("status"=> true,
               'My article'=>$show,
               "article posted by"=>$data,
                'message'=> 'To view the articles you have to follow the individual'));
               }
       }
      else 
         {
            return response()->json(array("status"=> false,
          "message"=>"unauthorised"));
         }
      }
      /**
     * @OA\Post(
     *     path="/comment",
     *     operationId="comment on article",
     *     description="comment on article",
     *     @OA\RequestBody(
     *         description="comment added",
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
    public function comment(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'comment' =>'required',
        'articleid'=> 'required']);
        if($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()],401);
        }
      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->value('roleid');
      $check= Follow::where('userid','=',$userid)->get()->count();
      $role= Role::where('roleid','=',$roleid)->value('name');
      if(($role)=='user' )
      {
            if(($check)>0)
             {
              $comment = new Comment ;
              $comment->userid = $userid;
              $comment->articleid=$request->input('articleid');
              $comment->comment= $request->input('comment');
              $comment->save();
              return response()->json(array("status"=>true,
              "data"=>$comment,
              "message"=> "successful"));
            }
            else
            {
              return response()->json(array("status"=> false,
            "message"=> "You have to follow a individual to comment on a article"));
            }
        }
        else 
        {
          return response()->json(array("status"=> false,"message"=>"Unauthorized"));
        }
    }
    /**
     * @OA\Post(
     *     path="/follow",
     *     operationId="follow",
     *     description="follow a individual to view the articles",
     *     @OA\RequestBody(
     *         description="following the individual",
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

    public function follow(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'follow' =>'required'
        ]);
        if($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()],401);
        }
      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->value('roleid');
      $role= Role::where('roleid','=',$roleid)->value('name');
      $check= Follow::where('userid','=', $userid)->value('follow');
      
      if(($role)=='user')
      {
        if(($check)>0)
        {
          return response()->json(array("status"=> false,"message"=>"Already followed"));
        }
        else 
           {

             $follow = new Follow;
             $follow->userid = $userid;
             $follow->follow = $request->input('follow');
             $follow->save();
             return response()->json(array("status"=>true,
              "data"=>$follow,
              "message"=> "followed to userid ".$follow->follow ));
            }
      }
      else{
        return response()->json(array("status"=> false,"message"=>"Unauthorized"));
      }
    }
    /**
     * @OA\Post(
     *     path="/unfollow",
     *     operationId="unfollow",
     *     description="unfollow a individual",
     *     @OA\RequestBody(
     *         description="unfollow the individual",
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
    public function unfollow(Request $request)
    { 
      $validator = Validator::make($request->all(), [
        'unfollow' =>'required'
        ]);
        if($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()],401);
        }
      $userid= $request->userid;
      $roleid= Token::where('userid','=', $userid)->value('roleid');
      $role= Role::where('roleid','=',$roleid)->value('name');
      if(($role)=='user')
      {
      $delete=$request->input('unfollow');
      Follow::where('follow', '=', $delete)->select('userid','=',$userid)->delete();
      return response()->json(array("status"=>true,
             "message"=>"unfollowed to the userid ".$delete ));
      }
      else
      {
        return response()->json(array("status"=> false,"message"=>"Unauthorized"));
      }
    }
    /**
     * @OA\Put(
     *     path="/update",
     *     operationId="update Article",
     *     description="update a existing Article",
     *     @OA\RequestBody(
     *         description="update Article",
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
  public function update(Request $request,$id)
   { 
    $validator = Validator::make($request->all(), [
      'title' =>'required',
      'description'=>'required'
      ]);
      if($validator->fails())
      {
      return response()->json(['error'=>$validator->errors()],401);
      }
        $userid= $request->userid;
        $roleid= Token::where('userid','=', $userid)->value('roleid');
        $role= Role::where('roleid','=',$roleid)->value('name');
        if(($role)=='user')
         {
          
         $article= Article::find($id);
         $user= Article::where('id','=',$id)->value('userid');
         if($userid==$user)
         {
           
         $article->title = $request->input('title');
         $article->description = $request->input('description');
         $article->save();
         return response()->json(array("status"=>true,
              "data"=>$article,
              "message"=> "successfully updated"));
         }
         else
           {
            return response()->json(array("status"=> false,"message"=>"Unauthorized"));
           }
         
      }
   else
      {return response()->json(array("status"=> false,"message"=>"Unauthorized"));
      }

  }
  /**
     * @OA\Get(
     *     path="/adminView",
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
      public function adminView(Request $request)
        {
        $userid= $request->userid;
        $roleid= Token::where('userid','=', $userid)->value('roleid');
        $role= Role::where('roleid','=',$roleid)->value('name');
        if(($role)=='admin')
         {
               $data= User::with('article')->paginate(5);
               return response()->json(array("status"=>true,
              "data"=>$data
              ));
         }
        else
         {
          return response()->json(array("status"=> false,"message"=>"Unauthorized"));
         }
      }
      /**
     * @OA\Delete(
     *     path="/adminDeleteArticle",
     *     operationId="admin delete article",
     *     description="delete a Article",
     *     @OA\RequestBody(
     *         description="Article deleted",
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
    public function adminDeleteArticle(Request $request)
      {
        $validator = Validator::make($request->all(), [
          'articleid' =>'required'
          ]);
          if($validator->fails())
          {
          return response()->json(['error'=>$validator->errors()],401);
          }
          $userid= $request->userid;
          $roleid= Token::where('userid','=', $userid)->value('roleid');
          $role= Role::where('roleid','=',$roleid)->value('name');
          if(($role)=='user')
            {
                 $delete=$request->input('articleid');
                 //DB::table('articles')->where('id', '=',$delete )->delete();
                   Article::where('id', '=',$delete )->delete();
                   return response()->json(array("status"=>true,
                   "data"=>$delete,
                   "message"=> "successfully deleted"));
            }
          else
             {
              return response()->json(array("status"=> false,"message"=>"Unauthorized"));
             }

    }
    /**
     * @OA\Delete(
     *     path="/logout",
     *     summary="logout from the account",
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
    public function logout(Request $request)
    {
      $userid= $request->userid;
       Token::where('userid','=', $userid)->delete();
      return response()->json(array("status" =>true,
    "message"=>"successfully logged out"));

    }
}
