<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination;
use App\User;
use App\Article;
use App\Token;
use App\Role;
use Validator;

class AdminController extends Controller
{
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

}