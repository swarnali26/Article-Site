<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Follow;
use App\Comment;
use App\Token;
use App\Role;
use Validator;

class CommentController extends Controller
{
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
}