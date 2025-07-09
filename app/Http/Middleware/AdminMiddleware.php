<?php

// app/Http/Middleware/AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Anda tidak memiliki hak akses admin.');
        }
        
        return $next($request);
    }
}
