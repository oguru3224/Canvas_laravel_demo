<?php

namespace App\Http\Middleware;

Class UpgradeToHttpUnderNgrok extends Middleware{
    public function handle(Request $request, Closure $next): Response
        {
        if (str_ends_with($request->getHost(), '.ngrok-free.app')) {
            URL::forceScheme('https');
        }

        return $next($request);
        }
}
