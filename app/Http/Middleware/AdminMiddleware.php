<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập và có quyền admin hay không
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        // Nếu không phải admin, chuyển hướng hoặc trả về lỗi
        return redirect('/products')->with('error', 'Bạn không có quyền truy cập trang này.');
        
    }
}
