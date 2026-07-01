<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentAccess
{
    public function handle(Request $request, Closure $next, $page = null): Response
    {
        $departmentId = session('department_id');

        if (!$departmentId) {

            return redirect()->route('login');
        }

        $access = config('access.page');

        $allowedPages = $access[$departmentId] ?? [];

        if ($page && !in_array($page, $allowedPages)) {

            abort(403, 'Access Denied');
        }

        return $next($request);
    }
}