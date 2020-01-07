<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

  public function auth(Request $request){

    $this->validate($request, [
      'username'     => 'required|email',
      'password'     => 'required'
      ]);

      $user = User::where('email', $request->input('username'))->first();

      //if user doesn't exist
      if (!$user) {
        return response()->json(['error' => 'User does not exist.'], 400);
      }

      // Verify the password and generate the token
      if(password_verify($request->password, $user->password)) {

        $jwt = $this->jwt($user);

        $secure = "";
        if(isset($_SERVER['https'])){
          $secure = "Secure";
        }

        // TODO: add "SameSite=Strict;" to cookie when in production
        // TODO: Path=/api; needs to be tested on the UI as well

        return response()->json($jwt, 200)
          ->header("Set-Cookie", trim(sprintf("token=%s; Expires=%s; Max-Age=%d; HttpOnly; %s", $jwt['token'], date('f', strtotime($jwt['expire'])), env('JWT_MAXAGE'), $secure)));
      }

      //if bad request
      return response()->json(['error' => 'Email or password is wrong.'], 400);
    }

    public function getAuth(Request $request){

      $jwt = array(
        'token' => JWT::encode($request->auth, env('JWT_SECRET')),
        'expire' => date('c', $request->auth->exp)
      );

      return response()->json($jwt, 200);

    }

    public function getUser(Request $request){
      //$user = $request->user();
      $user = Auth::user();
      return response($user->toJson(), 200);
    }

    public function logout(){

        if (isset($_COOKIE['token'])) {
            unset($_COOKIE['token']);
            setcookie('token', '', time() - 3600, '/');
        }

        return response()->json(['message' => 'Logged out'], 200);
    }



    private function jwt(User $user){

      if(!env('JWT_SECRET') || !env('JWT_MAXAGE')){
        throw new \Exception('Missing enviroment authentication settings.');
      }

      $expire = time() + env('JWT_MAXAGE');
      $payload = array(
        'iss' => $_SERVER['SERVER_NAME'], // Full Server Domain
        'sub' => ['id' => $user->id, 'name' => $user->name], // Basic User object
        'iat' => time(), // Time when JWT was issued.
        'exp' => $expire, // Expiration time.
        'xsrf' => sha1($user->id . $user->name . $expire)
      );

      return array(
        'token' => JWT::encode($payload, env('JWT_SECRET')),
        'expire' => date('c', $expire)
      );

    }


    public function extend(Request $request){

      $user = User::find($request['user-id']);

        if (!$user) {
            return response()->json(['error' => 'User does not exist.'], 400);
        }elseif(Auth::user()->id != $user->id){
            return response()->json(['error' => 'User dont have permission.'], 400);
        }elseif(!Auth::user()->status){
            return response()->json(['error' => 'User not confirmed!'], 400);
        }

      $jwt = $this->jwt($user);

        $secure = "";
        if(isset($_SERVER['https'])){
            $secure = "Secure";
        }

        return response()->json($jwt, 200)
            ->header("Set-Cookie", trim(sprintf("token=%s; Expires=%s; Max-Age=%d; HttpOnly; %s", $jwt['token'], date('f', strtotime($jwt['expire'])), env('JWT_MAXAGE'), $secure)));
    }

  }
