<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        //get token from cookie
        $token = $request->cookie('token');
        //if no token try to get token from header
        if(!$token){
            preg_match('/^Bearer (.*)$/i', $request->header('authorization'), $match);
            if(count($match) > 0){
                $token = $match[1];
            }
        }

        //if not token from cookie or header return error
        if(!$token){
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        //check if token is valid
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 401);
        }

        
        //TODO: implement XSRF checking
        if($request->header('X-XSRF-TOKEN')){
            
        }

        $request->auth = $credentials;
        return $next($request);
    }
}
