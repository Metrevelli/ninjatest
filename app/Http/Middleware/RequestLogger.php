<?php

namespace App\Http\Middleware;

use App\Models\UserRequestLog;
use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = auth()->user()->id;
        $tokenId = UserToken::where('access_token', auth()->getTokenFromRequest())->first()->getId();
        $requestMethod = $request->getMethod();
        $requestParams = $request->all();

        UserRequestLog::create([
            'user_id' => $userId,
            'token_id' => $tokenId,
            'request_method' => $requestMethod,
            'request_params' => $requestParams,
        ]);

        return $next($request);
    }
}
