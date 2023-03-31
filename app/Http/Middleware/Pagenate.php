<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Pagenate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $data = $response->getData(true);

        if(isset($data['links'])){
            unset($data['links']); //links 빼기
        }

        if(isset($data['meta'], $data['meta']['links'])){
            unset($data['meta']['links']); // meta안에 links 빼기
        }

        $response->setData($data);

        return $response;

        //return $next($request);
    }
}
