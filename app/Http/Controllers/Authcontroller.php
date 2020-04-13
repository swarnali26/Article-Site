<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use App\Token;
use Validator;
use DB;
class Authcontroller extends Controller
{
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
         'email' =>'required|email',
         'password' =>'required',
         ]);
        if($validator->fails())
      {
        return response()->json(
          ['error'=>$validator->errors()],401
         );
      }

          $email=$request->input('email');
          $password=md5($request->input('password'));
          $check= User::where('email',$email)->where('password',$password)->get()->count();
          if(($check)>0)
          {
            $data= User::where('email',$email)->where('password',$password);
            $userid=$data->value('userid');
            $role =$data->value('roleid');
            
           $token = $this->insertToken($userid,$role);
           return response()->json(array("status" =>"ok",
          "token"=> $token
          ));
          }
          else
          {
            return response()->json(array("status" =>false));
          }
    
    }
   
    public function insertToken($userid,$role)
    {
      
        $temp_token = Str::random(20);
        $token = new Token;
        $token->userid =$userid;
        $token->token= $temp_token;
        $token->roleid= $role;
        $token->save();
        return  $temp_token ;
        
        
    }
 }