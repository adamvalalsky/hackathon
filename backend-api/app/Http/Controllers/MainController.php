<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class MainController extends Controller
{
    public function postLogin(Request $request){

      //login or return with error
      if(Auth::attempt(['email' =>  'test@test.com', 'password' => 'test'])){
        return response([
          'user' => User::find(2),
        ], 200);
      }

      return response([
        'user' => false
      ], 403);
      }
}
