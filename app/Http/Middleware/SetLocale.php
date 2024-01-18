<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Content-Language');

        if (in_array($locale, Language::pluck('locale')->toArray())) {
            App::setLocale($locale);
        } else {
            throw new Exception('Locale not found', Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
