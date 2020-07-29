<?php

namespace App\Http\Middleware;

use Closure;


class Cors {    public function handle($request, Closure $next)
    {
        header("Access-Control-Allow-Origin: *");
        //ALLOW OPTIONS METHOD
        $headers = [
            'Access-Control-Allow-Methods' => 'POST,GET,OPTIONS,PUT,DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization, consumer-nonce,consumer-secret, consumer-key, consumer-device-id',
        ];
        if ($request->getMethod() == "OPTIONS"){
            //The client-side application can set only headers allowed in Access-Control-Allow-Headers
             $response = $next($request);
        }
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }
        return $response;

    } }
