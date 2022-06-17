<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator, DB;
use App\Models\User;

class RegisterController extends BaseController
{

  public function login(Request $request)
  {

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

      $user = Auth::user();
      $success['token'] = $user->createToken('App')->accessToken;
      $success['usunombre'] = $user->usunombre;

      return $this->sendResponse($success, 'Usuario logeado.');

    } else {

      return $this->sendError('No autorizado', ['error' => 'No autorizado']);

    }

  }

  public function logout()
  {
      auth()->user()->tokens->each(function ($token, $key) {
          $token->delete();
      });

      return response()->json('Sesión cerrada', 200);
  }

}
