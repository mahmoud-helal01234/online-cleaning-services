<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AuthenticateClient extends BaseMiddleware
{
    use ResponsesTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles )
    {

        try {

            Config::set('jwt.user', 'App\Models\Client');
            Config::set('auth.providers.users.model', \App\Models\Client::class);


            // $user = JWTAuth::parseToken()->authenticate();
            $user = auth()->guard('authenticate-clients')->user();

            if(!$user){
                throw new Exception();
            }

            // return $this->apiResponse(null,false,json_encode($user),401);
            if(isset($user->role) ){

                throw new \Exception();
            }

        } catch (Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->apiResponse(null,false,"Token is Invalid ",401);

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->apiResponse(null,false,"Token is Expired ",401);

            }else{
                return $this->apiResponse(null,false,"Authorization Token not found ",401);

            }
        }

        return $next($request);
    }
}
