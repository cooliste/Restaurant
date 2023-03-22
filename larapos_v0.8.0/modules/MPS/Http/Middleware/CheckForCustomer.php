<?php

namespace Modules\MPS\Http\Middleware;

use Closure;
use Nwidart\Modules\Facades\Module;

class CheckForCustomer
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $shop = Module::find('Shop');
        if ($user && $user->customer_id && $shop && $shop->isEnabled() && $shop->json()->route) {
            return redirect($shop->json()->route);
        }
        return $next($request);
    }
}
