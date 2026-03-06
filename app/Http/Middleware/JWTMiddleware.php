<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use App\Helpers\AuthorizeUser;
use App\Models\Customer;
use App\Models\Staff;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return ApiResponse::error('Token expired.', 401);
        } catch (TokenInvalidException $e) {
            return ApiResponse::error('Invalid token.', 401);
        } catch (JWTException $e) {
            return ApiResponse::error('Token not provided.', 401);
        }

        if ($request->role_id == 4) {

            $user = Customer::find($request->user_id);

            if (! $user) {
                return ApiResponse::error('User not found.', 401);
            }

            $userAuthorize = AuthorizeUser::authorizeUser($user->id, 'customer_api');
            if (! $userAuthorize) {
                return ApiResponse::error('Unauthorized User.', 401);
            }

        } else {

            $user = Staff::find($request->user_id);

            if (! $user) {
                return ApiResponse::error('User not found.', 404);
            }

            $userAuthorize = AuthorizeUser::authorizeUser($user->id, 'staff_api');
            if (! $userAuthorize) {
                return ApiResponse::error('Unauthorized User.', 401);
            }

        }

        return $next($request);
    }
}
