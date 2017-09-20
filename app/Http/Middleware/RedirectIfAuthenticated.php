<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /*
        if we are logged in as admins and we go to a page which is protected by the admin guest middleware like app-link/admin/login
          the guest middleware says u can't do this u already logged in as admin so it redirects us to  app-link/admin
          and because we aren't logged in as users it ends up sending us to the normal login page app-link/login
        */

        switch ($guard) {
          case 'admin':
            if (Auth::guard($guard)->check())
            //if they're logged in as $guard, 'admin' in this case
            {
              return redirect()->route('admin.dashboard');
            }
            break;

          default: // 'web' in this case
            if (Auth::guard($guard)->check()) {
                return redirect('/');
              }
            break;
        }

        return $next($request);
    }
}
