<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Events\TokenExpired;
class IsAuthenticated extends BaseMiddleware
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

            $user = null;

            // check if clients has permission
            if( empty($roles) || in_array( "client",$roles)){ // check if this api can be used by clients

                // authorize if logged in user is client
                // Config::set('jwt.user', 'App\Models\Client');
                // Config::set('auth.providers.users.model', \App\Models\Client::class);

                $user = auth()->guard('authenticate-clients')->user();

            }

            if(!$user ){

                    // // Check if the token has expired
                    // if ($token->isExpired()) {
                    //     // Dispatch the TokenExpired event
                    //     event(new TokenExpired($token));
                    // }
                // Config::set('jwt.user', 'App\Models\User');
                // Config::set('auth.providers.users.model', \App\Models\User::class);

                $user = auth()->guard('authenticate')->user();
                if(!$user)
                    throw new Exception();
                // check if the role is assigined in parameter
                if( !empty($roles) && !in_array( $user->role,$roles) )
                    return $this->apiResponse(null,false,"user is not authorized to open this ",403);

            }
            if($user->active != 1)
                return $this->apiResponse(null,false,"your account is deactivated ",403);

        } catch (Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->apiResponse(null,false,"Token is Invalid ",401);

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->apiResponse(null,false,"Token is Expired ",401);

            }else{
                return $this->apiResponse(null,false,"Token is Invalid",401);

            }
        }

        return $next($request);
    }
}
