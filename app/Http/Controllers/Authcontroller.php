<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Token;

use DB;
class Authcontroller extends Controller
{
    public function create(Request $request)
    {
        $user = new User;
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->phone = $request->input('phone');
        $user->save();
         return response()->json($user);
    }
    
    public function login(Request $request)
    {
          $email=$request->input('email');
          $password=$request->input('password');
          $check= User::where('email',$email)->where('password',$password)->get()->count();
          if(($check)>0)
          {
            $data= User::where('email',$email)->where('password',$password);
            $userid=$data->value('userid');
            $role =$data->value('roleid');
            $this->Generatetoken($userid,$role);
          }
          else
          {
               echo "not invalid";
          }
    
    }
    public function Generatetoken($userid,$role)
    {
        $x=$userid;
        
        $y=$role;
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $token = ''; 
      
        for ($i = 0; $i < 10; $i++) 
        { 
            $index = rand(0, strlen($characters) - 1); 
            $token .= $characters[$index]; 
        }
             $this->Inserttoken($token,$x,$y);
    }
    public function Inserttoken($token,$x,$y)
    {
        $token=$token;
        $userid=$x;
        $role=$y;
        
        
        DB::table('tokens')->insert(['userid'=>$userid, 'token'=>$token,'roleid'=>$role]);
        //  $token = new Token;
        //  $token->userid= $userid;
        //  $token->token= $token;
        //  $token->roleid= $role;
        //  $token->save();
        //  echo "ok";
        return response()->json(array("status" =>"ok"));
    }
 }