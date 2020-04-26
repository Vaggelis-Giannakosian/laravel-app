<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $locale = null;

        if(  $request->hasCookie('locale') )
        {
            $locale = Cookie::get('locale');
            Session::put('locale',$locale);
        }

        if( Auth::check() && !Session::has('locale') )
        {
            $locale = $request->user()->locale;
            Session::put('locale',$locale);
        }

        if($request->has('locale'))
        {
            $locale = $request->get('locale');
            Session::put('locale',$locale);
        }


        $locale = Session::get('locale');

        if(null === $locale)
        {
            $locale = config('app.fallback_locale');
        }

        Cookie::queue('locale', $locale, 60*24*7);
        App::setLocale($locale);

        return $next($request);
    }
}
