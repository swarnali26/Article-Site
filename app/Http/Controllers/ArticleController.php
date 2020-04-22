<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination;
use App\User;
use App\Article;
use App\Follow;
use App\Token;
use App\Role;
use Validator;

class ArticleController extends Controller
{
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
        if(!$request->hasFile('image')) 
          {
            $image= 'null';
           }
        else 
         {
           $image= $this->uploadImage($request);
         }
         $article->image= $image;
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
    public function uploadImage(Request $request)
      {
        
         $file = $request->file('image');
         if(!$file->isValid()) 
          {
             return response()->json(['invalid_file_upload'], 400);
          }
         $filename=$file->getClientOriginalName();
         $path = $request->image->storeAs('upload',$filename,'public');
         $imagepath= app('url')->asset("/upload/".$filename); 
         return $imagepath;
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
        $show= Article::where('userid','=',$userid)->simplePaginate(5);
        if(($role)=='user')
        {
          
             if(($check)>0) 
            {
          
                $data= Follow::join('articles','articles.userid','=','follow.follow')
               ->where('follow.userid','=',$userid)
               ->select('articles.userid','articles.title','articles.description')->paginate(5);
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
     {
        return response()->json(array("status"=> false,"message"=>"Unauthorized"));
     }

 }
}