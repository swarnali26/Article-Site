<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follow;
use App\Token;
use App\Role;
use Mail;
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
     {   
         $role= Role::where('name','=','user')->value('roleid');
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
        Mail::raw('Welcome, you have sucessfully registered!',function($message)
        {
            $message->to('swarnali.marik@gmail.com')->subject('Article Site');
            $message->from('swarnali.marik5@gmail.com');

        });
        return response()->json(array("status"=>true,
        "data"=>$user,
        "message"=> "Mail has been sent"));
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
      else
      {
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
    
  
    public function logout(Request $request)
    {
      $userid= $request->userid;
      Token::where('userid','=', $userid)->delete();
      return response()->json(array("status" =>true,
      "message"=>"successfully logged out"));

    }
}
